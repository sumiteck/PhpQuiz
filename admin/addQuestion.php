<?php 

session_start();

if($_SESSION['adminEmail'] == "")
{
   // not logged in
   header('Location: ../admin/login.php');
   exit();
}


require('model/questionDB.php');
$GLOBALS['$questionId'] = "";
$GLOBALS['$questionData']['courseName'] = "";
$GLOBALS['$questionData']['question'] = "";
$GLOBALS['$questionData']['option1'] = "";
$GLOBALS['$questionData']['option2'] = "";
$GLOBALS['$questionData']['option3'] = "";
$GLOBALS['$questionData']['option4'] = "";
$GLOBALS['$questionData']['correctOption'] = "";

if (isset($_GET['id'])) {
    $GLOBALS['$questionId'] = $_GET['id'];

    $GLOBALS['$questionData'] = getQuestionWithQuestionId($GLOBALS['$questionId']);
}


$btnCheck = filter_input(INPUT_COOKIE, 'btnCheck');  
echo '<style type="text/css">
                #updateAlert {
                    display: none;
                }
                #saveAlert {
                    display: none;
                }
                #addQuestionForm {
                    display: block;
                }
                #noUpdateAlert{
                    display: none;
                }
                </style>';

switch ($btnCheck) {
    case "update":
        // echo "update";
        echo '<style type="text/css">
                #updateAlert {
                    display: block;
                }
                #addQuestionForm {
                    display: none;
                }
                </style>';
        $expire = strtotime('-1 year');
        setcookie('btnCheck', '', $expire, '/');

        break;
    case "noUpdate":
        echo '<style type="text/css">
                #addQuestionForm {
                    display: none;
                }
                #noUpdateAlert{
                    display: block;
                }
                </style>';
        $expire = strtotime('-1 year');
        setcookie('btnCheck', '', $expire, '/');

        break;

    case "save":
        // echo "Save";
        echo '<style type="text/css">
                #saveAlert {
                    display: block;
                }
                #addQuestionForm {
                    display: none;
                }
                </style>';
        $expire = strtotime('-1 year');
        setcookie('btnCheck', '', $expire, '/');

        break;
    default:
        // echo "Form";
        echo '<style type="text/css">
                #addQuestionForm {
                    display: block;
                }
                </style>';
}
?>



<!DOCTYPE html>
<html>
  <head>

    <title>Online Exam</title>
      <link rel="stylesheet" href="css/style.basic.css">

    <link rel="stylesheet" href="css/pure-min.css">
    <link rel="stylesheet" href="css/pure-responsive-min.css">
    <link rel="stylesheet" href="css/style.css">
</head>
  <body onload="chartLoad()">
    <div>
      
      <header>
        <nav>
                <!-- Navbar Brand --><a href="index.php">
                  <div><span class="subhead">Onlinw Exam </span><strong class="subhead">Admin</strong>
                <!-- Toggle Button--><a id="toggle-btn" href="#" ><span></span><span></span><span></span></a>
              </div>
              <!-- Navbar Menu -->
              <ul>
              
                <!-- Logout    -->
                <li><a href="login.php">Logout</a></li>
              </ul>
        </nav>
      </header>

        <!-- Side Navbar -->
        <div class="sidebar pure-u-1 pure-u-md-3-24">
            <div id="menu">
                <div class="pure-menu">
                    <p class="pure-menu-heading">
                        <h1><?php echo $_SESSION['fullName']; ?></h1>
              <p>Admin</p>
                    </p>
                    <ul class="pure-menu-list">

            <li><a href="index.php" class="pure-menu-link">Home </a></li>
            <li><a href="addUser.php" class="pure-menu-link">Add User</a></li>
            <li><a href="courses.php">Courses </a></li>
            <li><a href="addCourse.php" class="pure-menu-link">Add Course</a></li>
            <li><a href="questions.php" class="pure-menu-link">Question Bank </a></li>
            <li><a href="addQuestion.php" class="pure-menu-link">Add Questions </a></li>
            <li><a href="login.php" class="pure-menu-link">Login page </a></li>
          </ul>
           </div>
            </div>
        </div>
      <main class="main">
          <!-- Page Header-->

              <h2 >Forms</h2>


          <!-- Forms Section-->
          <section> 
            <div>
              <div>
               
                <!-- Form Elements -->
                <div >
                  <div >
                    
                    <div>
                      <h3 >Questions </h3>
                    </div>
                    <div >
<!-- ------------------ Form Starts here -->
                    <div id="saveAlert" role="alert">
                           Great, New Question Successfully Added!!
                        </div>
                        <div id="updateAlert" role="alert">
                           Great, Question Successfully Updated!!
                        </div>
                        <div id="noUpdateAlert" role="alert">
                           Updation Failed! <br>No such question exists!!
                        </div>
                        <div id="addQuestionForm" >
                      <form action="../admin/model/dataValidationQuestion.php" method="post">
                        
                        <div>
                          <label>Course & Question</label>
                          <div>
                            <div >
                              <input id="courseName" type="text" name="courseName" required  value="<?php print_r($GLOBALS['$questionData']['courseName']); ?>">
                              <label for="courseName" >Course Name      </label>
                            </div>
                            <div>
                              <input id="newQuestion" type="text" name="question" required  value="<?php print_r($GLOBALS['$questionData']['question']); ?>">
                              <label for="newQuestion" > Question    </label>
                            </div>
                          </div>
                        </div>
                        <div></div>
                        <div>
                          <label>Options</label>
                          <div >
                            <div>
                              <input id="option1" type="text" name="option1" required value="<?php print_r($GLOBALS['$questionData']['option1']); ?>">
                              <label for="option1" >Input Option 1      </label>
                            </div>
                            <div>
                              <input id="option2" type="text" name="option2" required value="<?php print_r($GLOBALS['$questionData']['option2']); ?>">
                              <label for="option2" >Input Option 2     </label>
                            </div>
                            <div>
                            <input id="option3" type="text" name="option3" required value="<?php print_r($GLOBALS['$questionData']['option3']); ?>">
                            <label for="option3" >Input Option 3     </label>
                            </div>
                            <div>
                              <input id="option4" type="text" name="option4" required value="<?php print_r($GLOBALS['$questionData']['option4']); ?>">
                              <label for="option4" >Input Option 4      </label>
                            </div>
                          </div>
                        </div>
                        <div>
                          <label>Correct Options</label>
                          <div>
                            <div>
                              <input id="correctOption" type="text" name="correctOption" required value="<?php print_r($GLOBALS['$questionData']['correctOption']); ?>">
                              <label for="correctOption" >Input Correct Option</label>
                            </div>
                            
                          </div>
                        </div>
                        
                        <div>
                          <div>
                            <input type="submit"  name="saveQuestion" value="Save Question">
                            <input type="submit"  name="updateQuestion" value="Update Question">
                          </div>
                        </div>
                      </form>
                    </div>
                  </div>
                  </div>
                </div>
              </div>
            </div>
          </section>

      </main>
    <!-- JavaScript files-->
    <script>
    function myFunction() {
    var x = document.getElementById("successAlert");
    var y = document.getElementById("failAlert");
      if (x.style.display === "none")             // check the data from the data base an then send alerts
      {
          x.style.display = "block";
      } else {
          x.style.display = "none";
      }
    }
  </body>
</html>