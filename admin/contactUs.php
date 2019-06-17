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



$to = "somebody@example.com";
$subject = "My subject";
$txt = "Hello world!";
$headers = "From: webmaster@example.com" . "\r\n" .
"CC: somebodyelse@example.com";

mail($to,$subject,$txt,$headers);
?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Online Exam</title>
  </head>
  <body>
    <div>
      <div>
        <div>
          <div>
            <!-- Logo & Information Panel-->
            
              <div>
                <div>
                  <div>
                    <h1>Contact Us</h1>
                  </div>
                  <p><strong> We'll get back to you very soon!!</strong> </p>
                </div>
              </div>
        
            <!-- Form Panel    -->
            
              <div>
                <div>
                  <form action="mailto:abc@gmail.com" enctype="text/plain" method="post">
                     <!-- <input type="hidden" name="action" value="saveUser"> -->
                     <div>
                      <input id="name" type="text" name="name" required data-msg="Please enter your name">
                      <label for="name">Full Name</label>
                    </div>
                    <div>
                      <input id="login-username" type="text" name="Admin Email" required data-msg="Please enter your username">
                      <label for="login-username">Your Email</label>
                    </div>
                    <div>
                      <input id="issue" type="text" name="Your Issue" required data-msg="Please elaborate the issue your are facing">
                      <label for="issue"  >Elaborate your Issue</label><br>
                    </div>
                      <input type="submit" value="Send email to developer Team" >
                  </form>
                  <a href="../admin/login.php">Login Page</a>
                  </div>
                </div>
              
            <!-- </div> -->
          </div>
        </div>
      </div>
    </div>
  </body>
</html>