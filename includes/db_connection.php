<?php
$connection = null;

function getConnection() {
    global $connection;

    if ($connection === null) {
        $connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
        if ($connection->connect_error) {
            die('Connection failed: ' . $connection->connect_error);
        }
    }

    return $connection;
}
?>