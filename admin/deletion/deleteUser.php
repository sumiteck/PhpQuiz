<?php 

require('../model/database.php');
require('../model/registeration_db.php');


if (isset($_GET['id'])) {
    $email = $_GET['id'];
    deleteUser($email);

    //setting Cookie
    $name = 'btnCheckUser';
    $value = 'deleteAlert1';
    $expire = strtotime('+1 year');
    $path = '/';
    setcookie($name, $value, $expire, $path);

    //Loading page
    header('Location: ../index.php');
}

?>