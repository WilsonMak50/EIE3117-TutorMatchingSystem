<?php
    require 'mysql-connect.php';
    if(isset($_COOKIE["UserID"])) {

        $cookieid=$_COOKIE["UserID"];
        $sql="SELECT * FROM users WHERE uid=? ; ";
        $stmt=mysqli_stmt_init($connect);
        if(!mysqli_stmt_prepare($stmt,$sql)){
            header("Location: /EIE3117/login.php?error=sqlerror");
            exit();
        }else{
            mysqli_stmt_bind_param($stmt,"s",$cookieid);
            mysqli_stmt_execute($stmt);
            $result =mysqli_stmt_get_result($stmt);

            if($row = mysqli_fetch_assoc($result)){
                if($row['servicetype']=='tut'){
                    session_start();
                    $_SESSION['SID']=$row['uid'];
                     $_SESSION['SName']=$row['nickName'];
                    header("Location:/EIE3117/tut.php?login=success");

                }else if($row['servicetype']=='std'){
                    session_start();
                    $_SESSION['SID']=$row['uid'];
                    $_SESSION['SName']=$row['nickName'];
                    header("Location:/EIE3117/std.php?login=success");
                }

            }
        }

        
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
                    <h1>Welcome to Tutor Cow</h1>
                    <p>Please login to use the platform</p>
                </div>
                <?php
                    if(isset($_GET['error'])){
                        if($_GET['error']=="emptyfields"){
                            echo'<p class="signuperror"> Fill in all fields !</p>';
                        }else if($_GET['error']=="wrongpwd"){
                            echo'<p class="signuperror"> Wrong password ! </p>';
                        }

                    } 
                ?>
                <form action="/EIE3117/login_acc.php" method="post" class="login-form">
                    <div class="login-form-content">
                        <div class="form-item">
                            <label for="username">Enter Username</label>
                            <input type="text" id="username" name="username">
                        </div>
                        <div class="form-item">
                            <label for="password">Enter Password</label>
                            <input type="password" id="password" name="password">
                        </div>
                        <div class="form-item">
                            <br>
                            <br>
                        </div>
                        <!-- <div class="form-item">
                            <div class="checkbox">
                                <lebal for="rememberMe" id="checkboxLebal">Remember Me</lebal>
                                <input type="checkbox" id="rememberMeCheckbox">
                                
                            </div>
                        </div> -->
                        <button type="submit" name="login-submit">Log in</button>
                        <a class="btn" href="index.html" role="button">Back</a>
                    </div>
                </form>
            </div>
            <div class="login-right">
                <img src="./img/login.svg">
            </div>
        </div>
    </section>
    
</body>
</html>