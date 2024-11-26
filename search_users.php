<?php
include 'dbyhteys.php';
session_start();

var_dump($_POST);

if(isset($_POST['search'])){
    $search = $_POST['search'];
    $sql = "SELECT * FROM users WHERE username LIKE '%$search%'";
    $result = $conn->query($sql);
    if($result->num_rows > 0){
        while($row = $result->fetch_assoc()){
            echo "<a href='profile.php?user=".$row['username']."'>".$row['username']."</a><br>";
        }
    }else{
        echo "No users found";
    }
}

?>