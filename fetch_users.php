<?php
header('Content-Type: application/json');
require_once 'dbyhteys.php';

if (isset($_GET['query'])) {
    $query = $_GET['query'];

    try {
        if ($query == "") {
            $stmt = $conn->prepare("SELECT id, name, description, creation_date FROM users LIMIT 10");
        } else {
            $stmt = $conn->prepare("SELECT id, name, description, creation_date FROM users WHERE name LIKE :query LIMIT 10");
            $searchTerm = "%" . $query . "%";
            $stmt->bindParam(':query', $searchTerm, PDO::PARAM_STR);
        }
        $stmt->execute();
        $users = $stmt->fetchAll(PDO::FETCH_ASSOC);

        //seuraajat ja seurattavat
        foreach ($users as &$user) {
            $userId = $user['id'];
            $followerStmt = $conn->prepare("SELECT COUNT(*) AS follower_count FROM follows WHERE followed_id = :userId");
            $followerStmt->bindParam(':userId', $userId, PDO::PARAM_INT);
            $followerStmt->execute();
            $user['follower_count'] = $followerStmt->fetchColumn();

            $followingStmt = $conn->prepare("SELECT COUNT(*) AS following_count FROM follows WHERE follower_id = :userId");
            $followingStmt->bindParam(':userId', $userId, PDO::PARAM_INT);
            $followingStmt->execute();
            $user['following_count'] = $followingStmt->fetchColumn();
        }

        echo json_encode($users);
        exit;
    } catch (PDOException $e) {
        echo json_encode(["error" => "Database error: " . $e->getMessage()]);
        exit;
    }
} else {
    echo json_encode(["error" => "Query not provided"]);
    exit;
}

?>
