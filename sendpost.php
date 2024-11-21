<?php
include 'dbyhteys.php';

$content = $_POST["content"];
$sender = $_POST["sender"];

$conn->query("INSERT INTO `posts` (`sender`, `content`) VALUES ('$sender', '$content')");
header("Location: index.php");
?>