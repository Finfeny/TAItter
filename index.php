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
                <input class ="inputbox" type="email" name="email" id="email" placeholder="Email">
                <input class ="inputbox" type="password" name="password" id="password" placeholder="Password">
                <input id ="sendbutton" type="submit" value="Login">
            </form>
        </div>
        <?php
    }
    ?>
    <div id="topbar">                               <!-- Yläinfot -->
        <?php
        if (isset($_SESSION["user"])) {
            ?>
            <form action="logout.php" method="POST">
                <input id="logoutButton" type="submit" value="Logout">
            </form>
            <?php
        }
        ?>
        <div id="user">                             <!-- Käyttäjän tiedot -->
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
                        <input class ="inputbox" type="text" name="name" id="name" placeholder="Name">
                        <input class ="inputbox" type="email" name="email" id="email" placeholder="Email">
                        <input class ="inputbox" type="password" name="password" id="password" placeholder="Password">
                        <input id ="sendbutton" type="submit" value="Register">
                    </form>
                    <?php
                }
            ?>
        </div>
        <?php
        if (isset($_SESSION["user"])) {                                     // Käyttäjien ja postausten vaihtaminen
            ?>
            <button class="showButton" id="showUserButton" onclick="
                document.querySelector('#showUserButton').style.display = 'none';
                document.querySelector('#showPostsButton').style.display = 'block';
                document.querySelector('#posts').style.display = 'none';
                document.querySelector('#users').style.display = 'flex';
                document.querySelector('#postFilters').style.display = 'none';
                document.querySelector('#userFilters').style.display = 'flex';
                document.querySelector('#sendbox').style.display = 'none';
                SearchUsers()
                ">Show users
            </button>
            <button class="showButton" id="showPostsButton" style="display: none" onclick="
                document.querySelector('#showUserButton').style.display = 'block';
                document.querySelector('#showPostsButton').style.display = 'none';
                document.querySelector('#posts').style.display = 'flex';
                document.querySelector('#users').style.display = 'none';
                document.querySelector('#postFilters').style.display = 'flex';
                document.querySelector('#userFilters').style.display = 'none';
                document.querySelector('#sendbox').style.display = 'block';
                ">Show posts
            <?php
        }
        ?>
    </div>
    <?php
    if ($_SESSION != null) {
        ?>
        <div class="filter" id="postFilters">
            <select id="filterSelect" onChange="filterSelect()">                     <!-- Postausten haku ja filtteröinti -->
                <option value="" disabled selected>Filter</option>
                <option value="All">All</option>
                <option value="Mentions">Mentions</option>
                <option value="Mentioned">Mentioned</option>
                <option value="ShowUserPosts" style="display: none">ShowUserPosts</option>
            </select>
            <form action="search_posts.php" method="POST">
                <input class="searchInput" type="text" name="search" id="postSearchInput" placeholder="Search posts by @users">
                <input type="submit" value="Search">
            </form>
            <select id="sortSelect" onChange="sortSelect()">
                <option value="Newest">Newest</option>
                <option value="Oldest">Oldest</option>
            </select>
        </div>
        <div class="filter" id="userFilters" style="display: none">
            <input class="searchInput" type="text" name="search" id="userSearchInput" placeholder="Search users">
        </div>
        <?php
    }
    ?>

    <div id="users" style="display: none"></div>             <!-- Show users -->
    
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
    </div>
    <h1 id="messageBox"></h1>                                         <!-- Virheilmoitukset -->
    <?php
    if (isset($_SESSION["user"])) {
        ?>
        <div id="sendbox">                                              <!-- Viestin lähetys -->
            <form action="sendpost.php" method="POST" id="sendboxForm">
                <input type="hidden" name="sender" value="<?php echo $_SESSION["user"]["id"] ?>">
                <textarea
                    rows="2"
                    cols="25"
                    id ="sendInputbox"
                    type="text"
                    name="content"
                    id="content"
                    maxlength="144"
                    placeholder="Limit is 144 characters"
                    ></textarea>
                <input id ="sendbutton" type="submit" value="Send">
            </form>
            <div id="dropdown" class="dropdown-menu"></div>
            <div id="alertbox">144 character limit reached</div>
        </div>
        <?php
    }
    ?>
</body>

