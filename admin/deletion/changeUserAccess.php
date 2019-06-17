<?php 

require('../model/database.php');
require('../model/registeration_db.php');


if (isset($_GET['id'])) {
    $email = $_GET['id'];
    changeUserAccess($email);

    //setting Cookie
    $name = 'btnCheckUser';
    $value = 'accessChange';
    $expire = strtotime('+1 year');
    $path = '/';
    setcookie($name, $value, $expire, $path);

    //Loading page
    header('Location: ../index.php');
}

?>