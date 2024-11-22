<?php
include 'dbyhteys.php';

$content = $_POST["content"];
$sender = $_POST["sender"];
if ($content) {
$conn->query("INSERT INTO `posts` (`sender`, `content`) VALUES ('$sender', '$content')");
}
header("Location: index.php");
?>