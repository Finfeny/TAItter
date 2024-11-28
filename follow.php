<?php
include_once("dbyhteys.php");
session_start();
header("Content-Type: application/json");


if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Ensure user is logged in
    if (!isset($_SESSION["user"])) {
        $response["error"] = "User not logged in";
        echo json_encode($response);
        exit;
    }

    // Decode JSON body
    $data = json_decode(file_get_contents("php://input"), true);

    if (!$data || !isset($data["senderName"])) {
        $response["error"] = "Invalid sender name";
        echo json_encode($response);
        exit;
    }

    $senderName = $data["senderName"];
    // Perform your action here (e.g., save to database)
    $follow = $conn->prepare("SELECT * FROM follows WHERE follower_id = :follower_id AND followed_id = :followed_id");
    $follow->execute([
        ":follower_id" => $_SESSION["user"]["id"], 
        ":followed_id" => $senderName
    ]);

    if ($follow->rowCount() > 0) {
        $follow = $conn->prepare("DELETE FROM follows WHERE follower_id = :follower_id AND followed_id = :followed_id");
        $follow->execute([
        ":follower_id" => $_SESSION["user"]["id"], 
        ":followed_id" => $senderName
    ]);
        $response = ["success" => false];    
        echo json_encode($response);
        exit;
    }

    $sql = "INSERT INTO follows (follower_id, followed_id) VALUES (:follower_id, :followed_id)";
    $stmt = $conn->prepare($sql);
    $stmt->execute([
        ":follower_id" => $_SESSION["user"]["id"], 
        ":followed_id" => $senderName
    ]);

    $response = ["success" => true];
    echo json_encode($response);
    exit;
}

// Default response if request method is not POST
echo json_encode($response);
?>
