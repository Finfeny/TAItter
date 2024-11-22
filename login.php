<?php
include 'dbyhteys.php';

$name = $_POST["name"];
$password = $_POST["password"];

$user = $conn->prepare("SELECT * FROM `users` WHERE `name` = :name");
$user->execute(["name" => $name]);
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