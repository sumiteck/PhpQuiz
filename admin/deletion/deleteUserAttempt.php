<?php 

require('../model/database.php');
require('../model/courseDB.php');


if (isset($_GET['id'])) {
    $courseName = $_GET['id'];
    deleteCourse($courseName);

    //setting Cookie
    $name = 'btnCheck';
    $value = 'deleteAlert';
    $expire = strtotime('+1 year');
    $path = '/';
    setcookie($name, $value, $expire, $path);

    //Loading page
    header('Location: ../courses.php');
}

?>