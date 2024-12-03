<?php
include 'dbyhteys.php';

$id = $_POST["id"];
$hashtag_id = $conn->query("SELECT hashtag_id FROM post_hashtags WHERE post_id = $id");
$hashtag_id = $hashtag_id->fetch(PDO::FETCH_ASSOC);
var_dump($hashtag_id);


// Sitten poistetaan tagi postaustageista
$sql = $conn->prepare("DELETE FROM `post_hashtags` WHERE `post_id` = :id");
$sql->execute(["id" => $id]);

// Sitten poistetaan tagi tagitaulusta jos sitä ei ole enää missään postauksessa
$sql = $conn->prepare("SELECT * FROM `post_hashtags` WHERE `hashtag_id` = :hashtag_id");
$sql->execute(["hashtag_id" => $hashtag_id["hashtag_id"]]);
$tag = $sql->fetch(PDO::FETCH_ASSOC);
var_dump($tag);

if (!$tag) {
    // Eka poistetaan käyttäjien seuraukset tagista
    $sql = $conn->prepare("DELETE FROM `user_hashtags` WHERE `hashtag_id` = :hashtag_id");
    $sql->execute(["hashtag_id" => $hashtag_id["hashtag_id"]]);

    $sql = $conn->prepare("DELETE FROM `hashtags` WHERE `hashtag_id` = :hashtag_id");
    $sql->execute(["hashtag_id" => $hashtag_id["hashtag_id"]]);
}

// Sitten poistetaan maininnat
$sql = $conn->prepare("DELETE FROM `mentions` WHERE `post_id` = :id");
$sql->execute(["id" => $id]);

// Sitten poistetaan postaus
$sql = $conn->prepare("DELETE FROM `posts` WHERE `id` = :id");
$sql->execute(["id" => $id]);

header("Location: index.php");

?>