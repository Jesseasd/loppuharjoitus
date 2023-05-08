<?php
include "dbconnection.php";
$dbcon = createDbConnection();

$playlist_id = 17;

try {

    $sql = "SELECT * FROM tracks WHERE TrackId IN (
            SELECT TrackId FROM playlist_track
            WHERE PlaylistId = :playlist_id
    )";
    
    $statement = $dbcon->prepare($sql);
    $statement->execute(array('playlist_id' => $playlist_id));
    $rows = $statement->fetchAll(PDO::FETCH_ASSOC);

    foreach($rows as $row) {
        echo "<h2>".$row["Name"]."</h2>"."<br>"."<p>"."(".$row["Composer"].")"."</p>"."<br>";
    }
    
} catch (PDOException $e) {
    $e->getMessage();
}