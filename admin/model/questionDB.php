<?php 

function deleteQuestion($questionId){

    require('database.php');
    $query = "DELETE FROM quizQuestions WHERE questionId = :questionId";
    $statement = $db->prepare($query);
    $statement->bindValue(':questionId', $questionId);
    $statement->execute();
    $statement->closeCursor();
}

function saveQuestion($courseName, $question, $option1, $option2, $option3, $option4, $correctOption)
{
    require('database.php'); 


    $query1 = 'SELECT courseId FROM courses WHERE courseName = :courseName';
    $statement1 = $db->prepare($query1);
    $statement1->bindValue(':courseName', $courseName);
    $statement1->execute();
    $dataFetching = $statement1->fetch();
    $statement1->closeCursor();

    $query = 'INSERT INTO quizQuestions
                 (courseId, question, option1, option2, option3, option4, correctOption)
              VALUES
                 (:courseId, :question, :option1, :option2, :option3, :option4, :correctOption)';
    $statement = $db->prepare($query);
    $statement->bindValue(':courseId', $dataFetching['courseId']);
    $statement->bindValue(':question', $question);
    $statement->bindValue(':option1', $option1);
    $statement->bindValue(':option2', $option2);
    $statement->bindValue(':option3', $option3);
    $statement->bindValue(':option4', $option4);
    $statement->bindValue(':correctOption', $correctOption);
    $statement->execute();
    $statement->closeCursor();
}

function updateQuestionByQuestion($courseName, $question, $option1, $option2, $option3, $option4, $correctOption)
{
    require('database.php');

    $query1 = 'SELECT courseId FROM courses WHERE courseName = :courseName';
    $statement1 = $db->prepare($query1);
    $statement1->bindValue(':courseName', $courseName);
    $statement1->execute();
    $dataFetching = $statement1->fetch();
    $statement1->closeCursor();
    
    $query = "UPDATE quizQuestions 
                SET courseId = :courseId, question = :question, option1 = :option1, option2 = :option2, option3 = :option3, option4 = :option4, correctOption = :correctOption
                WHERE question = '$question'";
    $statement = $db->prepare($query);
    $statement->bindValue(':courseId', $dataFetching['courseId']);
    $statement->bindValue(':question', $question);
    $statement->bindValue(':option1', $option1);
    $statement->bindValue(':option2', $option2);
    $statement->bindValue(':option3', $option3);
    $statement->bindValue(':option4', $option4);
    $statement->bindValue(':correctOption', $correctOption);
    $statement->execute();
    $statement->closeCursor();
}

function isQuestionExist($question){
    require('database.php');

    $query1 = 'SELECT question FROM quizQuestions WHERE question = :question';
    $statement1 = $db->prepare($query1);
    $statement1->bindValue(':question', $question);
    $statement1->execute();
    $dataFetching = $statement1->fetch();
    $statement1->closeCursor();

    return $dataFetching;
}

function getQuestionsWithCourseName($courseName){

    require('database.php');

    $query1 = 'SELECT courseId FROM courses WHERE courseName = :courseName';
    $statement1 = $db->prepare($query1);
    $statement1->bindValue(':courseName', $courseName);
    $statement1->execute();
    $dataFetching = $statement1->fetch();
    $statement1->closeCursor();


    $query = "SELECT c.courseName, q.questionId, q.question, q.option1, q.option2, q.option3, q.option4, q.correctOption 
                FROM quizQuestions q 
                    INNER JOIN Courses c 
                        ON c.courseId = q.courseId
                    WHERE c.courseId = :courseId";
    $statement = $db->prepare($query);
    $statement->bindValue(':courseId', $dataFetching['courseId']);
    $statement->execute();
    $dataFetching = $statement->fetchAll();
    $statement->closeCursor();

    return $dataFetching;
}

function getQuestionWithQuestionId($questionId)
{
    require('database.php');
    $query = "SELECT c.courseName, q.questionId, q.question, q.option1, q.option2, q.option3, q.option4, q.correctOption 
                FROM quizQuestions q 
                    INNER JOIN Courses c 
                        ON c.courseId = q.courseId
                    WHERE q.questionId = :questionId";
    $statement = $db->prepare($query);
    $statement->bindValue(':questionId', $questionId);
    $statement->execute();
    $dataFetching = $statement->fetch();
    $statement->closeCursor();

    return $dataFetching;
}


?>