<?php
include 'dbyhteys.php';
session_start();
$content = htmlspecialchars($_POST["content"]);
$sender = $_SESSION["user"]["id"];

if ($content) {
    
    //                                                          Check for mentions in the content
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
    
    if (preg_match_all('/#(\w+)/', $content, $matches)) {

        // Extract hashtags
        $hashtags = $matches[1]; //                              Check for hashtags
        $hashtagsWithHash = $matches[0]; // Array of hashtags with '#'
        echo "<br>";

        var_dump("content", $content);
        echo "<br>";
        var_dump("hashtags", $hashtags);
        echo "<br>";
        var_dump("hashtagsWithHash", $hashtagsWithHash);
        
        echo "<br>";
        foreach ($hashtagsWithHash as $i => $hashtag) {
            var_dump($i);
            echo "<br>";
            // Build the URL and replace in content
            $url = "follow_tag.php?tag=" . urlencode($hashtags[$i]);
            $content = str_replace($hashtag, "<a href='$url'>$hashtag</a>", $content
            );
        }
        echo "<br>";
        var_dump("new content", $content);
        echo "<br>";
        
        foreach ($hashtags as $hashtag) {
            
            // Look up the hashtag ID of the mentioned username
            $hashtag_query = $conn->prepare("SELECT hashtag_id FROM hashtags WHERE tag = :hashtag");
            $hashtag_query->execute(["hashtag" => $hashtag]);
            $hashtag_id = $hashtag_query->fetch(PDO::FETCH_ASSOC);
            
            // $hashtag_id is true if the hashtag exists
            
            if (!$hashtag_id) {
                
                // Add the hashtag to the `hashtags` table if it doesn't exist
                $hashtag_query = $conn->prepare("INSERT INTO `hashtags` (tag) VALUES (:hashtag)");
                $hashtag_query->execute(["hashtag" => $hashtag]);
                $hashtag_id = $conn->lastInsertId();
            }
        }
    }
    
    $query = $conn->prepare("INSERT INTO `posts` (sender, content) VALUES (:sender, :content)");
    $query->execute([
        "sender" => $sender,
        "content" => $content
    ]);

    //  Get the last inserted post ID
    $post_id = $conn->lastInsertId();
    var_dump("postId", $post_id);
    echo "<br>";

    // add hashtags to the post_hashtags table if tags exist

    if ($hashtags) {
        foreach ($hashtags as $hashtag) {
            $hashtag_query = $conn->prepare("SELECT hashtag_id FROM hashtags WHERE tag = :hashtag");
            $hashtag_query->execute(["hashtag" => $hashtag]);
            $hashtag_id = $hashtag_query->fetch(PDO::FETCH_ASSOC);
            
            $post_hashtag_query = $conn->prepare("INSERT INTO `post_hashtags` (post_id, hashtag_id) VALUES (:post_id, :hashtag_id)");
            $post_hashtag_query->execute([
                "post_id" => $post_id,
                "hashtag_id" => $hashtag_id["hashtag_id"]
            ]);
        }
    }
    
}
header("Location: index.php");
?>