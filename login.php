<?php
include 'dbyhteys.php';

$password = $_POST["password"];
$email = $_POST["email"];

$user = $conn->prepare("SELECT * FROM `users` WHERE `email` = :email" );
$user->execute(["email" => $email]);
$user = $user->fetch();

if (password_verify($password, $user['password'])) {
    if ($user) {
        session_start();
        $_SESSION["user"] = $user;
        echo "Login successful";
        header("Location: index.php");
    } else {
        echo "Login failed";
        header("Location: index.php");
    }
}
else {
    echo "Login failed";
    header("Location: index.php");
}

?>