<?php
include 'dbyhteys.php';


// Fatal error: Uncaught PDOException: SQLSTATE[23000]: Integrity constraint violation: 1451 Cannot delete or update a parent row: a foreign key constraint fails (`taitter`.`mentions`, CONSTRAINT `mentions_ibfk_1` FOREIGN KEY (`post_id`) REFERENCES `posts` (`id`)) in C:\xampp\htdocs\topi\TAItter\deletepost.php:5 Stack trace: #0 C:\xampp\htdocs\topi\TAItter\deletepost.php(5): PDO->query('DELETE FROM `po...') #1 {main} thrown in C:\xampp\htdocs\topi\TAItter\deletepost.php on line 5
var_dump($_POST);
$id = $_POST["id"];
$conn->query("DELETE FROM `mentions` WHERE `post_id` = $id");
$conn->query("DELETE FROM `posts` WHERE `id` = $id");
header("Location: index.php");

?>