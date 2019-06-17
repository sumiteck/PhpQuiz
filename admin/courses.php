<?php 

session_start();

if($_SESSION['adminEmail'] == "")
{
   // not logged in
   header('Location: ../admin/login.php');
   exit();
}

require('model/courseDB.php');

$btnCheck = filter_input(INPUT_COOKIE, 'btnCheck');  
echo '<style type="text/css">
                #deleteAlert {
                    display: none;
                }
                #accessChange {
                    display: none;
                }
                </style>';

switch ($btnCheck) {
    case "accessChange":
        echo '<style type="text/css">
                #accessChange {
                    display: block;
                }
              </style>';
        $expire = strtotime('-1 year');
        setcookie('btnCheck', '', $expire, '/');

        break;
    case "deleteAlert":
        echo '<style type="text/css">
                #deleteAlert {
                    display: block;
                }
                </style>';
        $expire = strtotime('-1 year');
        setcookie('btnCheck', '', $expire, '/');

        break;
default:
        echo '<style type="text/css">
                #deleteAlert {
                    display: none;
                }
                #accessChange {
                    display: none;
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

              <h2 >All Courses</h2>
<section>
                       <div class="pure-u-1 pure-u-md-2-3">
                        <div class="column-block">
                            <table class="pure-table pure-table-horizontal">
                              <h3>Courses Details</h3>
                                <thead>
                                <tr>
                                     <th>#</th>
                        <th>Course Name</th>
                        <th>Number of Questions</th>
                        <th>Passing Marks</th>
                        <th>Is Active</th>
                        <th>Course Access Control</th>
                        <th>Delete Course</th>
                                </tr>
                                </thead>

                                <tbody>
                                <?php 
                        $a = getAllCourse();
                         $b = 0;
                          foreach ($a as $info) {
                            
                          $b++;
                          echo "<tr>";
                          echo "<td>".$b. "<br>"."</td>";
                          echo "<td>".$info['courseName']."</td>";
                          echo "<td>".getNumberOfQuestionWithCourseName($info['courseName'])."</td>";
                          echo "<td>".$info['passingMarks']."</td>";
                          // echo "<td>".$info['isCourseActive']."</td>";
                          if ($info['isCourseActive']) {
                                echo "<td>"."Yes"."</td>";
                              }
                              else{
                                echo "<td>"."No"."</td>";
                              }

                          echo '<td><button type="button"  data-toggle="tooltip" data-placement="top" title="Active/Disable Course">
                                 <a style="color: white;" href="../admin/deletion/changeCourseAccess.php?id='.urlencode($info['courseName']).'">Course Access</a>
                              </button> </td>';

                          echo '<td><button type="button"  data-toggle="tooltip" data-placement="top" title="Deleting Course will delete all questions in this course as well">
                                 <a style="color: white;" href="../admin/deletion/deleteCourse.php?id='.urlencode($info['courseName']).'">Delete Course</a>
                            </button> </td>';

                            echo " </tr>";
                        }
                      ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
             </section>
        </main>
  </body>
</html>