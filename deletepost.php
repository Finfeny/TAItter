<?php
include 'dbyhteys.php';

$id = $_POST["id"];
$conn->query("DELETE FROM `posts` WHERE `id` = $id");
header("Location: index.php");

?>