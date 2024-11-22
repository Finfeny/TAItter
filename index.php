<?php
include 'dbyhteys.php';
session_start();
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
    <?php
    if ($_SESSION == null) {
        ?>
        <div id="login">             <!-- Kirjautuminen -->
            <button id="loginButton" onclick="
                document.querySelector('#loginButton').style.display = 'none';      // Piilotetaan login-nappi
                document.querySelector('#loginForm').style.display = 'block';       // ja näytetään login-form
                ">Login
            </button>
            <form id="loginForm" action="login.php" method="POST" style="display: none">
                <input class ="inputbox" type="text" name="name" id="name">
                <input class ="inputbox" type="password" name="password" id="password">
                <input id ="sendbutton" type="submit" value="Login">
            </form>
        </div>
    <?php
    }
    if (isset($_SESSION["user"])) {
        ?>
        <form action="logout.php" method="POST">
            <input id="logoutButton" type="submit" value="Logout">
        </form>
        <?php
    }
    ?>

    <div id="user">              <!-- Käyttäjän tiedot -->
        <?php
            if (isset($_SESSION["user"])) {
                echo "Logged in as " . $_SESSION["user"]["name"];
            }
            else {
                ?>
                <button id="registerButton" onclick="
                    document.querySelector('#registerButton').style.display = 'none';
                    document.querySelector('#registerForm').style.display = 'block';
                    ">Register
                </button>
                <form action="register.php" method="POST" id="registerForm" style="display: none">
                    <input class ="inputbox" type="text" name="name" id="name">
                    <input class ="inputbox" type="password" name="password" id="password">
                    <input id ="sendbutton" type="submit" value="Register">
                </form>
                <?php
            }
        ?>
    </div>
    
    <div id="posts">             <!-- Haetaan viestit databasesta -->
        <?php
            
        $posts = $conn->query("SELECT * FROM `posts`")->fetchAll();
        
        foreach ($posts as $post) {
            echo "<div class='post'>";
            $user = $conn->query("SELECT * FROM `users` WHERE `id` = " . $post['sender'])->fetch();
            echo $user["name"] . "<br><div class='contentRow'>";
            if (isset($_SESSION["user"]["id"]) && $post["sender"] == $_SESSION["user"]["id"]) {
                ?>                                                              <!-- Viestin muokkaus -->
                <button class="editButton" onclick="
                    this.closest('.post').querySelector('.editButton').style.display = 'none';
                    this.closest('.post').querySelector('.postContent').style.display = 'none';
                    this.closest('.post').querySelector('.postDelete').style.display = 'none';
                    this.closest('.post').querySelector('.editForm').style.display = 'block';
                    this.closest('.post').querySelector('.editContent').value = this.closest('.post').querySelector('.postContent').innerText;
                    this.closest('.post').querySelector('.editId').value = this.closest('.post').querySelector('.postDelete input').value;
                    ">Edit
                </button>
                <form class="editForm" action="editpost.php" method="POST" style="display: none">
                    <input class="editContent" type="text" name="content" id="content">
                    <input class="editId" type="hidden" name="id">
                    <input type="submit" value="Save">
                </form>
                <?php
            }
            echo "<div class='postContent'>" . $post["content"] . "</div>";     // Viestin sisältö
            if (isset($_SESSION["user"]["id"]) && $post["sender"] == $_SESSION["user"]["id"]) {
                ?>                                                            <!-- Viestin poisto -->
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
    <?php
    if (isset($_SESSION["user"])) {
        ?>
        <div id="sendbox">
            <form action="sendpost.php" method="POST" id="sendboxBox">
                <input type="hidden" name="sender" value="<?php echo $_SESSION["user"]["id"] ?>">
                <textarea rows="2" cols="25" id ="sendInputbox" type="text" name="content" id="content"></textarea>
                <input id ="sendbutton" type="submit" value="Send">
            </form>
        </div>
        <?php
    }
    ?>
</body>
</html>