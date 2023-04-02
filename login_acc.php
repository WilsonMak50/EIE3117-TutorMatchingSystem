<?php

if(isset($_POST['login-submit'])){
    session_start();
    require 'mysql-connect.php';
    $myUserName = mysql_real_escape_string($connect, $_POST['username']);
    $myPassword = mysql_real_escape_string($connect, $_POST['password']);
    

    // Check if the CSRF token in the session matches the one submitted with the form
    if (!empty($_POST['csrf_token']) && hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])) {
        session_unset();
        session_destroy();
    } else {
    header('Location: login.php?error=invalidtoken');
    exit;
    }

    
    
    $myUserName = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING);
    $myPassword = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);
    

    if(empty($myUserName || empty($password)))
    { 
        header("Location:login.php?error=emptyfields");
        exit();
    }else{
        $sql="SELECT * FROM users WHERE uid=? ; ";
        $stmt=mysqli_stmt_init($connect);
        if(!mysqli_stmt_prepare($stmt,$sql)){
            header("Location: /login.php?error=sqlerror");
            exit();
        }else{
            mysqli_stmt_bind_param($stmt,"s",$myUserName);
            mysqli_stmt_execute($stmt);
            $result =mysqli_stmt_get_result($stmt);
            if($row = mysqli_fetch_assoc($result)){
                $pwdcheck= password_verify($myPassword,$row['pwd']);
                if($pwdcheck== false){
                    header("Location: /login.php?error=wrongpwd");
                    exit();
                }else if($pwdcheck==true){
                         
                    

                    if($row['servicetype']== "tut"){
                        session_start();
                        $token =bin2hex(random_bytes(32));
                        $_SESSION['csrf_token']=$token;
                        if(!isset($_COOKIE["UserID"])) {
                            setcookie("UserID",$row['uid'], time() + 3600,'/','eie3117tutorcow.top',true,true,'Strict'); // create the cookie
                            } else {
                            setcookie("UserID",$row['uid'], time() + 3600,'/','eie3117tutorcow.top',true,true,'Strict'); // cookie exist and updata
                        }  
                        
                        header("Location:/tut.php?login=success");
                    }else if($row['servicetype']== "std"){
                        session_start();
                        $token =bin2hex(random_bytes(32));
                        $_SESSION['csrf_token']=$token;
                        if(!isset($_COOKIE["UserID"])) {
                            setcookie("UserID",$row['uid'], time() + 3600,'/','eie3117tutorcow.top',true,true,'Strict'); // create the cookie
                            } else {
                            setcookie("UserID",$row['uid'], time() + 3600,'/','eie3117tutorcow.top',true,true,'Strict'); // cookie exist and updata
                        }  
                        header("Location:/std.php?login=success");
                    }

                    }else{
                            header("Location: /login.php?error=nouser");
                            exit();

                    }

                    
                
                }else{
                    header("Location: /login.php?error=wrongpwd");
                    exit();
                }

            }

            mysqli_stmt_close($stmt);
            mysqli_close($connect);

        }
    }

?>