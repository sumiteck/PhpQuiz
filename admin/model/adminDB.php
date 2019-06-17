<?php 
session_start();
function loginValidationAdmin1($email, $password){

$salt = "8dC_9Kl?";
  $passwordCheck = $password;
  require('database.php');

  $query1 = 'SELECT password, firstName, lastName, isAdmin FROM User WHERE email = :email';
  $statement1 = $db->prepare($query1);
  $statement1->bindValue(':email', $email);
  $statement1->execute();
  $dataFetching = $statement1->fetch();
  $passwordFromDatabase = $dataFetching['password'];
  $adminCheck = $dataFetching['isAdmin'];
  $firstName = $dataFetching['firstName'];
  $lastName = $dataFetching['lastName'];
  $statement1->closeCursor();
  
  if (!empty($passwordFromDatabase)) 
  {
    $salt = "8dC_9Kl?";
    if(md5($passwordCheck . $salt) == $passwordFromDatabase && ($adminCheck == true))
    {
      //Loading Home Page
      $_SESSION['adminEmail'] = $email;
      $_SESSION['fullName'] = $firstName." ".$lastName;
      header('Location: ../index.php');
      
      
    }
    else
    {
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
    //Setting Cookie
    $name = 'accessCheck';
    $value = 'notAdmin';
    $expire = strtotime('+1 year');
    $path = '/';
    setcookie($name, $value, $expire, $path);

    //Loading login Page
    header('Location: ../login.php');
  }


}

function checkdata(){
	require('database.php');

	$query = 'SELECT u.firstName, u.lastName, u.email, score, c.courseName 
				FROM TestAttempt t 
					INNER JOIN User u 
						ON u.email = t.email 
					INNER JOIN Courses c 
						ON c.courseId = t._courseId 
					WHERE score >=8 
					ORDER BY score';
	$statement = $db->prepare($query);
	$statement->execute();
	$dataFetching = $statement->fetch();				//2D array of userData
  $statement->closeCursor();
  // echo ($dataFetching['email']);
  print_r($dataFetching);
}

function insertTestAttempt($courseName, $email, $score){

	$currentDate = date("Y/m/d");

	require_once('database.php');
	$query1 = 'SELECT courseId
  				FROM Courses 
  				WHERE courseName = :courseName';
  	$statement1 = $db->prepare($query1);
    $statement1->bindValue(':courseName', $courseName);
    $statement1->execute();
    $dataFetching = $statement1->fetch();
    $statement1->closeCursor();
    $courseIdFromDB = $dataFetching['courseId'];
    echo $courseIdFromDB;

	$query2 = 'INSERT INTO TestAttempt
					(date1, score, _courseId, email)
				VALUES 
					(:date1, :score, :_courseId, :email)';
	$statement = $db->prepare($query2);
    $statement->bindValue(':date1', $currentDate);
    $statement->bindValue(':_courseId', $courseIdFromDB);
    $statement->bindValue(':email', $email);
    $statement->bindValue(':score', $score);
    $statement->execute();
    $statement->closeCursor();
		
}



?>




