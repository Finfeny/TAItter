<?php
include 'dbyhteys.php';

var_dump($_POST);
$id = $_POST["id"];
$content = $_POST["content"];

$conn->query("UPDATE `posts` SET `content` = '$content' WHERE `id` = $id");
header("Location: index.php");
?>