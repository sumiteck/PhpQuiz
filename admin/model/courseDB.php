<?php 

function changeUserAccess($courseName){
  require('database.php');

    // $query = "DELETE FROM User
    //           WHERE email = :email";

    $query1 = 'SELECT isCourseActive FROM courses WHERE courseName = :courseName';
    $statement1 = $db->prepare($query1);
    $statement1->bindValue(':courseName', $courseName);
    $statement1->execute();
    $passwordFetching = $statement1->fetch();
    $activeUserCheck = $passwordFetching['isCourseActive'];


    if ($activeUserCheck) {
      
      $query = 'UPDATE courses 
                  SET isCourseActive = :isCourseActive
                  WHERE courseName = :courseName';

      $statement = $db->prepare($query);
      $statement->bindValue(':courseName', $courseName);
      $statement->bindValue(':isCourseActive', false);
      $statement->execute();
      $statement->closeCursor();
    }
    else{

      $query = 'UPDATE courses 
                SET isCourseActive = :isCourseActive
                WHERE courseName = :courseName';

      $statement = $db->prepare($query);
      $statement->bindValue(':courseName', $courseName);
      $statement->bindValue(':isCourseActive', true);
      $statement->execute();
      $statement->closeCursor();
    }
    
}

function getNumberOfQuestionWithCourseName($courseName)
{
    require('database.php');

    $query1 = 'SELECT courseId FROM courses WHERE courseName = :courseName';
    $statement1 = $db->prepare($query1);
    $statement1->bindValue(':courseName', $courseName);
    $statement1->execute();
    $dataFetching = $statement1->fetch();
    $statement1->closeCursor();

    $query = 'SELECT courseId FROM quizQuestions WHERE courseId = :courseId';
    $statement = $db->prepare($query);
    $statement->bindValue(':courseId', $dataFetching['courseId']);
    $statement->execute();
    $numberOfQuestions = $statement->fetchAll(); 
    $statement->closeCursor();

    return sizeof($numberOfQuestions);
}


function getAllCourse(){
  require('database.php');

  $query = 'SELECT * FROM courses';
  $statement = $db->prepare($query);
  $statement->execute();
  $dataFetching = $statement->fetchAll();        
  $statement->closeCursor();
  return $dataFetching;
}

function getAllActiveCourse(){
  require('database.php');

  $query = 'SELECT isCourseActive FROM courses WHERE isCourseActive = :isCourseActive';
  $statement = $db->prepare($query);
  $statement->bindValue(':isCourseActive', true);
  $statement->execute();
  $dataFetching = $statement->fetchAll();        
  $statement->closeCursor();
  return $dataFetching;
}

function addCourse($courseName, $numberOfQuestions, $passingMarks, $courseAccess){
  // require_once('database.php');
    require('database.php');
    // Add the product to the database  
    $query = 'INSERT INTO courses
                 (courseName, numberOfQuestions, passingMarks, isCourseActive)
              VALUES
                 (:courseName, :numberOfQuestions, :passingMarks, :isCourseActive)';
    $statement = $db->prepare($query);
    $statement->bindValue(':courseName', $courseName);
    $statement->bindValue(':numberOfQuestions', $numberOfQuestions);
    $statement->bindValue(':passingMarks', $passingMarks);
    $statement->bindValue(':isCourseActive', $courseAccess);
    $statement->execute();
    $statement->closeCursor();
}
function updateCourse($courseName, $numberOfQuestions, $passingMarks, $courseAccess){
    require('database.php');
    // Add the product to the database  
    $query = "UPDATE courses 
            SET numberOfQuestions = :numberOfQuestions, passingMarks = :passingMarks, isCourseActive = :isCourseActive
                  WHERE courseName = :courseName";
    $statement = $db->prepare($query);
    $statement->bindValue(':courseName', $courseName);
    $statement->bindValue(':numberOfQuestions', $numberOfQuestions);
    $statement->bindValue(':passingMarks', $passingMarks);
    $statement->bindValue(':isCourseActive', $courseAccess);
    $statement->execute();
    $statement->closeCursor();
}

function deleteCourse($courseName){                  //Check for only one query statement 
    require('database.php');

    $query = "DELETE FROM courses WHERE courseName = :courseName";
    $statement = $db->prepare($query);
    $statement->bindValue(':courseName', $courseName);
    $statement->execute();
    
}

function isCourseExist($courseName){
    require('database.php');

    $query1 = 'SELECT courseName FROM courses WHERE courseName = :courseName';
    $statement1 = $db->prepare($query1);
    $statement1->bindValue(':courseName', $courseName);
    $statement1->execute();
    $dataFetching = $statement1->fetch();
    $statement1->closeCursor();

    return $dataFetching;
}

?>