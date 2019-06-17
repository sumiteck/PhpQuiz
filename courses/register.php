<?php
$btnCheck = filter_input(INPUT_COOKIE, 'btnCheck');
echo '<style type="text/css">
                 
                  #saveAlert {
                      display: none;
                  }
                  #registerUserForm {
                      display: block;
                  }
                  #userExistAlert{
                    display: none;
                  }
                 
                  </style>';

switch ($btnCheck) {

    case "saveUser":
        // echo "Save";
        echo '<style type="text/css">
                  #saveAlert {
                      display: block;
                  }
                  #registerUserForm {
                      display: block;
                  }
                  #userExistAlert{
                    display: none;
                  }
                  </style>';
        $expire = strtotime('-1 year');
        setcookie('btnCheck', '', $expire, '/');

        break;

    case "userExist":
        echo '<style type="text/css">
                  #saveAlert {
                      display: none;
                  }
                  #registerUserForm {
                      display: block;
                  }
                  #userExistAlert{
                    display: block;
                  }
                  </style>';
        break;
    default:
        // echo "Form";
        echo '<style type="text/css">
                  #saveAlert {
                      display: none;
                  }
                  #registerUserForm {
                      display: block;
                  }
                  #userExistAlert{
                    display: none;
                  }
                  </style>';
}
?>


<html>
<head>

    <title>Online Exam</title>
    <link rel="stylesheet" type="text/css" href="css/login.css">

</head>
<body>



    <div class="log-form">
        <h2>Register your Account</h2>
        <form action="model/dataValidationRegister.php" method="post">
            <input type="hidden" name="action" value="saveUser">

            <div style="color: green" id="saveAlert" role="alert">
                Great, New User Successfully Added!!
            </div>

            <!-- validation error -->
            <div style="color: red;" id="userExistAlert" role="alert">
                User already exists, please try again!!
            </div>

            <input id="register-fname" type="text" name="registerFname" required
                   placeholder="Please enter your First Name">
            <input id="register-lname" type="text" name="registerLname" required
                   placeholder="Please enter your Last Name">
            <input id="register-email" type="email" name="registerEmail" required
                   placeholder="Please enter a valid email address">
            <input id="register-password" type="password" name="registerPassword" required
                   placeholder="Please enter your password">
            <button id="regidter" type="submit" name="registerSubmit" class="btn">Register</button><br/><br/>
            <small>Already have an account?</small>
            <button class="btn"><a href="login.php" style="text-decoration: none; color: white;">Login</a></button>
        </form>

    </div>

    <!-- ------------------ Form Starts here -->



</body>
</html>