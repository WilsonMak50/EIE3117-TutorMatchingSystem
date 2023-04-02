<?php
    require 'mysql-connect.php';
    if(isset($_COOKIE["UserID"])) {

        $cookieid=$_COOKIE["UserID"];
        $sql="SELECT * FROM users WHERE uid=? ; ";
        $stmt=mysqli_stmt_init($connect);
        if(!mysqli_stmt_prepare($stmt,$sql)){
            header("Location: /login.php?error=sqlerror");
            exit();
        }else{
            mysqli_stmt_bind_param($stmt,"s",$cookieid);
            mysqli_stmt_execute($stmt);
            $result =mysqli_stmt_get_result($stmt);

            if($row = mysqli_fetch_assoc($result)){
                if($row['servicetype']=='tut'){
                    session_start();
                    $token =bin2hex(random_bytes(32));
                    $_SESSION['csrf_token']=$token;
                    
                    header("Location:/tut.php?login=success");

                }else if($row['servicetype']=='std'){
                    session_start();
                    $token =bin2hex(random_bytes(32));
                    $_SESSION['csrf_token']=$token;
                    header("Location:/std.php?login=success");
                }

            }
        }

        
    }else{
        session_start();
        $token =bin2hex(random_bytes(32));
        $_SESSION['csrf_token']=$token;

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
   
        $secmsg = filter_input(INPUT_GET, 'error', FILTER_SANITIZE_STRING);

    
        $valid_errors = array(
            'emptyfields',
            'wrongpwd'
        );

        // Check if error code is valid and display error message
        if (isset($secmsg) && in_array($secmsg, $valid_errors)) {
            switch ($secmsg) {
                case 'emptyfields':
                    echo '<p class="signuperror">Fill in all fields!</p>';
                    break;
                case 'wrongpwd':
                    echo '<p class="signuperror">Wrong password!</p>';
                    break;
                default:
                    // Handle invalid error code
                    break;
            }
        } 
    ?>

                <form action="/login_acc.php" method="post" class="login-form">
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
                            <input type="hidden" name="csrf_token" value="<?php echo $token; ?>">
                            <br>
                            <br>
                        </div>
  
                        <button type="submit" name="login-submit">Log in</button>
                        <a class="btn" href="index.php" role="button">Back</a>
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