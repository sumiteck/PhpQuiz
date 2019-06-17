<?php 

session_start();

if($_SESSION['adminEmail'] == "")
{
   // not logged in
   header('Location: ../admin/login.php');
   exit();
}


$btnCheck = filter_input(INPUT_COOKIE, 'btnCheck');  
echo '<style type="text/css">
                #updateAlert {
                    display: none;
                }
                #saveAlert {
                    display: none;
                }
                #addUserForm {
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
                #saveAlert {
                    display: none;
                }
                #addUserForm {
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
                #saveAlert {
                    display: none;
                }
                #addCourseForm {
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
                #updateAlert {
                    display: none;
                }
                #saveAlert {
                    display: block;
                }
                #addUserForm {
                    display: none;
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
                #addUserForm {
                    display: block;
                }
                #noUpdateAlert{
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
          <!-- Page Header-->
          <header >
            <div >
              <h2 >Forms</h2>
            </div>
          </header>

          <!-- Forms Section-->
          <section > 
            <div >
              <div>
               
                <!-- Form Elements -->
                <div >
                  <div >
                      <h3>User Details</h3>
                  
                    <div>
<!-- ------------------ Form Starts here -->
                      <div id="saveAlert" role="alert" >
                           Great, New User Successfully Added!!
                        </div>
                        <div id="updateAlert" role="alert" >
                           Great, User Successfully Updated!!
                        </div>
                        <div id="noUpdateAlert" role="alert">
                           Updation Failed! <br>No such user exists!!
                        </div>
                        <div id="addUserForm" >
                      <form action="../admin/model/dataValidationUser.php" method="post">
                        <input type="hidden" name="action" value="saveUser">
                        <div>
                          <label>Mandatory Information</label>
                          <div>
                            <div>
                              <input id="register-email" type="email" name="registerEmail" required>
                              <label for="register-email" class="label-material">Email Address</label>
                            </div>
                            <div>
                              <input id="register-password" type="password" name="registerPassword" required>
                              <label for="register-password" class="label-material">Password</label>
                            </div>
                          </div>
                        </div>

                        <div>
                             <label>User Access <br><small>User is allowed to login or not</small></label>
                            <div>
                            <div>
                              <input id="optionsRadios1" type="radio" checked="" value="1" name="userAccess">
                              <label for="optionsRadios1">Active</label>
                            </div>
                            <div>
                              <input id="optionsRadios2" type="radio" value="0" name="userAccess">
                              <label for="optionsRadios2">Not Active</label>
                            </div>
                          </div>
                        </div>
                        <div></div>
                        <div
        >
                          <label>Basic Information</label>
                          <div>
                            <div>
                              <input id="firstName" type="text" name="firstName" required>
                              <label for="firstName" class="label-material">First Name</label>
                            </div>
                            <div>
                              <input id="lastName" type="text" name="lastName" required>
                              <label for="lastName" class="label-material">Last Name</label>
                            </div>
                            <div>
                            <input id="phone" type="text" name="phoneNumber" required>
                            <label for="phone" class="label-material">Phone</label>
                            </div>
                            <div>
                              <input id="address" type="text" name="address" required>
                              <label for="address" class="label-material">Address</label>
                            </div>
                          </div>
                        </div>
                            <!-- <button type="submit" class="btn btn-secondary">Cancel</button> -->
                            <input type="submit" class="btn btn-primary" name="saveUser" value="Save User">
                            <input type="submit" class="btn btn-primary" name="updateUser" value="Update User">
                      </form>
                    </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </section>
   </main>
  </body>
</html>