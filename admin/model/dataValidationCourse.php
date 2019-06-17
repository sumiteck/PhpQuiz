<?php 

require('database.php');
require('courseDB.php');


if ($_SERVER['REQUEST_METHOD'] === 'POST'){

    $courseName = filter_input(INPUT_POST, 'courseName');  
    $numberOfQuestions = ""; 
    $passingMarks = filter_input(INPUT_POST, 'passingMarks'); 
    $courseAccess = filter_input(INPUT_POST, 'courseAccess');
    
    if (isset($_POST['updateCourse'])) {
        //Check if Course Exist
        if (!empty(isCourseExist($courseName))) {
            //Update User
            updateCourse($courseName, $numberOfQuestions, $passingMarks, $courseAccess);
            
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
        header('Location: ../addCourse.php');
    }
    else{
        //save Course
        echo $courseName. "    " .  $passingMarks. "  " . $courseAccess;
        addCourse($courseName, $numberOfQuestions, $passingMarks, $courseAccess);

        //Setting Cookie
        $name = 'btnCheck';
        $value = 'save';
        $expire = strtotime('+1 year');
        $path = '/';
        setcookie($name, $value, $expire, $path);
        
        //Loading Page
        header('Location: ../addCourse.php');
    }
}
?>