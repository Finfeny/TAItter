<?php
include_once("dbyhteys.php");
session_start();
header("Content-Type: application/json");

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    // Ensure user is logged in
    if (!isset($_SESSION["user"])) {
        echo json_encode(["success" => false, "error" => "User not logged in"]);
        exit;
    }

    // Decode JSON body
    $data = json_decode(file_get_contents("php://input"), true);
    $senderName = $data["senderName"] ?? null;

    if (!$senderName) {
        echo json_encode(["success" => false, "error" => "Invalid sender name"]);
        exit;
    }
}
?>
