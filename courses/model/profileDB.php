
<?php  
// require_once('database.php');
function isUserExist($email){
    require('database.php');

    $query1 = 'SELECT email FROM user WHERE email = :email';
    $statement1 = $db->prepare($query1);
    $statement1->bindValue(':email', $email);
    $statement1->execute();
    $dataFetching = $statement1->fetch();
    $statement1->closeCursor();
    // print_r(email);
    return $dataFetching;
}

  function updateProfile($email, $fName, $lName, $phone, $address){
    
    require('database.php');
    echo "$email";

    // Add the product to the database  
    $query = "UPDATE user SET firstName = :firstName, lastName = :lastName, address = :address, phoneNumber = :phoneNumber
                 WHERE email = :email";
    $statement = $db->prepare($query);
    $statement->bindValue(':email', $email);
    $statement->bindValue(':firstName', $fName);
    $statement->bindValue(':lastName', $lName);
    $statement->bindValue(':address', $address);
    $statement->bindValue(':phoneNumber', $phone);
    $statement->execute();
    $statement->closeCursor();
  }


// not used
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
  
  if (!empty($passwordFromDatabase)) 
  {
    $salt = "8dC_9Kl?";
    if(md5($passwordCheck . $salt) == $passwordFromDatabase && ($adminCheck == false) && ($isActive == true))
    {
      //Loading Home Page
      header('Location: ../course.php');
      $_SESSION['user_email'] = $email;
      
    }

    else
    {
      echo "string";
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
    echo "string";
    //Setting Cookie
    $name = 'accessCheck';
    $value = 'notAdmin';
    $expire = strtotime('+1 year');
    $path = '/';
    setcookie($name, $value, $expire, $path);

    //Loading login Page
    // header('Location: ../login.php');
  }


}




?>

