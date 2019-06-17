<?php 
session_start();

$_SESSION['adminEmail'] = "";

$btnCheck = filter_input(INPUT_COOKIE, 'accessCheck');  
echo '<style type="text/css">
                #incorrectPassword {
                    display: none;
                }
                </style>';
  if ($btnCheck == "incorrectPassword") {
    echo '<style type="text/css">
                #incorrectPassword {
                    display: block;
                }
                </style>';
        $expire = strtotime('-1 year');
        setcookie('accessCheck', '', $expire, '/');
  }
?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Online Exam</title>
    <link rel="stylesheet" href="css/pure-min.css">
    <link rel="stylesheet" href="css/pure-responsive-min.css">
    <link rel="stylesheet" href="css/style.css">

  </head>
  <body>
    
                    <div><center><h1>Administrator Access</h1></center<h1>
                  <centre></div>
                  <center><h2>Power to control the system!</h2></center>
                <center><div c id="incorrectPassword" role="alert">
                     I'm afraid, but email/password didn't match!!
                  </div></centre>
            
          
        <div class="content pure-u-1 pure-u-md-1-2">
            <div class="header-medium">

                <div class="items">
                    <h1 class="subhead">Login</h1>

                    <div c id="incorrectPassword" role="alert">
                     I'm afraid, but email/password didn't match!!
                  </div>
           <form action="../admin/model/dataValidationAdmin.php" method="post" class="pure-form pure-form-stacked">
            <input type="hidden" name="action" value="saveUser">
                        <fieldset>

                            <label for="login-username">Email</label>
                            <input id="login-username" type="email"  name="loginUsername" required data-msg="Please enter your username" placeholder="Email" class="pure-input-1" value="">

                            <label for="login-password">Password</label>
                            <input id="login-password" type="password" name="loginPassword" required data-msg="Please enter your password" placeholder="Password" class="pure-input-1" value="">

                            <button type="submit" class="pure-button button-success">Sign in</button>
                        </fieldset>
                    </form>
                </div>
              </div>
            </div>

        
  </body>
</html>