<?php 

session_start();
 
require('model/database.php');


  /* exit if user not logged in already */
  if(!isset($_SESSION['user_email']))
{
    // not logged in
    header('Location: ../courses/login.php');
    exit();
}


if (!empty($_GET['id'])) {
  # code...
  $_SESSION["id"] = $_GET['id'];
}

$isNextButtonDisable = "";
$isSubmitButtonDisable = "disabled='disabled'";
$questionArray = [];

$courseInfo = getCourseInfo($_SESSION["id"]);


/* check button click */
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (isset($_POST['next'])) { // next button
      // print_r($_SESSION['index']);

      if(isset($_POST['optradio']))
      {   
       
        $selectedOption = $_POST['optradio'];
        
        $question = $_SESSION['questions'][$_SESSION['index']];
        $correctOption = $question['correctOption'];

        // remove white spaces at end
        $selectedOption = rtrim($selectedOption);
        $correctOption = rtrim($correctOption);

        // if ($correctOption == $selectedOption) {
        if (strcasecmp($selectedOption, $correctOption) == 0){
          $_SESSION['correct_count'] = $_SESSION['correct_count'] + 1;
          // print_r("    correct question count: " . $_SESSION['correct_count']);
          
        }

      }

      if ($_SESSION['index'] == 0) {

        /* save date and time for ATTEMPT */
        date_default_timezone_set('America/Toronto');
        $dateTime = date('y-m-d h:i:s a', time());
        $_SESSION['testTime'] = $dateTime;
        // print_r($_SESSION['testTime']);

        // user started attempt
        // $_SESSION['user_count'] = $_SESSION['user_count'] + 1;


        saveAttempt($_SESSION["id"], $dateTime, $_SESSION['user_email']);


      }

      /// index > 10 condition
      $_SESSION['index'] = $_SESSION['index'] + 1;

      /* enable disable buttons */
      $index = $_SESSION['index'];
      $isNextButtonDisable = $index >= 9 ? "disabled='disabled'" : "";
      $isSubmitButtonDisable = $index >= 9 ? "" : "disabled='disabled'";

      // echo "<br>" . $_SESSION['correct_count'];

      // change style for no question
      echo '<style type="text/css">
                #displayQuestion {
                    display: block;
                }
                #noQuestion{
                    display: none;
                }
                </style>';

    } 
    

    else { // submit button clicked
 
       if(isset($_POST['optradio']))
      {   
       
        $selectedOption = $_POST['optradio'];
        
        $question = $_SESSION['questions'][$_SESSION['index']];
        $correctOption = $question['correctOption'];

        // remove white spaces at end
        $selectedOption = rtrim($selectedOption);
        $correctOption = rtrim($correctOption);

        // echo strcasecmp($selectedOption, $correctOption);

        // if ($correctOption == $selectedOption) {
        if (strcasecmp($selectedOption, $correctOption) == 0){
          $_SESSION['correct_count'] = $_SESSION['correct_count'] + 1;
          // print_r("    correct question count: " . $_SESSION['correct_count']);
        }



      }

      saveScore($_SESSION['user_email'], $_SESSION['correct_count'], $_SESSION['testTime']);

       # code...
      echo '<style type="text/css">
                #displayQuestion {
                    display: block;
                }
                #noQuestion{
                    display: none;
                }
                </style>';
    }
    
}else{
    // print_r("no post");
    

    $questionArray = getQuestionByCourse($_SESSION["id"]);

    if (count($questionArray) > 0) {
      # code...
      echo '<style type="text/css">
                #displayQuestion {
                    display: block;
                }
                #noQuestion{
                    display: none;
                }
                </style>';
    }else{
      echo '<style type="text/css">
                #displayQuestion {
                    display: none;
                }
                #noQuestion{
                    display: block;
                }
                </style>';

    }
    
    $_SESSION['questions'] = $questionArray;
    $_SESSION['index'] = 0;
    $_SESSION['correct_count'] = 0;

    if (empty($_SESSION['user_count'])) {
      # code...
      // echo "index == 0";
      $_SESSION['user_count'] = 0;
      $_SESSION['user_count'] =  $_SESSION['user_count'] + 1;
    }else{
      $_SESSION['user_count'] =  $_SESSION['user_count'] + 1;
    }
    
    // print_r("  <------>count when entered = " . $_SESSION['user_count'] . "<------>");
}

 function getQuestionByCourse($courseId){
    global $db;


      $query = "SELECT * FROM quizQuestions WHERE courseId = $courseId ORDER BY rand() LIMIT 10";

      // $query = "SELECT * FROM quizQuestions WHERE courseId = $courseId LIMIT 10";
      $statement = $db->prepare($query);
      $statement->execute();
      $data = $statement->fetchAll();
      $statement->closeCursor();
      return $data; 
 }

 
 function getCourseInfo($courseId){
    global $db;
      $query = "SELECT * FROM courses WHERE courseId = $courseId";
      $statement = $db->prepare($query);
      $statement->execute();
      $data = $statement->fetch();
      $statement->closeCursor();
      return $data; 
 }

 function saveAttempt($courseId, $attempDate, $email){
    global $db;
    
    // print_r($courseId . $attempDate. $email);
    // Add the product to the database  
    $query = "INSERT INTO testattempt
                 (date1, _courseId, email)
              VALUES
                 (:date1, :courseId, :email)";
    $statement = $db->prepare($query);
    $statement->bindValue(':date1', $attempDate);
    $statement->bindValue(':courseId', $courseId);
    $statement->bindValue(':email', $email);
    // $statement->bindValue(':score', 0);
    $statement->execute();
    $statement->closeCursor();

 }

 function saveScore($email, $score, $attemptDateTime){
    global $db;
      
    // echo $email ."    ". $score. "    ".$attemptDateTime;
    // update score 
    $query = "UPDATE testattempt SET score = $score
                 WHERE email = :email AND date1 = :attemptDateTime";
    $statement = $db->prepare($query);
    $statement->bindValue(':email', $email);
    // $statement->bindValue(':score', $score);
    $statement->bindValue(':attemptDateTime', $attemptDateTime);
    $statement->execute();
    $statement->closeCursor();

    header('Location: ../courses/testresult.php');

 }
 
 ?>

