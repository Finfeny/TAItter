<?php
include 'dbyhteys.php';

var_dump($_POST);
$id = $_POST["id"];
$conn->prepare("DELETE FROM `mentions` WHERE `post_id` = :id")->execute(["id" => $id]);
$conn->prepare("DELETE FROM `posts` WHERE `id` = :id")->execute(["id" => $id]);

header("Location: index.php");

?>