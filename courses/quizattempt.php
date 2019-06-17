
<?php 

session_start();

require('model/database.php');
  /* exit if user not logged in already */
  if(!isset($_SESSION['user_email']))
{
    // not logged in
    header('Location: login.php');
    exit();
}


$btnCheck = filter_input(INPUT_COOKIE, 'btnCheck');  
echo '<style type="text/css">
                #updateAlert {
                    display: none;
                }
                #updateProfileForm {
                    display: block;
                }
                #noUpdateAlert{
                    display: none;
                }
                </style>';

switch ($btnCheck) {
    case "update":
        echo "update";
        echo '<style type="text/css">
                #updateAlert {
                    display: block;
                }
                #updateProfileForm {
                    display: none;
                }
                </style>';
        $expire = strtotime('-1 year');
        setcookie('btnCheck', '', $expire, '/');
        break;
    case "noUpdate":
        echo '<style type="text/css">
                #updateAlert {
                    display: none;
                }
                #updateProfileForm {
                    display: none;
                }
                #noUpdateAlert{
                    display: block;
                }
                </style>';
        $expire = strtotime('-1 year');
        setcookie('btnCheck', '', $expire, '/');

        break;

  
    default:
        // echo "Form";
        echo '<style type="text/css">
                #updateAlert {
                    display: none;
                }
                #saveAlert {
                    display: none;
                }
                #updateProfileForm {
                    display: block;
                }
                #noUpdateAlert{
                    display: none;
                }
                </style>';
}


function getUserAttempt($email){
  
  global $db;

  $query1 = 'SELECT _courseId, date1, score FROM testattempt WHERE email = :email';
  $statement1 = $db->prepare($query1);
  $statement1->bindValue(':email', $email);
  $statement1->execute();
  $dataFetching = $statement1->fetchAll();
  $statement1->closeCursor();
  return $dataFetching;
}


  function getUserName($email){
      global $db;
      $query = "SELECT firstName, lastName FROM user WHERE email = '$email'";

      $statement = $db->prepare($query);
      $statement->execute();
      $data = $statement->fetch();
      $statement->closeCursor();
      // print_r($data);
      return $data;   
  }


  function getCourseName($courseId){
      global $db;
      $query = "SELECT courseName FROM courses WHERE courseId = '$courseId'";

      $statement = $db->prepare($query);
      $statement->execute();
      $data = $statement->fetch();
      $statement->closeCursor();
      // print_r($data);
      return $data['courseName'];   
  }

?>

<!DOCTYPE html>
<html>
  <head>

      <title>Online Exam</title>
      <link rel="stylesheet" href="css/style.basic.css">

  </head>
  <body>

      <!-- Main Navbar-->
      <header>
      <span>Knowlegde Calculator &nbsp;</span><strong>User</strong>
              <ul >
                <!-- Logout    -->
                <li class="nav-item"><a href="login.php" class="nav-link logout"> <span class="d-none d-sm-inline" name = "btnLogout">Logout</span><i class="fa fa-sign-out"></i></a></li>
              </ul>
      </header>

        <nav class="sidenav">
          <!-- Sidebar Header-->
            <p>User</p>
              <h1 >
                
                 <?php 
                if(isset($_SESSION['user_email'])){
                  $user = getUserName($_SESSION['user_email']);
                  echo $user['firstName']. " ". $user['lastName'] ;
                }
                ?>
              </h1>

              <hr>

          <!-- Sidebar Navidation Menus--><span class="heading">Main</span>
          <ul class="list-unstyled">
                    <!-- <li><a href="index.html"> <i class="icon-home"></i>Home </a></li> -->
                    <li><a href="course.php"> <i class="icon-padnote"></i>Courses </a></li>
                    <li><a href="profile.php"> <i class="icon-interface-windows"></i>Profile </a></li>
                    
                    <li class="active"><a href="quizattempt.php"> <i class="icon-grid"></i>Quiz Attempts</a></li>
<!--                     <li><a href="tables.html"> <i class="icon-grid"></i>Question Bank </a></li>
                    <li><a href="tables.html"> <i class="icon-grid"></i>Add Questions </a></li>
                    <li><a href="login.html"> <i class="icon-interface-windows"></i>Login page </a></li> -->
          </ul>
        </nav>
      <main class="main">

                <h2 > Quiz Attempts </h2>
                <h3 class="h4">Attempt Details</h3>
                <div id="updateProfileForm" >
                    <form action="quizattempt.php" method="post" >
                    <table >
                      <thead>
                        <tr>
                        
                          <th>Course Name</th>
                          <th>Score</th>
                          <th>Date</th>
                          <!-- <th>Action</th> -->
                        </tr>
                      </thead>
                      <tbody>
                       <?php 
                            $a = getUserAttempt($_SESSION['user_email']);                           

                            foreach ($a as $info) {
                              $attemptDate = Date("Y-m-d", strtotime($info['date1']));
                              $courseName = getCourseName($info['_courseId']);
                              echo "<tr>";
                              echo "<td>".$courseName."</td>";
                              echo "<td>".$info['score']. "<br>"."</td>";
                              echo "<td>".$attemptDate."</td>";
                              echo " </tr>";
                            }
                          ?>
                        </tbody>
                    </table>
                  </div>
                </div>
                    </form>
                           <div class="alert alert-success" id="updateAlert" role="alert" >
                               Great, User Successfully Updated!!
                           </div>
                           <div class="alert alert-danger" id="noUpdateAlert" role="alert">
                               Updation Failed! <br>No such user exists!!
                           </div>


        </main>


  </body>
</html>