<!DOCTYPE html>
<html>
<head>
	<title></title>



</head>
<body style="background-color: #473E3F">

  <!-- Dashboard Counts Section-->
          

<form action="" method="post">

  <!-- ../courses/testresult.php -->

  <div id = "div1" style="color: white; width: 75%; margin: auto; margin-top: 80px;">
  	
  	<div class="" style="background-color: #292929; border-radius: 10px;";>
    <div class="card-body text-center">
      <p class="card-text">

      	<h2>  
      	<?php  
      		if (isset($courseInfo['courseName'])) {
            echo $courseInfo['courseName'];  
          }
    			
    	?> 
		</h2></p>
    </div>
  </div>


<?php  $questionNumber = 0 ?>

                        <div  id="noQuestion" role="alert" style="margin-top: 15px;">
                           No Questions! <br> Questions will be added soon!!
                        </div>

<div id="displayQuestion" style="width: 100%; margin-top: 35px; background-color: #202020;">
                  <div class="card-header" style="background-color: #292929; margin-top: 10px;">
    <h4>       
    <?php 
        $index = $_SESSION['index'];
        $questions = $_SESSION['questions'];
        if (count($questions) > 0) {
           echo $index + 1 . ". " . $questions[$index]['question'];
        }
    ?> 
                       
    </h4></div>



<div style="padding-left: 10px; padding-bottom: 30px; padding-top: 10px">
<div class="radio" >
  <label><input type="radio" name="optradio" value="<?php 
    $index = $_SESSION['index'];
    $questions = $_SESSION['questions'];
    echo $questions[$index]['option1'];
    
    
     ?>" checked> 
    <?php 
    $index = $_SESSION['index'];
    $questions = $_SESSION['questions'];
    echo $questions[$index]['option1'];
    
     ?>  

  </label>
</div>
<div class="radio" >
  <label><input type="radio" name="optradio" value="<?php  
   $index = $_SESSION['index'];
    $questions = $_SESSION['questions'];
    echo $questions[$index]['option2'];
   ?> " style="padding-left: 10px;" >
   <?php  
   $index = $_SESSION['index'];
    $questions = $_SESSION['questions'];
    echo $questions[$index]['option2'];
   ?> 

 </label>
</div>
<div class="radio" >
  <label><input type="radio" name="optradio" value="<?php 
    $index = $_SESSION['index'];
    $questions = $_SESSION['questions'];
    echo $questions[$index]['option3']; 
    ?> "> 
    <?php 
    $index = $_SESSION['index'];
    $questions = $_SESSION['questions'];
    echo $questions[$index]['option3']; 
    ?> </label>
</div>
<div class="radio" >
  <label><input type="radio" name="optradio" value="<?php 
   $index = $_SESSION['index'];
    $questions = $_SESSION['questions'];
    echo $questions[$index]['option4']; 
   ?>">
   <?php 
   $index = $_SESSION['index'];
    $questions = $_SESSION['questions'];
    echo $questions[$index]['option4']; 
   ?> 
 </label>
</div>

<div class="container" style="width: 100%; margin: auto; padding-left: 30px;" >
	<button type="submit"  name="next" style="width: 47%;"<?php echo $isNextButtonDisable; ?> > Next</button>

	<button type="submit"  name="submit" style="width: 47%" <?php echo $isSubmitButtonDisable; ?>> Submit </button>

</div>

    </form>

</body>
</html>