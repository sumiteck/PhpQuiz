<?php 

require('database.php');
require('profileDB.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    echo "String entered  validation profile";
    
    $email = filter_input(INPUT_POST, 'registerEmail', FILTER_VALIDATE_EMAIL);
    $password = filter_input(INPUT_POST, 'registerPassword'); 
    $firstName = filter_input(INPUT_POST, 'firstName'); 
    $lastName = filter_input(INPUT_POST, 'lastName');  
    $phoneNumber = filter_input(INPUT_POST, 'phoneNumber');
    $address = filter_input(INPUT_POST, 'address');
    // $email = filter_input(INPUT_POST, 'email');

    echo "email: ". $email;

     if (!empty(isUserExist($email))) {
        if (isset($_POST['update'])) {
         echo $email . $firstName . $lastName . $phoneNumber . $address; 

            updateProfile($email, $firstName, $lastName, $phoneNumber, $address);

            //Setting Cookie
            $name = 'btnCheck';
            $value = 'update';
            $expire = strtotime('+1 year');
            $path = '/';
            setcookie($name, $value, $expire, $path);
    } 
    }else{
     //Setting Cookie
            $name = 'btnCheck';
            $value = 'noUpdate';
            $expire = strtotime('+1 year');
            $path = '/';
            setcookie($name, $value, $expire, $path);
    }

    //Loading Page 
    header('Location: ../profile.php');
}


?>


