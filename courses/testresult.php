


<?php 

   session_start();
   require('model/database.php');

  	 $passingMarks = getCoursePassingMarks($_SESSION['id']);

  	 // echo "correct: " . $_SESSION['correct_count'];
   	// $_SESSION['correct_count'] = 10;
	// echo "Correct count: ". $_SESSION['correct_count'];

	if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    //something posted

	    if (isset($_POST['btnDownload'])) {
	        // btnDownload
	    	// header('Location: ../certificate/index.php');

	    	echo "<script type='text/javascript' language='Javascript'>window.open('../certificate/index.php');</script>";
	    } 
	    // else if (isset($_POST['btnLogout'])) { // logout button tapped
		      
	// 	      if ($_SESSION["user_count"] > 0) {
	// 	         # code...
	// 	         $_SESSION["user_count"] = $_SESSION["user_count"] - 1;
	// 	         header('Location: login.php');
	// 	    }
	}




  
  if ($_SESSION['correct_count'] >= $passingMarks) {
  	
  	 echo '<style type="text/css">
                #pass_div {
                    display: block;
                }#fail_div {
                    display: none;
                }
                </style>';
  }else{
    echo '<style type="text/css">
                #fail_div {
                    display: block;
                }#pass_div {
                    display: none;
                }
                </style>';

  }


  function getUserName($email){
      global $db;
      $query = "SELECT firstName, lastName FROM user WHERE email = '$email'";
      $statement = $db->prepare($query);
      $statement->execute();
      $data = $statement->fetch();
      $statement->closeCursor();
      return $data;   
  }

    function getCoursePassingMarks($courseId){
      global $db;
      $query = "SELECT passingMarks FROM courses WHERE courseId = '$courseId'";

      $statement = $db->prepare($query);
      $statement->execute();
      $data = $statement->fetch();
      $statement->closeCursor();
      // print_r($data);
      return $data['passingMarks'];   
  }

 ?>

<!DOCTYPE html>
<html>
  <head>
    <title>Online Exam</title>
      <link rel="stylesheet" href="css/style.basic.css">

<style type="text/css">
  a{
    text-decoration: none !important;
  }

  /* Style buttons */
.btn {
  background-color: teal;
  border: none;
  color: white;
  padding: 12px 30px;
  cursor: pointer;
  font-size: 20px;
}

/* Darker background on mouse-over */
.btn:hover {
  background-color: #008B8B;
}

</style>

</head>
  <body>

      <!-- Main Navbar-->
      <header>
        <nav >
          <span>Knowlegde Calculator  &nbsp;</span><strong>User</strong>
              <!-- Navbar Menu -->
              <ul >
                <li >
                	<a href="login.php" > <span >Logout</span></a>
                </li>
              </ul>
        </nav>
      </header>


        <!-- Side Navbar -->
        <nav class="sidenav">
          <!-- Sidebar Header-->
              <p>User</p>
              <h1 class="h4">
                <?php 
                if(isset($_SESSION['user_email'])){
                  $user = getUserName($_SESSION['user_email']);
                  echo $user['firstName']. " ". $user['lastName'] ;
                }
                ?>
               </h1>
               <hr>
          <!-- <hr> -->
          <!-- Sidebar Navidation Menus-->
          <span class="heading">Main</span>
          <ul class="list-unstyled">
                    <li><a href="course.php" onclick="return confirm('Warning! \nPlease download your certificate, if passed the test, before redirecting to another window.');"> Courses </a></li>
                    <li><a href="profile.php" onclick="return confirm('Warning! \nPlease download your certificate, if passed the test, before redirecting to another window.');"> Profile </a></li>
                    <li><a href="quizattempt.php" onclick="return confirm('Warning! \nPlease download your certificate, if passed the test, before redirecting to another window.');"> Quiz Attempts</a></li>
                    <li class="active"><a href=""> Test Result</a></li>
          </ul>
        </nav>
      <main class="content">
              <h2>Test Result</h2>




          <!-- Dashboard Counts Section-->

          <form action="" method="post">



                <div class="alert alert-primary" role="alert" id = "pass_div" style="width: 100%; text-align: center;">
                  <h1 style="font-size: 48px;"> 

                  	<?php 
                  	$message = "";
                  	if ($_SESSION['correct_count'] == 8) {
                  		# code...
                  		$message = "Fabulous!";
                  	}else if($_SESSION['correct_count'] == 9){
                  		$message = "Excellent!";
                  	}else{
                  		$message = "Perfect!";
                  	}
                  		echo $message;
                  	 ?>  

                  </h1>
                  <p style="font-size: 18px;"> <?php echo "You have scored ". $_SESSION['correct_count'] . "/10 marks with " . (($_SESSION['correct_count']/10)*100) . "%"; ?> </p>
                 
                  	
                  	<button class="btn" name="btnDownload">Download Certificate</button>
                 
                  

                </div>  

                 <div role="alert" id = "fail_div" style="width: 100%; text-align: center;">
                 	<h1 style="font-size: 48px;"> <?php echo "Failed!"; ?>  </h1>
                  <h1 style="font-size: 40px;"> <?php echo "Give it another chance to pass!!"; ?>  </h1>
                  <p style="font-size: 24px;"> <?php echo "You have scored ". $_SESSION['correct_count'] . "/10 marks with " . (($_SESSION['correct_count']/10)*100) . "%"; ?> </p>

                </div>  

              <!--  </div>
               </div>
               </section>  -->

              </form>  
        </div>
            </div>
          </section>
      </main>


  </body>
</html>