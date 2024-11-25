<?php
include 'dbyhteys.php';

$content = $_POST["content"];
$sender = $_POST["sender"];
if ($content) {
$query = $conn->prepare("INSERT INTO `posts` (sender, content) VALUES (:sender, :content)");
$query->execute([
    "sender" => $sender,
    "content" => $content
]);
}
header("Location: index.php");
?>