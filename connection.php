<?php
    $dbServerName = 'localhost';
    $dbUserName = 'root';
    $dbPassword = '';
    $dbName = 'vicios_detdelunity';

    $conn = new mysqli($dbServerName, $dbUserName, $dbPassword, $dbName, 3307);
    if($conn->connect_error) {
        echo "$conn->connect_error";
        die("Connection failed: " . $conn->connect_error);
    }
?>