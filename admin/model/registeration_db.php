<?php 

function deleteUser($email){
require('database.php');

    $query1 = "DELETE FROM User
              WHERE email = :email";

    $statement1 = $db->prepare($query1);
    $statement1->bindValue(':email', $email);
    $statement1->execute();
    $statement1->closeCursor();
}

function isUserExist($email){
    require('database.php');

    $query1 = 'SELECT email FROM user WHERE email = :email';
    $statement1 = $db->prepare($query1);
    $statement1->bindValue(':email', $email);
    $statement1->execute();
    $dataFetching = $statement1->fetch();
    $statement1->closeCursor();

    return $dataFetching;
}

function saveUser($firstName, $lastName, $email, $password, $phoneNumber, $address, $userAccess){
	require_once('database.php');


$salt = "8dC_9Kl?";
$encryptPassword = md5($password . $salt);

	require('database.php');

    // Add the product to the database  
    $query = 'INSERT INTO user
                 (firstName, lastName, email, password, phoneNumber, address, isActive)
              VALUES
                 (:firstName, :lastName, :email, :password, :phoneNumber, :address, :isActive)';
    $statement = $db->prepare($query);
    $statement->bindValue(':firstName', $firstName);
    $statement->bindValue(':lastName', $lastName);
    $statement->bindValue(':email', $email);
    $statement->bindValue(':password', $encryptPassword);
    $statement->bindValue(':phoneNumber', $phoneNumber);
    $statement->bindValue(':address', $address);
    $statement->bindValue(':isActive', $userAccess);
    $statement->execute();
    $statement->closeCursor();
    
}

function updateUser($firstName, $lastName, $email, $password, $address, $phoneNumber, $userAccess){

require('database.php');

$salt = "8dC_9Kl?";
$encryptPassword = md5($password . $salt);
$query = 'UPDATE user 
          SET firstName = :firstName, lastName = :lastName, password = :password, address = :address, phoneNumber = :phoneNumber, isActive = :isActive
          WHERE email = :email';

    $statement = $db->prepare($query);
    $statement->bindValue(':firstName', $firstName);
    $statement->bindValue(':lastName', $lastName);
    $statement->bindValue(':email', $email);
    $statement->bindValue(':password', $encryptPassword);
    $statement->bindValue(':address', $address);
    $statement->bindValue(':phoneNumber', $phoneNumber);
    $statement->bindValue(':isActive', $userAccess);
    $statement->execute();
    $statement->closeCursor();
}

function changeUserAccess($email){
require('database.php');

    // $query = "DELETE FROM User
    //           WHERE email = :email";

    $query1 = 'SELECT isActive FROM User WHERE email = :email';
    $statement1 = $db->prepare($query1);
    $statement1->bindValue(':email', $email);
    $statement1->execute();
    $passwordFetching = $statement1->fetch();
    $activeUserCheck = $passwordFetching['isActive'];


    if ($activeUserCheck) {
      
      $query = 'UPDATE user 
                  SET isActive = :isActive
                  WHERE email = :email';

      $statement = $db->prepare($query);
      $statement->bindValue(':email', $email);
      $statement->bindValue(':isActive', false);
      $statement->execute();
      $statement->closeCursor();
    }
    else{

      $query = 'UPDATE user 
                SET isActive = :isActive
                WHERE email = :email';

      $statement = $db->prepare($query);
      $statement->bindValue(':email', $email);
      $statement->bindValue(':isActive', true);
      $statement->execute();
      $statement->closeCursor();
    }
    
}
 
function loginValidationUser($email, $password){

  $a = $password;
  require('database.php');

  $query1 = 'SELECT email, password, isActive FROM User WHERE email = :email';
  $statement1 = $db->prepare($query1);
  $statement1->bindValue(':email', $email);
  $statement1->execute();
  $passwordFetching = $statement1->fetch();
  $passwordFromDatabase = $passwordFetching['password'];
  $activeUserCheck = $passwordFetching['isActive'];
  // $qw = $passwordFetching['email'];
  $statement1->closeCursor();
  // echo "this is the data from the database: ".$passwordFromDatabase ."  " .$qw; 
  
  if (!empty($passwordFromDatabase)) 
  {
    // echo $passwordFromDatabase . $password;
    $salt = "8dC_9Kl?";
    if(md5($a . $salt) == $passwordFromDatabase)
    {

      if ($activeUserCheck == true) {
        include('../admin/index.html');
      }
      // echo "Login Successful";
      //   $query2 = 'UPDATE User
      //                SET isActive = :isActive
      //       WHERE email = :email';
      // $statement = $db->prepare($query2);
      // $statement->bindValue(':isActive', true);
      //  $statement->bindValue(':email', $email);
      // $statement->execute();
      // $statement->closeCursor();

      
    }
    else {
      echo "Login Failed 1";
    }
  }else
  {
    
      echo "Login Failed 2";
  }

}

function loginValidationAdmin($email, $password){

  $a = $password;
  require('database.php');

  $query1 = 'SELECT password, isAdmin FROM User WHERE email = :email';
  $statement1 = $db->prepare($query1);
  $statement1->bindValue(':email', $email);
  $statement1->execute();
  $dataFetching = $statement1->fetch();
  $passwordFromDatabase = $dataFetching['password'];
  $adminCheck = $dataFetching['isAdmin'];
  $statement1->closeCursor();
  
  if (!empty($passwordFromDatabase)) 
  {
    $salt = "8dC_9Kl?";
    if(md5($a . $salt) == $passwordFromDatabase)
    {
      echo "Login Successful";
      $query2 = 'UPDATE User
                     SET isActive = :isActive
            WHERE email = :email';
      $statement = $db->prepare($query2);
      $statement->bindValue(':isActive', true);
      $statement->bindValue(':email', $email);
      $statement->execute();
      $statement->closeCursor();

      if($adminCheck == true){
        include('../index.html');
      }else{
        echo "You Don't have Admin access";
      }
    }

    else {
      echo "Login Failed 1";
    }
  }else
  {
      echo "Login Failed 2";
  }

}

function chnageIsActive($email)
{
  require('database.php');
  $query3 = 'UPDATE User
                SET isActive = :isActive
                WHERE email = :email';
  $statement = $db->prepare($query3);
  $statement->bindValue(':isActive', false);
  $statement->bindValue(':email', $email);
  $statement->execute();
  $statement->closeCursor();          
}

 ?>