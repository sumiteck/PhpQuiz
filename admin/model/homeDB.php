<?php


function getAllUsersAttempts(){
  require('database.php');

  $query = 'SELECT u.firstName, u.lastName, u.email, u.phoneNumber, score, date1, c.courseName 
        FROM TestAttempt t 
          INNER JOIN User u 
            ON u.email = t.email 
          INNER JOIN Courses c 
            ON c.courseId = t._courseId';
  $statement = $db->prepare($query);
  $statement->execute();
  $dataFetching = $statement->fetchAll();        //2D array of userData
  $statement->closeCursor();
  
  return $dataFetching;
}
// function selectDate($dateCheck)
// {
//   require('database.php');
//   $query = 'SELECT date1 FROM TestAttempt WHERE DATE_FORMAT(date1, "%Y-%m-%d") = :date1';
//   $statement = $db->prepare($query);
//   $statement->bindValue(':date1', $dateCheck);
//   $statement->execute();
//   $dataFetching = $statement->fetchAll();        //2D array of userData
//   $statement->closeCursor();
  
//   return $dataFetching;

// }
function getAllUsersByDate($dateCheck){
  require('database.php');

  $query = 'SELECT u.firstName, u.lastName, u.email, u.phoneNumber, score, date1, c.courseName 
        FROM TestAttempt t 
          INNER JOIN User u 
            ON u.email = t.email 
          INNER JOIN Courses c 
            ON c.courseId = t._courseId
            WHERE DATE_FORMAT(date1, "%Y-%m-%d") = :date1';
  $statement = $db->prepare($query);
  $statement->bindValue(':date1', $dateCheck);
  $statement->execute();
  $dataFetching = $statement->fetchAll();        //2D array of userData
  $statement->closeCursor();
  
  return $dataFetching;
}
function formatDate($date) 
{ 
  $date_array = explode("/",$date); // split the array
  $var_day = $date_array[0]; //day seqment
  $var_month = $date_array[1]; //month segment
  $var_year = $date_array[2]; //year segment
  $new_date_format = "$var_year-$var_month-$var_day"; // join them together
    
    return $new_date_format; 
} 

function separateDataTime($dateTime)
{
  
  $array = explode(" ",$dateTime); // split the array
  $date = $array[0]; //date seqment
  $time = $array[1]; //time segment

  return $date;
}

function getAllUsersAttemptsOrderByHighest(){
  require('database.php');

  $query = 'SELECT u.firstName, u.lastName, u.email, u.phoneNumber, score, date1, c.courseName 
        FROM TestAttempt t 
          INNER JOIN User u 
            ON u.email = t.email 
          INNER JOIN Courses c 
            ON c.courseId = t._courseId
            ORDER BY score DESC';
  $statement = $db->prepare($query);
  $statement->execute();
  $dataFetching = $statement->fetchAll();        //2D array of userData
  $statement->closeCursor();
  
  return $dataFetching;
}

function getAllUsersAttemptsOrderByLowest(){
  require('database.php');

  $query = 'SELECT u.firstName, u.lastName, u.email, u.phoneNumber, score, date1, c.courseName 
        FROM TestAttempt t 
          INNER JOIN User u 
            ON u.email = t.email 
          INNER JOIN Courses c 
            ON c.courseId = t._courseId
            ORDER BY score ASC';
  $statement = $db->prepare($query);
  $statement->execute();
  $dataFetching = $statement->fetchAll();        //2D array of userData
  $statement->closeCursor();
  
  return $dataFetching;
}
function getAllUsers(){
  require('database.php');

  $query = 'SELECT * FROM user';
  $statement = $db->prepare($query);
  $statement->execute();
  $dataFetching = $statement->fetchAll();        //2D array of userData
  $statement->closeCursor();
  
  return $dataFetching;
}

function getAllActiveUsers()
{
  require('database.php');

  $query = 'SELECT isActive FROM user Where isActive = :isActive';
  $statement = $db->prepare($query);
  $statement->bindValue(':isActive', true);
  $statement->execute();
  $dataFetching = $statement->fetchAll();        //2D array of userData
  $statement->closeCursor();
  
  return sizeof($dataFetching);
}
function getAllActiveCourses()
{
  require('database.php');

  $query = 'SELECT isActiveCourse FROM courses Where isActiveCourse = :isActiveCourse';
  $statement = $db->prepare($query);
  $statement->bindValue(':isActiveCourse', true);
  $statement->execute();
  $dataFetching = $statement->fetchAll();        //2D array of userData
  $statement->closeCursor();
  
  return sizeof($dataFetching);
}

