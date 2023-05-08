<?php

function createDbConnection()
{
    $ini = parse_ini_file("config.ini");

    $host = $ini["host"];
    $db = $ini["db"];
    $username = $ini["username"];
    $pw = $ini["pw"];

    try {
        $dbcon = new PDO("mysql:host=$host;dbname=$db;charset=utf8", $username, $pw);
        return $dbcon;
    } catch (PDOException $e) {
        echo $e->getMessage();
    }

    return null;
}