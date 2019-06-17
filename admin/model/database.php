<?php

    $dsn = 'mysql:host=localhost;dbname=Quiz';
    $username = 'root';
    $password = '';

    try {
        $db = new PDO($dsn, "root", "");
            } catch (PDOException $e) {
        $error_message = $e->getMessage();
        include('database_error.php');
        exit();
    }
?>