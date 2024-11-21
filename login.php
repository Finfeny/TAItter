<?php
include 'dbyhteys.php';

$name = $_POST["name"];
$password = $_POST["password"];

$user = $conn->prepare("SELECT * FROM `users` WHERE `name` = :name AND `password` = :password ");
$user->execute(["name" => $name, "password" => $password]);
$user = $user->fetch();

if ($user) {
    session_start();
    $_SESSION["user"] = $user;
    echo "Login successful";
    header("Location: index.php");
} else {
    echo "Login failed";
    header("Location: index.php");
}

?>