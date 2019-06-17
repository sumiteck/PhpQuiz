
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

$userInfo = getUserInfo($_SESSION['user_email']);
$firstName = $userInfo['firstName'];
$lastName = $userInfo['lastName'];
$address = $userInfo['address'];
$phoneNumber = $userInfo['phoneNumber'];

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


function getUserInfo($email){
  
   global $db;

  $query1 = 'SELECT firstName, lastName, address, phoneNumber FROM User WHERE email = :email';
  $statement1 = $db->prepare($query1);
  $statement1->bindValue(':email', $email);
  $statement1->execute();
  $dataFetching = $statement1->fetch();
  // print_r($dataFetching['firstName']);
  // $GLOBALS['firstName'] = $dataFetching['firstName'];
  $lastName = $dataFetching['lastName'];
  $address = $dataFetching['address'];
  $phoneNumber = $dataFetching['phoneNumber'];
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

?>

<!DOCTYPE html>
<html>
  <head>
      <title>Online Exam</title>
      <link rel="stylesheet" href="css/style.basic.css">
  </head>
  <body>

      <!-- Main Navbar-->
      <header >

            <span>Knowlegde Calculator &nbsp;</span><strong>User</strong>
                  <!-- <div class="brand-text d-none d-sm-inline-block d-lg-none"><strong>BD</strong></div></a> -->
                <!-- Toggle Button-->
              <ul>
                <li ><a href="login.php" class="nav-link logout"> <span name = "btnLogout">Logout</span></a></li>
              </ul>
            </div>
          </div>
        </nav>
      </header>


        <!-- Side Navbar -->
        <nav class="sidenav">

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



          <ul class="list-unstyled">
                    <!-- <li><a href="index.html"> <i class="icon-home"></i>Home </a></li> -->
                    <li><a href="course.php"> Courses </a></li>
                    <li  class="active"><a href="profile.php"> Profile </a></li>
                    
                    <li><a href="quizattempt.php"> Quiz Attempts</a></li>
<!--                     <li><a href="tables.html"> <i class="icon-grid"></i>Question Bank </a></li>
                    <li><a href="tables.html"> <i class="icon-grid"></i>Add Questions </a></li>
                    <li><a href="login.html"> <i class="icon-interface-windows"></i>Login page </a></li> -->
          </ul>
        </nav>
      
        <main class="main">
          <!-- Page Header-->

              <h2 >User Profile</h2>
            <h3 class="h4">User Details</h3>


                    <div class="card-body">
<!-- ------------------ Form Starts here -->

                        <!-- --------------- -->

                       <div id="updateProfileForm" >
                      <form action="../courses/model/dataValidationProfile.php" method="post" class="form-horizontal">
                        
                        <div class="row">

                          <label >Basic Information</label>

                            <div class="form-group-material">
                                <label for="register-email">Email Address      </label>
                              <input id="register-email" type="email" name="registerEmail" value="<?php echo $_SESSION['user_email']; ?>" required readonly="readonly" >

                            </div>
                            <div class="form-group-material">
                                <label for="firstName" >First Name      </label>
                              <input id="firstName" type="text" name="firstName" value="<?php echo $firstName ?>" required >

                            </div>
                            <div class="form-group-material">
                                <label for="lastName" >Last Name     </label>
                              <input id="lastName" type="text" name="lastName" value="<?php echo $lastName ?>" required >

                            </div>
                            <div class="form-group-material">
                                <label for="phone" >Phone     </label>
                            <input id="phone" type="text" name="phoneNumber" value="<?php echo $phoneNumber ?>" required >

                            </div>
                            <div class="form-group-material">
                                <label for="address" >Address      </label>
                              <input id="address" type="text" name="address" value="<?php echo $address ?>" required >

                            </div>

                        </div>
                        

                            <!-- <button type="submit" class="btn btn-secondary">Cancel</button> -->
                            <button type="submit" class="btn btn-primary" name="update">Update</button>

                      </form>
                    </div>
                    </div>


            <div id="updateAlert" role="alert" >
                Great, User Successfully Updated!!
            </div>
            <div id="noUpdateAlert" role="alert">
                Updation Failed! <br>No such user exists!!
            </div>

        </main>
          


  </body>
</html>