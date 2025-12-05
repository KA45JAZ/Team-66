<?php
$host = "localhost";
$db_name = "cs2team66_db";
$username = "cs2team66";
$password = "2gxAd94ei0twjYviSbNux636R";

try {
    $db = new PDO("mysql:host=$host;dbname=$db_name;charset=utf8", $username, $password);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Database Connection Failed: " . $e->getMessage());
}
?>