function getAllPassedUsers(){
require('database.php');
  $query = 'SELECT u.firstName, u.lastName, u.email, score, c.courseName 
        FROM TestAttempt t 
          INNER JOIN User u 
            ON u.email = t.email 
          INNER JOIN Courses c 
            ON c.courseId = t._courseId 
          WHERE score >= 8 
          ORDER BY score';
  $statement = $db->prepare($query);
  $statement->execute();
  $dataFetching = $statement->fetchAll();        //2D array of userData
  $statement->closeCursor();
  
  // $GLOBALS['passedUsers'] = count($dataFetching);
  return $dataFetching;
}

function getAllFailedUsers(){
  require('database.php');

  $query = 'SELECT score FROM TestAttempt 
              WHERE score < 8';
  $statement = $db->prepare($query);
  $statement->execute();
  $dataFetching = $statement->fetchAll();        
  $statement->closeCursor();

  // $GLOBALS['failedUsers'] = count($dataFetching);
  return $dataFetching;
}

function getAvgByCourseName($courseName)
{
  require('database.php');

    $query1 = 'SELECT courseId FROM courses WHERE courseName = :courseName';
    $statement1 = $db->prepare($query1);
    $statement1->bindValue(':courseName', $courseName);
    $statement1->execute();
    $dataFetching = $statement1->fetch();
    $statement1->closeCursor();
    
    $query = 'SELECT score From TestAttempt WHERE _courseId = :courseId';
    $statement = $db->prepare($query);
    $statement->bindValue(':courseId', $dataFetching['courseId']);
    $statement->execute();
    $dataFetching2 = $statement->fetchAll();
    $statement->closeCursor();

    $score = 0;
    foreach ($dataFetching2 as $value) {
       $score += ($value['score']);
     }
    return (($score)/sizeof($dataFetching2));
}

function getAvgScore(){
  require('database.php');

  $query = 'SELECT score FROM TestAttempt';
  $statement = $db->prepare($query);
  $statement->execute();
  $dataFetching = $statement->fetchAll();        
  $statement->closeCursor();
  $score = 0;
  foreach ($dataFetching as $value) {
     $score += ($value['score']);
   }
  return (($score)/sizeof($dataFetching));
}


function getAllCourseCount(){
  require('database.php');

  $query = 'SELECT courseName FROM courses';
  $statement = $db->prepare($query);
  $statement->execute();
  $dataFetching = $statement->fetchAll();        
  $statement->closeCursor();

  return count($dataFetching);

}

function getHighestScoreByCourseName($courseName)
{
  require('database.php');

    $query1 = 'SELECT courseId FROM courses WHERE courseName = :courseName';
    $statement1 = $db->prepare($query1);
    $statement1->bindValue(':courseName', $courseName);
    $statement1->execute();
    $dataFetching1 = $statement1->fetch();
    $statement1->closeCursor();

    $query = 'SELECT score From TestAttempt WHERE _courseId = :courseId';

    $statement = $db->prepare($query);
    $statement->bindValue(':courseId', $dataFetching1['courseId']);
    $statement->execute();
    $dataFetching = $statement->fetchAll();
    $statement->closeCursor();

    $score = array();
    foreach ($dataFetching as $value) {
      array_push($score, $value['score']);
     }
  return max($score);
}
// echo getHighestScoreByCourseName("Fun & IQ");


function getLowestScoreByCourseName($courseName)
{
  require('database.php');

    $query1 = 'SELECT courseId FROM courses WHERE courseName = :courseName';
    $statement1 = $db->prepare($query1);
    $statement1->bindValue(':courseName', $courseName);
    $statement1->execute();
    $dataFetching1 = $statement1->fetch();
    $statement1->closeCursor();

    $query = 'SELECT score From TestAttempt WHERE _courseId = :courseId';

    // $query = 'SELECT * From TestAttempt WHERE _courseId = :courseId ORDER BY score';

    $statement = $db->prepare($query);
    $statement->bindValue(':courseId', $dataFetching1['courseId']);
    $statement->execute();
    $dataFetching = $statement->fetchAll();
    $statement->closeCursor();

    $score = array();
    foreach ($dataFetching as $value) {
      array_push($score, $value['score']);
     }
  return min($score);
}


?>