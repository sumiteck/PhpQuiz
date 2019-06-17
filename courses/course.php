<?php

session_start();
require('model/database.php');


/* exit if user not logged in already */
if (!isset($_SESSION['user_email'])) {
    // not logged in
    header('Location: login.php');
    exit();
}


function getAllCourses()
{
    global $db;
    $query = 'SELECT courseId, courseName, passingMarks FROM Courses
                WHERE isCourseActive = true
                ORDER BY courseId';
    $statement = $db->prepare($query);
    $statement->execute();
    $data = $statement->fetchAll();
    $statement->closeCursor();
    return $data;

}

function getHighestScore($courseId)
{
    global $db;
    $query = "SELECT max(score) FROM TestAttempt WHERE _courseId = '$courseId' limit 1";

    $statement = $db->prepare($query);
    $statement->execute();
    $data = $statement->fetch();
    $statement->closeCursor();
    return $data;
}


function getUserName($email)
{
    global $db;
    $query = "SELECT firstName, lastName FROM user WHERE email = '$email'";

    $statement = $db->prepare($query);
    $statement->execute();
    $data = $statement->fetch();
    $statement->closeCursor();
    // print_r($data);
    return $data;
}


?>

<!DOCTYPE html>
<html>
<head>
    <title>Online Exam</title>
    <link rel="stylesheet" href="css/style.basic.css">
    <link rel="stylesheet" href="css/main.css">


    <style type="text/css">
        a {
            text-decoration: none !important;
        }

    </style>

</head>
<body>

<header>

    <div class="topnav">
        <a href="#">Changerz Quiz</a>

        <a href="login.php" style="float: right">
            <?php
            if (isset($_SESSION['user_email'])) {
                $user = getUserName($_SESSION['user_email']);
                echo $user['firstName'] . " " . $user['lastName'];
            }
            ?>, Logout</a>
    </div>
</header>


<nav class="sidenav">
    <!-- Sidebar Navidation Menus-->
    <h1 style="color: white; alignment: center;" >Menu</h1>
    <hr/>
    <ul class="list-unstyled">

        <li class="active"><a href="course.php"> Courses </a></li>
        <li><a href="profile.php"> Profile </a></li>
        <li><a href="quizattempt.php"> Quiz Attempts</a></li>
    </ul>
</nav>

<main class="main">
    <h2 class="no-margin-bottom">Courses</h2>
    <div class="card-deck">
        <?php $i = 0 ?>
        <?php $courses = getAllCourses(); ?>
        <?php foreach ($courses

        as $course):

        ?>
        <?php $i = $i + 1;
        // print_r($course['courseId']);
        ?>

        <a href= <?php echo "../questions?id=" . $course['courseId'] ?>>


            <div><h1> <?php echo "# Test " . $i ?> </h1>
                <!-- <p style="float: right;">  </p> -->

            </div>
            <div class="card-body">
                <h3 class="card-title">

                    <?php echo $course['courseName']; ?>

                </h3>

                <!--  <p class="card-text">
                     <?php echo "Passing marks: " . 8; ?>
                     </p> -->

                <p class="card-text">

                    <?php
                    $passingMarks = $course['passingMarks'];

                    echo "Passing marks: " . $passingMarks . "<br>";

                    $highScore = getHighestScore($course['courseId']);

                    if (isset($highScore[0])) {
                        echo "Highest Score: " . $highScore[0];
                    } else {
                        echo "Highest Score: " . 0;
                    }; ?>

                </p>
            </div>
    </div>
    </a>
    <?php endforeach; ?>


</main>


</body>
</html>