<?php 

require('database.php');
require('adminDB.php');
session_start();

$action = filter_input(INPUT_POST, 'action');

if ($action == NULL) {
    $action = filter_input(INPUT_POST, 'action');
    header('Location: ../errors/error.php');
}
if ($action == 'saveUser') {
    $email = filter_input(INPUT_POST, 'loginUsername', FILTER_VALIDATE_EMAIL);  
    $password = filter_input(INPUT_POST, 'loginPassword');  

    if ($email == null || $password == null) {
        $error = "Invalid product data. Check all fields and try again.";
        header('Location: ../login.php');
    } 
    else{
        loginValidationAdmin1($email, $password);
    }
}

?>