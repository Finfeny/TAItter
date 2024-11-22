<?php
include "dbyhteys.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST["name"];
    $password = $_POST["password"];
    $password = password_hash($password, PASSWORD_DEFAULT);
    $sql = "INSERT INTO users (name, password) VALUES ('$name', '$password')";
    $conn->query($sql);
    header("Location: index.php");
}

?>