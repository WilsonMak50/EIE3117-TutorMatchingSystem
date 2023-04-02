<?php
if(isset($_POST["profile-submit"]))
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
   
    // $myNickName=$_POST['nickname'];
    // $myEmail=$_POST['email'];
    // $myPassword=$_POST['password'];
    // $myRePassword=$_POST['rpassword'];
    // $myGender=$_POST['gender'];
    // $myBirthday=$_POST['birthday'];
    // $myServiceType=$_POST['servicetype'];



    $sql = "SELECT uid FROM users WHERE uid=?";
    $stmt = mysqli_stmt_init($connect);
    if(!mysqli_stmt_prepare($stmt,$sql))
    {   
        if($myServiceType=="tut"){
            header("Location: /tutreg.php?error=invaliduid&nickname=".$myNickName."&email=".$myEmail."");
            exit();
        }
        if($myServiceType=="std"){
            header("Location: /tdreg.php?error=invaliduid&nickname=".$myNickName."&email=".$myEmail."");
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
            header("Location: /tutreg.php?error=emptyfields&username=".$myUserName."&nickname=".$myNickName."&email=".$myEmail."");
            exit();
        }

        if($myServiceType=="std"){
            header("Location: /stdreg.php?error=emptyfields&username=".$myUserName."&nickname=".$myNickName."&email=".$myEmail."");
            exit();
        }



    }else if(!filter_var($myEmail,FILTER_VALIDATE_EMAIL)&&(!preg_match("/^[a-zA-Z]*$/",$myNickName))){

        if($myServiceType=="tut"){
            header("Location: /tutreg.php?error=invalidmailnn&username=".$myUserName."");
            exit(); 
        }
        if($myServiceType=="std"){
            header("Location: /stdreg.php?error=invalidmailnn&username=".$myUserName."");
            exit(); 
        }

    }else if (!filter_var($myEmail,FILTER_VALIDATE_EMAIL)){
        if($myServiceType=="tut"){
            header("Location: /tutreg.php?error=invalidmail&username=".$myUserName."&nickname=".$myNickName."");
            exit();
        }
        if($myServiceType=="std"){
            header("Location: /stdreg.php?error=invalidmail&username=".$myUserName."&nickname=".$myNickName."");
            exit();
        }

    }else if (!preg_match("/^[a-zA-Z]*$/",$myUserName)){
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
            header("Location: /tutreg.php?error=invlidpwd&username=".$myUserName."&nickname=".$myNickName."&email=".$myEmail."");
            exit();
        }
        if($myServiceType=="std"){
            header("Location: /stdreg.php?error=invlidpwd&username=".$myUserName."&nickname=".$myNickName."&email=".$myEmail."");
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
            header("Location:/login.php?signup=success");
            exit();
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