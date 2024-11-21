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
            <input id ="inputbox" type="text" name="name" id="name">
            <input id ="inputbox" type="password" name="password" id="password">
            <input id ="sendbutton" type="submit" value="Login">
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
        
        foreach ($posts as $post) {
            echo "<div class='post'>";
            $user = $conn->query("SELECT * FROM `users` WHERE `id` = " . $post['sender'])->fetch();
            echo $user["name"] . "<br><div class='contentRow'>";
            if ($post["sender"] == $_SESSION["user"]["id"]) {
                ?>
                <button class="editButton" onclick="
                    this.closest('.post').querySelector('.editButton').style.display = 'none';
                    this.closest('.post').querySelector('.postContent').style.display = 'none';
                    this.closest('.post').querySelector('.postDelete').style.display = 'none';
                    this.closest('.post').querySelector('.editForm').style.display = 'block';
                    this.closest('.post').querySelector('.editContent').value = this.closest('.post').querySelector('.postContent').innerText;
                    this.closest('.post').querySelector('.editId').value = this.closest('.post').querySelector('.postDelete input').value;
                    ">EEddit
                </button>
                <form class="editForm" action="editpost.php" method="POST" style="display: none">
                    <input class="editContent" type="text" name="content" id="content">
                    <input class="editId" type="hidden" name="id">
                    <input type="submit" value="Save">
                </form>
                <?php
            }
            echo "<div class='postContent'>" . $post["content"] . "</div>";
            if ($post["sender"] == $_SESSION["user"]["id"]) {
                ?>
                <form class="postDelete" action="deletepost.php" method="POST">
                    <input type="hidden" name="id" value="<?php echo $post['id'] ?>">
                    <input type="submit" value="Delete">
                </form>
                <?php
            }
            echo "</div></div>";
          }

        ?>
    </div>                         <!-- Viestien lähettäminen -->
    <div class="sendbox">
        <form action="sendpost.php" method="POST">
            <input type="hidden" name="sender" value="<?php echo $_SESSION["user"]["id"] ?>">
            <input id ="inputbox" type="text" name="content" id="content">
            <input id ="sendbutton" type="submit" value="Send">
        </form>
    </div>

</body>
</html>