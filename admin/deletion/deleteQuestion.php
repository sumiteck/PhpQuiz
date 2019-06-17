<?php 

require('../model/database.php');
require('../model/questionDB.php');


if (isset($_GET['id'])) {
    $questionId = $_GET['id'];
    deleteQuestion($questionId);

    //setting Cookie
    $name = 'btnCheck';
    $value = 'deleteAlert';
    $expire = strtotime('+1 year');
    $path = '/';
    setcookie($name, $value, $expire, $path);

    //Loading page
    header('Location: ../questions.php');
}

?>