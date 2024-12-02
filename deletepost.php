<?php
include 'dbyhteys.php';

$id = $_POST["id"];
$hashtag_id = $conn->query("SELECT hashtag_id FROM post_hashtags WHERE post_id = $id");
$hashtag_id = $hashtag_id->fetch(PDO::FETCH_ASSOC);
var_dump($hashtag_id);
var_dump("DELETE FROM `user_hashtags` WHERE `hashtag_id` = 12");
$conn->prepare("DELETE FROM `user_hashtags` WHERE `hashtag_id` = :hashtag_id")->execute(["hashtag_id" => $hashtag_id]);
// $conn->prepare("DELETE FROM `hashtags` WHERE `hashtag_id` = :hashtag_id")->execute(["hashtag_id" => $hashtag_id]);
// $conn->prepare("DELETE FROM `post_hashtags` WHERE `post_id` = :id")->execute(["id" => $id]);
// $conn->prepare("DELETE FROM `mentions` WHERE `post_id` = :id")->execute(["id" => $id]);
// $conn->prepare("DELETE FROM `posts` WHERE `id` = :id")->execute(["id" => $id]);

// header("Location: index.php");

?>