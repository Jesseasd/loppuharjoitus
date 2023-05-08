<?php
include "dbconnection.php";
$dbcon = createDbConnection();

$artist_id = 277;

try {

    $statement = $dbcon->prepare("SELECT Name FROM artists WHERE ArtistId = ?");
    $statement->execute(array($artist_id));
    $artist = $statement->fetchColumn();

    $statement = $dbcon->prepare("SELECT AlbumId, Title FROM albums WHERE ArtistId = ?");
    $statement->execute(array($artist_id));
    $albums = $statement->fetchAll(PDO::FETCH_ASSOC);

    foreach ($albums as $album) {
        $statement = $dbcon->prepare("SELECT Name FROM tracks WHERE AlbumId = ?");
        $statement->execute(array($album['AlbumId']));
        $album_tracks = $statement->fetchAll(PDO::FETCH_COLUMN);
        $tracks[] = array(
            'title' => $album['Title'],
            'tracks' => $album_tracks
        );
    }

    $response = array(
        'artist' => $artist,
        'albums' => $tracks
    );

    header('Content-Type: application/json');
    echo json_encode($response);

} catch (PDOException $e) {
    $e->getMessage();
}
