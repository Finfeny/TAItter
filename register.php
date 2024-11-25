<?php
include "dbyhteys.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST["name"];
    $password = $_POST["password"];
    $email = $_POST["email"];

    $password = password_hash($password, PASSWORD_DEFAULT);
    if ($name && $password && $email) {
        $query = $conn->prepare("INSERT INTO users (name, password, email) VALUES (:name, :password, :email)");
        $query->execute([
            "name" => $name,
            "password" => $password,
            "email" => $email
        ]);
    }
    header("Location: index.php");
}

?>