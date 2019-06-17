<?php 

require('database.php');
require('registerationUserDB.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST'){

    $email = filter_input(INPUT_POST, 'registerEmail', FILTER_VALIDATE_EMAIL);  
    $password = filter_input(INPUT_POST, 'registerPassword');  
    // $userAccess = filter_input(INPUT_POST, 'userAccess');
    $firstName = filter_input(INPUT_POST, 'registerFname'); 
    $lastName = filter_input(INPUT_POST, 'registerLname');  
    // $phoneNumber = filter_input(INPUT_POST, 'phoneNumber');
    // $address = filter_input(INPUT_POST, 'address');


            // echo isUserExist($email);
            if (empty(isUserExist($email))) {
                 echo "save user: datavalidation";

                saveUser($firstName, $lastName, $email, $password); 

                //Setting Cookie
                $name = 'btnCheck';
                $value = 'saveUser';
                $expire = strtotime('+1 year');
                $path = '/';
                setcookie($name, $value, $expire, $path);
                
                //Loading Page
                header('Location: ../register.php');
            }else{
                //Setting Cookie
                $name = 'btnCheck';
                $value = 'userExist';
                $expire = strtotime('+1 year');
                $path = '/';
                setcookie($name, $value, $expire, $path);
                //Loading Page
                header('Location: ../register.php');
            }
    // }
}
?>