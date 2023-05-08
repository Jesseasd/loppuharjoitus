<?php
include "dbconnection.php";
$dbcon = createDbConnection();

try {
    $artist = filter_input(INPUT_POST, 'artist');
    $album = filter_input(INPUT_POST, 'album');
    $tracksString = filter_input(INPUT_POST, 'tracksString');

    $sql = "INSERT INTO artists (Name) VALUES (:artist)";
    $statement = $dbcon->prepare($sql);
    $statement->bindParam(':artist', $artist);
    $statement->execute();
    $artistId = $dbcon->lastInsertId();

    $sql = "INSERT INTO albums (Title, ArtistId) VALUES (:album, :artistId)";
    $statement = $dbcon->prepare($sql);
    $statement->bindParam(':album', $album);
    $statement->bindParam(':artistId', $artistId);
    $statement->execute();
    $albumId = $dbcon->lastInsertId();

    $tracks = explode(',', $tracksString);
    foreach ($tracks as $track) {
        $sql = "INSERT INTO tracks (Name, AlbumId, MediaTypeId, Milliseconds, UnitPrice) VALUES (:track, :albumId, 5, 100000, 0.99)";
        $statement = $dbcon->prepare($sql);
        $statement->bindParam(':track', $track);
        $statement->bindParam(':albumId', $albumId);
        $statement->execute();
    }

} catch (PDOException $e) {
    $e->getMessage();
}