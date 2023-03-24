<?php
    session_start();
    session_unset();
    session_destroy();

    if(isset($_COOKIE["UserID"])) {
        
        setcookie("UserID", time() - (60 * 60 * 24)); 
    } 


?>
<html>
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Tutor Cow-Log In</title>
        <link rel="stylesheet" href="style.css">
    </head>
<body>
    <section id="loginpage">
        <div class="container">
            <div class="login-left">
                <div class="login-header">
                    <h1>Thank You for using our service !</h1>
                    <p>You have been logged out</p>
                </div>
             
            </div>
            <div class="login-right">
                <img src="./img/login.svg">
            </div>
        </div>
    </section>
    
</body>
</html>