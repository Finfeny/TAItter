<?php
include "dbyhteys.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST["name"];
    $password = $_POST["password"];
    $sql = "INSERT INTO users (name, password) VALUES ('$name', '$password')";
    $conn->query($sql);
    header("Location: index.php");
}

?>