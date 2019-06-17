<?php

require('homeDB.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST'){

    $sortDate = filter_input(INPUT_POST, 'sortDate'); 
    $a = formatDate($sortDate);
    //setting cookie
    $name = 'sortDate';
    $value = $a;
    $expire = strtotime('+1 year');
    $path = '/';
    setcookie($name, $value, $expire, $path); 
    header('Location: ../index.php?id=sortDate');
}

?>