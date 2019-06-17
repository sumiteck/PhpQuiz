<?php 

require('../model/database.php');
require('../model/courseDB.php');


if (isset($_GET['id'])) {
    $courseName = $_GET['id'];
    changeUserAccess($courseName);

    //setting Cookie
    $name = 'btnCheck';
    $value = 'accessChange';
    $expire = strtotime('+1 year');
    $path = '/';
    setcookie($name, $value, $expire, $path);

    //Loading page
    header('Location: ../courses.php');
}

?>