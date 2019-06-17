<?php

session_start();
// Session_destroy();

unset($_SESSION["user_email"]);
unset($_SESSION["index"]);
unset($_SESSION["questions"]);
unset($_SESSION["id"]); //course id
unset($_SESSION["correct_count"]);
unset($_SESSION["testTime"]);

if (!empty($_SESSION["user_count"])) {
    # code...
    if ($_SESSION["user_count"] > 0) {
        # code...
        $_SESSION["user_count"] = $_SESSION["user_count"] - 1;
        // echo "<--------- user count: " . $_SESSION["user_count"];
    }
}


/* destroy every session instead user_count */

$btnCheck = filter_input(INPUT_COOKIE, 'accessCheck');
echo '<style type="text/css">
                #incorrectPassword {
                    display: none;
                }
                </style>';
if ($btnCheck == "incorrectPassword") {
    // echo "incorrectPassword";
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

    <title>Online Exam</title>
    <link rel="stylesheet" type="text/css" href="css/login.css">

</head>
<body>


<div class="log-form">
    <div class="log-form">
        <h2>Login to your account</h2>
        <form action="model/dataValidationForUser.php" method="post">
            <input type="hidden" name="action" value="saveUser"/>

            <div id="incorrectPassword" role="alert" style="color: red">
                I'm afraid, but email/password didn't match!!
            </div>
            <input type="email" id="login-username" type="text" name="loginUsername" required placeholder="Enter your Email"/>
            <input id="login-password" type="password" name="loginPassword" required placeholder="Enter Password"/>
            <button type="submit" name="login" class="btn">Login</button>
            <button class="btn"><a href="register.php" style="text-decoration: none; color: white;">Register</a></button>
        </form>
    </div>

</body>
</html>