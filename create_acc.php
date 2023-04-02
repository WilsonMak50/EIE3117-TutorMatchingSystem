<?php
if(isset($_POST["signup-submit"]))
{
    require 'mysql-connect.php';
    $validation=0;

    $myUserName = mysqli_real_escape_string($connect, $_POST['username']);
    $myNickName = mysqli_real_escape_string($connect, $_POST['nickname']);
    $myEmail = mysqli_real_escape_string($connect, $_POST['email']);
    $myPassword = mysqli_real_escape_string($connect, $_POST['password']);
    $myRePassword = mysqli_real_escape_string($connect, $_POST['rpassword']);
    $myGender = mysqli_real_escape_string($connect, $_POST['gender']);
    $myBirthday = mysqli_real_escape_string($connect, $_POST['birthday']);
    $myServiceType = mysqli_real_escape_string($connect, $_POST['servicetype']);

    // $myUserName = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING);
    // $myNickName = filter_input(INPUT_POST, 'nickname', FILTER_SANITIZE_STRING);
    // $myEmail = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    // $myPassword = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);
    // $myBirthday = filter_input(INPUT_POST, 'birthday', FILTER_SANITIZE_STRING);
    // $myGender = filter_input(INPUT_POST, 'gender', FILTER_SANITIZE_STRING);
    // $myServiceType = filter_input(INPUT_POST, 'servicetype', FILTER_SANITIZE_STRING);


    $sql = "SELECT uid FROM users WHERE uid=?";
    $stmt = mysqli_stmt_init($connect);
    if(!mysqli_stmt_prepare($stmt,$sql))
    {   
        if($myServiceType=="tut"){
            header("Location: /tutreg.php?error=sqlerror");
            exit();
        }
        if($myServiceType=="std"){
            header("Location: /stdreg.php?error=sqlerror");
            exit();
        }


        
    }else{
        mysqli_stmt_bind_param($stmt,"s",$myUserName);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_store_result($stmt);
        $resultCheck = mysqli_stmt_num_rows($stmt);
        if($resultCheck>0){

            if($myServiceType=="tut"){
                header("Location: /tutreg.php?error=uidtaken&nickname=".$myNickName."&email=".$myEmail."");
                exit();
            }
            if($myServiceType=="std"){
                header("Location: /stdreg.php?error=uidtaken&nickname=".$myNickName."&email=".$myEmail."");
                exit();
            }
            
        }else{
            $validation=1;
        }  
    }
        
    if(empty($myUserName)|| empty($myNickName)||empty($myEmail)||empty($myPassword)||empty($myRePassword)||empty($myGender)||empty($myBirthday)||empty($myServiceType)){

        if($myServiceType=="tut"){
            header("Location: /tutreg.php?error=emptyfields&nickname=".$myNickName."&email=".$myEmail."");
            exit();
        }

        if($myServiceType=="std"){
            header("Location: /stdreg.php?error=emptyfields&nickname=".$myNickName."&email=".$myEmail."");
            exit();
        }



    }else if(!filter_var($myEmail,FILTER_VALIDATE_EMAIL)&&(!preg_match("/^[a-zA-Z]*$/",$myNickName))){

        if($myServiceType=="tut"){
            header("Location: /tutreg.php?error=invalidmailnn");
            exit(); 
        }
        if($myServiceType=="std"){
            header("Location: /stdreg.php?error=invalidmailnn");
            exit(); 
        }

    }else if (!filter_var($myEmail,FILTER_VALIDATE_EMAIL)){
        if($myServiceType=="tut"){
            header("Location: /tutreg.php?error=invalidmail&nickname=".$myNickName."");
            exit();
        }
        if($myServiceType=="std"){
            header("Location: /stdreg.php?error=invalidmail&nickname=".$myNickName."");
            exit();
        }

    }else if (!preg_match("/^[0-9a-zA-Z]*$/",$myUserName)){
        if($myServiceType=="tut"){
            header("Location: /tutreg.php?error=invliduid&nickname=".$myNickName."&email=".$myEmail."");
            exit();
        }
        if($myServiceType=="std"){
            header("Location: /stdreg.php?error=invliduid&nickname=".$myNickName."&email=".$myEmail."");
            exit();
        }

    }else if ($myPassword!==$myRePassword){
        if($myServiceType=="tut"){
            header("Location: /tutreg.php?error=invlidpwd&nickname=".$myNickName."&email=".$myEmail."");
            exit();
        }
        if($myServiceType=="std"){
            header("Location: /stdreg.php?error=invlidpwd&nickname=".$myNickName."&email=".$myEmail."");
            exit();
        }
        
    }else{
        $validation=2;
    }

    if($validation == 2){
        $sql="INSERT INTO users (uid,nickName,email,pwd,birthday,gender,servicetype) VALUES (?,?,?,?,?,?,?)";
        $stmt=mysqli_stmt_init($connect);

        if(!mysqli_stmt_prepare($stmt,$sql)){
            if($myServiceType=="tut"){
            header("Location: /tutreg.php?error=sqlerror");
            exit();
            }
            if($myServiceType=="std"){
                header("Location: /stdreg.php?error=sqlerror");
                exit();
            }

        }else{    
            $hashedPwd = password_hash($myPassword, PASSWORD_DEFAULT);
            mysqli_stmt_bind_param($stmt,"sssssss",$myUserName,$myNickName,$myEmail,$hashedPwd,$myBirthday,$myGender,$myServiceType);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_close($stmt);
            if($myServiceType=="tut"){
                $myImg='profiletut.jpg';
                $sql="INSERT INTO tutor (uid, img,name,dob) VALUES (?,?,?,?)";
                $stmt=mysqli_stmt_init($connect);
                mysqli_stmt_prepare($stmt,$sql);
                mysqli_stmt_bind_param($stmt,"ssss",$myUserName,$myImg,$myNickName,$myBirthday);
                mysqli_stmt_execute($stmt);
                header("Location:/login.php?signup=success");
                exit();
             }else if($myServiceType=="std"){
                $myImg='profilestd.svg';
                $sql="INSERT INTO student (uid, name,img,dob) VALUES (?,?,?,?)";
                $stmt=mysqli_stmt_init($connect);
                mysqli_stmt_prepare($stmt,$sql);
                mysqli_stmt_bind_param($stmt,"ssss",$myUserName,$myNickName,$myImg,$myBirthday);
                mysqli_stmt_execute($stmt);
                header("Location:/login.php?signup=success");
                 exit();
             }
            
            
        }
        
    }

    mysqli_stmt_close($stmt);
    mysqli_close($connect);
}else{

    if($myServiceType=="tut"){
    header("Location:/tutreg.php");
    }else{
        header("Location:/stdreg.php");
    }
}

?>