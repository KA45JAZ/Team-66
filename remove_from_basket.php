<?php
session_start();

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    unset($_SESSION['basket'][$id]);
}

header("Location: basket.php");
exit;
?>