<?php
    $host="localhost";
    $user="root";
    $password="";
    $db="taitter";

    try {
        $conn = new PDO("mysql:host=$host; dbname=$db", $user, $password, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
        $conn -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }
    catch (PDOException $e) {
        die("Virhe: " . $e->getMessage());
    }
?> 
