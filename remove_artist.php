<?php
include "dbconnection.php";
$dbcon = createDbConnection();

function deleteArtist($artist_id) {
    global $dbcon;

    try {

        $dbcon->beginTransaction();

        $statement = $dbcon->prepare("
            DELETE FROM invoice_items WHERE TrackId IN (
                SELECT TrackId
                FROM tracks
                WHERE AlbumId IN (
                    SELECT AlbumId
                    FROM albums
                    WHERE ArtistId = ?
                )
            )
        ");
        $statement->execute(array($artist_id));

        $statement = $dbcon->prepare("
            DELETE FROM playlist_track WHERE TrackId IN (
                SELECT TrackId
                FROM tracks
                WHERE AlbumId IN (
                    SELECT AlbumId
                    FROM albums
                    WHERE ArtistId = ?
                )
            )
        ");
        $statement->execute(array($artist_id));

        $statement = $dbcon->prepare("
            DELETE FROM tracks WHERE AlbumId IN (
                SELECT AlbumId
                FROM albums
                WHERE ArtistId = ?
            )
        ");
        $statement->execute(array($artist_id));

        $statement = $dbcon->prepare("DELETE FROM albums WHERE ArtistId = ?");
        $statement->execute(array($artist_id));

        $statement = $dbcon->prepare("DELETE FROM artists WHERE ArtistId = ?");
        $statement->execute(array($artist_id));

        $dbcon->commit();

    } catch (PDOException $e) {
        $dbcon->rollBack();
        $e->getMessage();
    }
}

deleteArtist(306);