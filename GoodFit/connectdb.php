<?php
$db_host = 'localhost';
$db_name = 'cs2team66_db';
$username = 'cs2team66';
$password = '2gxAd94ei0twjYviSbNux636R';

try {
    $db = new PDO(dsn: "mysql:dbname=$db_name;host=$db_host", username: $username, password: $password);
} catch (PDOException $e) {
    echo ("Failed to connect to the database.<br>");
    echo ($e->getMessage());
    exit();
}
?>