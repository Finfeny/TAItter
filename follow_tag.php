<?php
include 'dbyhteys.php';
session_start();

$tag = $_GET["tag"];
$user_id = $_SESSION["user"]["id"];


$tagId_query = $conn->prepare("SELECT hashtag_id FROM hashtags WHERE tag = :tag");
$tagId_query->execute(["tag" => $tag]);
$tagId = $tagId_query->fetch(PDO::FETCH_ASSOC);

// var_dump($tag);
// echo "<br>";
// var_dump($user_id);
// echo "<br>";
// var_dump($tagId);
// echo "<br>";

// check first if the user is already following the tag
$isFollowingQuery = $conn->prepare("SELECT * FROM user_hashtags WHERE user_id = :user_id AND hashtag_id = :hashtag_id");
$isFollowingQuery->execute([
    "user_id" => $user_id,
    "hashtag_id" => $tagId["hashtag_id"]
]);
$isFollowing = $isFollowingQuery->fetch(PDO::FETCH_ASSOC);

// var_dump($isFollowing);

if ($isFollowing == false) {
    $FollowTagId = $conn->prepare("INSERT INTO `user_hashtags` (user_id, hashtag_id) VALUES (:user_id, :hashtag_id)");
    $FollowTagId->execute([
        "user_id" => $user_id,
        "hashtag_id" => $tagId["hashtag_id"]
    ]);
    echo "followed";
    
} else {
    $FollowTagId = $conn->prepare("DELETE FROM `user_hashtags` WHERE user_id = :user_id AND hashtag_id = :hashtag_id");
    $FollowTagId->execute([
        "user_id" => $user_id,
        "hashtag_id" => $tagId["hashtag_id"]
    ]);
    echo "unfollowed";
}

header("Location: index.php");
?>