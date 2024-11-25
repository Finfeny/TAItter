<?php
header('Content-Type: application/json');
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once 'dbyhteys.php';

if (isset($_GET['query'])) {
    $query = $_GET['query'];

    try {
        if ($query == "") {
            $stmt = $conn->prepare("SELECT name FROM users LIMIT 10");
            $stmt->execute();
        } else {
            $stmt = $conn->prepare("SELECT name FROM users WHERE name LIKE :query LIMIT 10");
            $searchTerm = "%" . $query . "%";
            $stmt->bindParam(':query', $searchTerm, PDO::PARAM_STR);
            $stmt->execute();
        }

        $users = $stmt->fetchAll(PDO::FETCH_ASSOC);

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