<script>

    function showUserPosts(user) {             // Näyttää käyttäjän postaukset

        document.querySelector('#showUserButton').style.display = 'none';
        document.querySelector('#showPostsButton').style.display = 'block';
        document.querySelector('#posts').style.display = 'flex';
        document.querySelector('#users').style.display = 'none';
        document.querySelector('#postFilters').style.display = 'flex';
        document.querySelector('#userFilters').style.display = 'none';
        document.querySelector('#sendbox').style.display = 'block';
        
        document.getElementById("filterSelect").value = "ShowUserPosts";
        filterSelect(user);
    }

    function filterSelect(user) {
        // console.log(user);
        const filterSelectValue = document.getElementById("filterSelect").value;
        const posts = document.querySelectorAll(".post");
        let gotPosts = false;
        document.getElementById("messageBox").innerText = "";
        

        posts.forEach((post) => {
            const postSender = post.firstChild.data;                           // Viestin lähettäjä
            const content = post.querySelector(".postContent").innerText;           // Viestin sisältö
            const allMentions = content.match(/@(\w+)/g) || [];                     // Kaikki maininnat
            const tags = content.match(/#(\w+)/g) || [];                            // Kaikki tagit
            const currentUserMentions = allMentions.filter((mention) => mention.slice(1) == "<?php echo $_SESSION["user"]["name"] ?>");     // Käyttäjän maininnat

            switch (filterSelectValue) {
                
            case "All":
                //Vaihtoehdot filtteröintiin
                post.style.display = "block";
                gotPosts = true;
                break;
            
            case "Mentions": 
                if (allMentions.length == 0) {
                    post.style.display = "none";
                    break;

                } else {
                    post.style.display = "block";
                    gotPosts = true;
                    break;
                } 

            case "Mentioned":
                if (currentUserMentions.length == 0) {
                    post.style.display = "none";   
                    break;
                } else {
                    post.style.display = "block";
                    gotPosts = true;
                    break;
                }

            case "ShowUserPosts":
                if (postSender.includes(user)) {
                    post.style.display = "block";
                    gotPosts = true;
                    break;

                } else {
                    post.style.display = "none";
                    break;
                }
        }});
        if (gotPosts == false) {
            document.getElementById("messageBox").innerText = "No posts found";           //Jos ei oo käyttäjii ni näytetään viesti
        }
    }

    function sortSelect() {
        const sortSelectValue = document.getElementById("sortSelect").value;

        switch (sortSelectValue) {
            
        case "Oldest": 
            document.getElementById("posts").style.flexDirection = "column";
            break;
            
        case "Newest":
            document.getElementById("posts").style.flexDirection = "column-reverse";
            break;
        
    }
    }

    
    document.addEventListener("DOMContentLoaded", function () {
        const sendInputbox = document.getElementById("sendInputbox");
        const dropdown = document.getElementById("dropdown");
        
        sendInputbox.addEventListener("input", function () {
            const cursorPosition = sendInputbox.selectionStart;
            const textBeforeCursor = sendInputbox.value.slice(0, cursorPosition);
            const inputField = document.getElementById("sendInputbox");

            // Kattoo jos "@" on viestissä
            const atIndex = textBeforeCursor.lastIndexOf("@");
            if (atIndex !== -1) {
                const query = textBeforeCursor.slice(atIndex + 1);

                fetch(`fetch_users.php?query=${query}`)
                    .then((response) => response.json())
                    .then((data) => {
                        // Dropdowni
                        dropdown.innerHTML = data
                        .map((user) => `<div data-name="${user.name}">${user.name}</div>`)
                        .join("");
                        dropdown.style.display = "block";
                    })
                    .catch((error) => console.error("Error fetching users:", error));

                } else {
                dropdown.style.display = "none";
            }
            
            if (inputField.value.length >= inputField.getAttribute("maxlength")) {
                document.getElementById("alertbox").style.display = "block"
            } else if (inputField.value.length <= inputField.getAttribute("maxlength")) {
                document.getElementById("alertbox").style.display = "none"
            }
        });

        
        dropdown.addEventListener("click", function (e) {       // laittaa käyttäjän nimen viestiin kun se valitaan
            if (e.target.dataset.name) {
                const cursorPosition = sendInputbox.selectionStart;
                const textBeforeCursor = sendInputbox.value.slice(0, cursorPosition);
                const atIndex = textBeforeCursor.lastIndexOf("@");

                const newText =
                textBeforeCursor.slice(0, atIndex) +
                `@${e.target.dataset.name} ` +
                sendInputbox.value.slice(cursorPosition);
                sendInputbox.value = newText;

                dropdown.style.display = "none";
            }
        });
    });

    document.addEventListener("DOMContentLoaded", function () {
    const userSearchInput = document.getElementById("userSearchInput");
    const usersDiv = document.getElementById("users");
    
    userSearchInput.addEventListener("input", function () {
        const query = userSearchInput.value.trim();

        fetch(`fetch_users.php?query=${encodeURIComponent(query)}`)
            .then((response) => response.json())
            .then((data) => {

                // Clear the users div
                usersDiv.innerHTML = "";

                // Check for errors
                if (data.error) {
                    usersDiv.innerHTML = `<div>${data.error}</div>`;
                    usersDiv.style.display = "block";
                    return;
                }

                // Populate the users div with results
                if (data.length > 0) {
                    usersDiv.innerHTML = data
                        .map(
                            (user) => `
                            <div class="user" onClick='showUserPosts("${user.name}")'>
                                <strong>${user.name}</strong>
                                <div class="userDescription">
                                    ${user.description || "No description"}
                                    <br>
                                    <br>
                                    ${user.follower_count} followers<br>
                                    ${user.following_count} following
                                    <br>
                                    ${user.post_count} posts
                                    <br>
                                    ${user.creation_date ? `Account created at: ${user.creation_date}` : ""}
                                </div>
                            </div>
                        `
                        )
                        .join("");
                } else {
                    usersDiv.innerHTML = "<div>No users found</div>";
                }

                usersDiv.style.display = "flex";
            })
            .catch((error) => {
                console.error("Error fetching users:", error);
                usersDiv.innerHTML = "<div>Failed to fetch users</div>";
                usersDiv.style.display = "block";
            });
        });

    // Define the SearchUsers function to clear input and trigger the input event
    window.SearchUsers = function() {
        const inputElement = document.getElementById("userSearchInput");

        // Clear the value in the input
        inputElement.value = "";

        // Create and dispatch the input event to simulate user interaction
        const event = new Event('input');
        inputElement.dispatchEvent(event);  // This triggers the event listener
    };
});


  
</script>

</html>