<?php
if(isset($_POST['login-submit'])){
    require 'mysql-connect.php';

    $myUserName=$_POST['username'];
    $myPassword=$_POST['password'];


    if(empty($myUserName || empty($password)))
    { 
        header("Location:/EIE3117/login.php?error=emptyfields");
        exit();
    }else{
        $sql="SELECT * FROM users WHERE uid=? ; ";
        $stmt=mysqli_stmt_init($connect);
        if(!mysqli_stmt_prepare($stmt,$sql)){
            header("Location: /EIE3117/login.php?error=sqlerror");
            exit();
        }else{
            mysqli_stmt_bind_param($stmt,"s",$myUserName);
            mysqli_stmt_execute($stmt);
            $result =mysqli_stmt_get_result($stmt);
            if($row = mysqli_fetch_assoc($result)){
                $pwdcheck= password_verify($myPassword,$row['pwd']);
                if($pwdcheck== false){
                    header("Location: /EIE3117/login.php?error=wrongpwd");
                    exit();
                }else if($pwdcheck==true){
                         
                    

                    if($row['servicetype']== "tut"){
                        session_start();
                        $_SESSION['SID']=$row['uid'];
                        $_SESSION['SName']=$row['nickName'];
                        if(!isset($_COOKIE["UserID"])) {
                            setcookie("UserID",$row['uid'], time() + (60 * 60 * 24)); // create the cookie
                            } else {
                            setcookie("UserID",$row['uid'], time() + (60 * 60 * 24)); // cookie exist and updata
                        }  
                        
                        header("Location:/EIE3117/tut.php?login=success");
                    }else if($row['servicetype']== "std"){
                        session_start();
                        $_SESSION['SID']=$row['uid'];
                        $_SESSION['SName']=$row['nickName'];
                        if(!isset($_COOKIE["UserID"])) {
                            setcookie("UserID",$row['uid'], time() + (60 * 60 * 24)); // create the cookie
                            } else {
                            setcookie("UserID",$row['uid'], time() + (60 * 60 * 24)); // cookie exist and updata
                        }  
                        header("Location:/EIE3117/std.php?login=success");
                    }

                    }else{
                            header("Location: /EIE3117/login.php?error=nouser");
                            exit();

                    }

                    
                
                }else{
                    header("Location: /EIE3117/login.php?error=wrongpwd");
                    exit();
                }

            }

            mysqli_stmt_close($stmt);
            mysqli_close($connect);

        }
    }



?>