<?php 

function isUserExist($email){
    require('database.php');

    $query1 = 'SELECT email FROM user WHERE email = :email';
    $statement1 = $db->prepare($query1);
    $statement1->bindValue(':email', $email);
    $statement1->execute();
    $dataFetching = $statement1->fetch();
    $statement1->closeCursor();

    print_r($dataFetching);
    echo "----- is user exist --- ";

    return $dataFetching;
}

function saveUser($firstName, $lastName, $email, $password){
  require_once('database.php');

echo $firstName . " " . $lastName . " " . $email . " " . $password . " <br " ;

$salt = "8dC_9Kl?";
$encryptPassword = md5($password . $salt);

  require('database.php');

    // Add the product to the database  
    $query = 'INSERT INTO user
                 (firstName, lastName, email, password)
              VALUES
                 (:firstName, :lastName, :email, :password)';
    $statement = $db->prepare($query);
    $statement->bindValue(':firstName', $firstName);
    $statement->bindValue(':lastName', $lastName);
    $statement->bindValue(':email', $email);
    $statement->bindValue(':password', $encryptPassword);
    // $statement->bindValue(':phoneNumber', $phoneNumber);
    // $statement->bindValue(':address', $address);
    $statement->execute();
    $statement->closeCursor();
    
}


// login

function loginValidationUser($email, $password){
   session_start();

  $passwordCheck = $password;
  require('database.php');

  $query1 = 'SELECT password, firstName, lastName, isAdmin, isActive FROM User WHERE email = :email';
  $statement1 = $db->prepare($query1);
  $statement1->bindValue(':email', $email);
  $statement1->execute();
  $dataFetching = $statement1->fetch();
  $passwordFromDatabase = $dataFetching['password'];
  $adminCheck = $dataFetching['isAdmin'];
  $firstName = $dataFetching['firstName'];
  $lastName = $dataFetching['lastName'];
  $isActive = $dataFetching['isActive'];
  $statement1->closeCursor();

  // print_r($email. $password . "ouuyjhb");
  
  if (!empty($passwordFromDatabase)) 
  {
    // print_r("eeeee");
    $salt = "8dC_9Kl?";
    if(md5($passwordCheck . $salt) == $passwordFromDatabase && ($adminCheck == false) && ($isActive == true))
    {
      //Loading Home Page
      header('Location: ../course.php');  
      $_SESSION['user_email'] = $email;
      // $_SESSION['user_count'] = $_SESSION['user_count'] + 1;
      
    }

    // if($passwordCheck == $passwordFromDatabase && ($adminCheck == false)){
    //       header('Location: ../course.php');
    // }

    else
    {
      // echo "string";
      //Setting Cookie
      $name = 'accessCheck';
      $value = 'incorrectPassword';
      $expire = strtotime('+1 year');
      $path = '/';
      setcookie($name, $value, $expire, $path);

      //Loading login Page
      header('Location: ../login.php');
      
    }
  }
  else
  {
    // echo "string";
    //Setting Cookie
    $name = 'accessCheck';
    $value = 'incorrectPassword';
    $expire = strtotime('+1 year');
    $path = '/';
    setcookie($name, $value, $expire, $path);

    //Loading login Page
    header('Location: ../login.php');
  }



}



 ?>