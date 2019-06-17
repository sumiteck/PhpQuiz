<?php 

require('database.php');
require('questionDB.php');


if ($_SERVER['REQUEST_METHOD'] === 'POST'){

    $courseName = filter_input(INPUT_POST, 'courseName');  
    $question = filter_input(INPUT_POST, 'question');  
    $option1 = filter_input(INPUT_POST, 'option1'); 
    $option2 = filter_input(INPUT_POST, 'option2'); 
    $option3 = filter_input(INPUT_POST, 'option3'); 
    $option4 = filter_input(INPUT_POST, 'option4'); 
    $correctOption = filter_input(INPUT_POST, 'correctOption');  
    
    if (isset($_POST['updateQuestion'])) {
        //Check if Course Exist
        if (!empty(isQuestionExist($question))) {
            //Update Question
            updateQuestionByQuestion($courseName, $question, $option1, $option2, $option3, $option4, $correctOption);
            
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
        header('Location: ../addQuestion.php');
    }
    else{
        //save question here
        saveQuestion($courseName, $question, $option1, $option2, $option3, $option4, $correctOption);

        //Setting Cookie
        $name = 'btnCheck';
        $value = 'save';
        $expire = strtotime('+1 year');
        $path = '/';
        setcookie($name, $value, $expire, $path);
        
        //Loading Page
        header('Location: ../addQuestion.php');
        
    }
}
?>