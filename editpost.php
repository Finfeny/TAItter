<?php
include 'dbyhteys.php';

var_dump($_POST);
$id = $_POST["id"];
$content = $_POST["content"];
if ($content) {
$query = $conn->prepare("UPDATE `posts` SET `content` = ? WHERE `id` = ?");
$query->execute([$content, $id]);
}
header("Location: index.php");
?>