<?php
include 'dbyhteys.php';

var_dump($_POST);
$id = $_POST["id"];
$content = $_POST["content"];
if ($content) {
    $query = $conn->prepare("UPDATE `posts` SET `content` = ? WHERE `id` = ?");
    $query->execute([$content, $id]);

    //First delete all mentions of the post
    $delete_query = $conn->prepare("DELETE FROM `mentions` WHERE `post_id` = ?");
    $delete_query->execute([$id]);

    // Check for mentions in the content
    if (preg_match_all('/@(\w+)/', $content, $matches)) {
        // Extract mentioned usernames
        $mentioned_users = $matches[1]; // Array of usernames after '@'

        foreach ($mentioned_users as $username) {

            // Look up the user ID of the mentioned username
            $user_query = $conn->prepare("SELECT id FROM users WHERE name = ?");
            $user_query->execute([$username]);
            $mentioned_user = $user_query->fetch(PDO::FETCH_ASSOC);

            if ($mentioned_user) {
                // Add the mention to the `mentions` table
                $mention_query = $conn->prepare("INSERT INTO `mentions` (post_id, mentioned_user) VALUES (?, ?)");
                $mention_query->execute([$id, $mentioned_user['id']]);
            }
        }
    }
}
header("Location: index.php");
?>