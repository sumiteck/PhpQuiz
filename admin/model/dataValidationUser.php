<?php 

require('database.php');
require('registeration_db.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST'){

    $email = filter_input(INPUT_POST, 'registerEmail', FILTER_VALIDATE_EMAIL);  
    $password = filter_input(INPUT_POST, 'registerPassword');  
    $userAccess = filter_input(INPUT_POST, 'userAccess');
    $firstName = filter_input(INPUT_POST, 'firstName'); 
    $lastName = filter_input(INPUT_POST, 'lastName');  
    $phoneNumber = filter_input(INPUT_POST, 'phoneNumber');
    $address = filter_input(INPUT_POST, 'address');

    if (isset($_POST['updateUser'])) {
         //Check if Course Exist
        if (!empty(isUserExist($email))) {
            //Update User
            updateUser($firstName, $lastName, $email, $password, $phoneNumber, $address, $userAccess);

            //Setting Cookie
            $name = 'btnCheck';
            $value = 'update';
            $expire = strtotime('+1 year');
            $path = '/';
            setcookie($name, $value, $expire, $path);
        }
        else{

            //Setting Cookie
            $name = 'btnCheck';
            $value = 'noUpdate';
            $expire = strtotime('+1 year');
            $path = '/';
            setcookie($name, $value, $expire, $path);
        }
        
        //Loading Page 
        header('Location: ../addUser.php');
    }
    else{
        //save User
        saveUser($firstName, $lastName, $email, $password, $phoneNumber, $address, $userAccess); 

        //Setting Cookie
        $name = 'btnCheck';
        $value = 'save';
        $expire = strtotime('+1 year');
        $path = '/';
        setcookie($name, $value, $expire, $path);
        
        //Loading Page
        header('Location: ../addUser.php');
    }
}
?>