<?php 

require('database.php');
require('registerationUserDB.php');

// echo "string";
$action = filter_input(INPUT_POST, 'action');

if ($action == NULL) {
    $action = filter_input(INPUT_POST, 'action');
    // header('Location: ../errors/error.php');
}
if ($action == 'saveUser') { //method's name in register DB

    $email = filter_input(INPUT_POST, 'loginUsername', FILTER_VALIDATE_EMAIL);  
    $password = filter_input(INPUT_POST, 'loginPassword');  

    echo $email . $password;

    if ($email == null || $password == null) {
        // echo $email . $password;
        $error = "Invalid data. Check all fields and try again.";
        echo "$error";
        print_r("jsbdjkbjkd");
    } 
    else{
         loginValidationUser($email, $password);
    }
}

?>