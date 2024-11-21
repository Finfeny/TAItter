<?php
include 'dbyhteys.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TAItter</title>
</head>
<body>                           <!-- Haetaan viestit databasesta -->
    
    <div class="posts">
        <?php
            
          $posts = $conn->query("SELECT * FROM `posts`")->fetchAll();
        //   $users = $conn->query("SELECT * FROM `users`")->fetchAll();
        
        foreach ($posts as $post) {
            echo "<div class='post'>";
            $user = $conn->query("SELECT * FROM `users` WHERE `id` = " . $post['sender'])->fetch();
            echo $user["name"] . "<br>".
            $post["content"] .
            "</div><br><br>";
          }

        ?>
    </div>                         <!-- Viestien lähettäminen -->

    <div class="sendbox">
        <form action="sendpost.php" method="POST">
            <input type="hidden" name="sender" value="1">       <!-- Käyttäjän id pitää hakee tähän-->
            <input type="text" name="content" id="content">
            <input type="submit" value="Send">
        </form>
    </div>

</body>
</html>