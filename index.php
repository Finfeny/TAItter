<?php
include 'dbyhteys.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>TAItter</title>
</head>
<body>
    <div class="login">             <!-- Kirjautuminen -->
        <button class="loginButton" onclick="
            document.querySelector('.loginButton').style.display = 'none';      // Piilotetaan login-nappi
            document.querySelector('.loginForm').style.display = 'block';       // ja näytetään login-form
            ">Login
        </button>
        <form class="loginForm" action="login.php" method="POST" style="display: none">
            <input type="text" name="name" id="name">
            <input type="password" name="password" id="password">
            <input type="submit" value="Login">
        </form>
    </div>

    <div class="user">              <!-- Käyttäjän tiedot -->
        <?php
            session_start();
            if (isset($_SESSION["user"])) {
                echo "Logged in as " . $_SESSION["user"]["name"];
            }
        ?>
    </div>
    
    <div class="posts">             <!-- Haetaan viestit databasesta -->
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