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
    
    // Get the last inserted post ID
    $post_id = $conn->lastInsertId();

    // Check for mentions in the content
    if (preg_match_all('/@(\w+)/', $content, $matches)) {
        // Extract mentioned usernames
        $mentioned_users = $matches[1]; // Array of usernames after '@'

        foreach ($mentioned_users as $username) {
            // Look up the user ID of the mentioned username
            $user_query = $conn->prepare("SELECT id FROM users WHERE name = :username");
            $user_query->execute(["username" => $username]);
            $mentioned_user = $user_query->fetch(PDO::FETCH_ASSOC);

            if ($mentioned_user) {
                // Add the mention to the `mentions` table
                $mention_query = $conn->prepare("INSERT INTO `mentions` (post_id, mentioned_user) VALUES (:post_id, :mentioned_user)");
                $mention_query->execute([
                    "post_id" => $post_id,
                    "mentioned_user" => $mentioned_user['id']
                ]);
            }
        }
    }
}
header("Location: index.php");
?>