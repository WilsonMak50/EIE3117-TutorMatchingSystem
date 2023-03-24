<?php
if(isset($_POST["signup-submit"]))
{
    require 'mysql-connect.php';
    $validation=0;
    $myUserName=$_POST['username'];
    $myNickName=$_POST['nickname'];
    $myEmail=$_POST['email'];
    $myPassword=$_POST['password'];
    $myRePassword=$_POST['rpassword'];
    $myGender=$_POST['gender'];
    $myBirthday=$_POST['birthday'];
    $myServiceType=$_POST['servicetype'];
    echo '<script>alert('.$myUserName.')</script>';


    $sql = "SELECT uid FROM users WHERE uid=?";
    $stmt = mysqli_stmt_init($connect);
    if(!mysqli_stmt_prepare($stmt,$sql))
    {   
        if($myServiceType=="tut"){
            header("Location: /EIE3117/tutreg.php?error=sqlerror");
            exit();
        }
        if($myServiceType=="std"){
            header("Location: /EIE3117/stdreg.php?error=sqlerror");
            exit();
        }


        
    }else{
        mysqli_stmt_bind_param($stmt,"s",$myUserName);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_store_result($stmt);
        $resultCheck = mysqli_stmt_num_rows($stmt);
        if($resultCheck>0){

            if($myServiceType=="tut"){
                header("Location: /EIE3117/tutreg.php?error=uidtaken&nickname=".$myNickName."&email=".$myEmail."");
                exit();
            }
            if($myServiceType=="std"){
                header("Location: /EIE3117/stdreg.php?error=uidtaken&nickname=".$myNickName."&email=".$myEmail."");
                exit();
            }
            
        }else{
            $validation=1;
        }  
    }
        
    if(empty($myUserName)|| empty($myNickName)||empty($myEmail)||empty($myPassword)||empty($myRePassword)||empty($myGender)||empty($myBirthday)||empty($myServiceType)){

        if($myServiceType=="tut"){
            header("Location: /EIE3117/tutreg.php?error=emptyfields&username=".$myUserName."&nickname=".$myNickName."&email=".$myEmail."");
            exit();
        }

        if($myServiceType=="std"){
            header("Location: /EIE3117/stdreg.php?error=emptyfields&username=".$myUserName."&nickname=".$myNickName."&email=".$myEmail."");
            exit();
        }



    }else if(!filter_var($myEmail,FILTER_VALIDATE_EMAIL)&&(!preg_match("/^[a-zA-Z]*$/",$myNickName))){

        if($myServiceType=="tut"){
            header("Location: /EIE3117/tutreg.php?error=invalidmailnn&username=".$myUserName."");
            exit(); 
        }
        if($myServiceType=="std"){
            header("Location: /EIE3117/stdreg.php?error=invalidmailnn&username=".$myUserName."");
            exit(); 
        }

    }else if (!filter_var($myEmail,FILTER_VALIDATE_EMAIL)){
        if($myServiceType=="tut"){
            header("Location: /EIE3117/tutreg.php?error=invalidmail&username=".$myUserName."&nickname=".$myNickName."");
            exit();
        }
        if($myServiceType=="std"){
            header("Location: /EIE3117/stdreg.php?error=invalidmail&username=".$myUserName."&nickname=".$myNickName."");
            exit();
        }

    }else if (!preg_match("/^[0-9a-zA-Z]*$/",$myUserName)){
        if($myServiceType=="tut"){
            header("Location: /EIE3117/tutreg.php?error=invliduid&nickname=".$myNickName."&email=".$myEmail."");
            exit();
        }
        if($myServiceType=="std"){
            header("Location: /EIE3117/stdreg.php?error=invliduid&nickname=".$myNickName."&email=".$myEmail."");
            exit();
        }

    }else if ($myPassword!==$myRePassword){
        if($myServiceType=="tut"){
            header("Location: /EIE3117/tutreg.php?error=invlidpwd&username=".$myUserName."&nickname=".$myNickName."&email=".$myEmail."");
            exit();
        }
        if($myServiceType=="std"){
            header("Location: /EIE3117/stdreg.php?error=invlidpwd&username=".$myUserName."&nickname=".$myNickName."&email=".$myEmail."");
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
            header("Location: /EIE3117/tutreg.php?error=sqlerror");
            exit();
            }
            if($myServiceType=="std"){
                header("Location: /EIE3117/stdreg.php?error=sqlerror");
                exit();
            }

        }else{    
            $hashedPwd = password_hash($myPassword, PASSWORD_DEFAULT);
            mysqli_stmt_bind_param($stmt,"sssssss",$myUserName,$myNickName,$myEmail,$hashedPwd,$myBirthday,$myGender,$myServiceType);
            mysqli_stmt_execute($stmt);
            if($myServiceType=="tut"){
                $myImg='profiletut.jpg';
                $sql="INSERT INTO tutor (uid, img,name) VALUES (?,?,?)";
                $stmt=mysqli_stmt_init($connect);
                mysqli_stmt_prepare($stmt,$sql);
                mysqli_stmt_bind_param($stmt,"sss",$myUserName,$myImg,$myNickName);
                mysqli_stmt_execute($stmt);
             }else if($myServiceType=="std"){
                $myImg='profilestd.svg';
                $sql="INSERT INTO student (uid, name,img) VALUES (?,?,?)";
                $stmt=mysqli_stmt_init($connect);
                mysqli_stmt_prepare($stmt,$sql);
                mysqli_stmt_bind_param($stmt,"sss",$myUserName,$myNickName,$myImg);
                mysqli_stmt_execute($stmt);
             }
            
            header("Location:/EIE3117/login.php?signup=success");
            exit();
        }
        
    }

    mysqli_stmt_close($stmt);
    mysqli_close($connect);
}else{

    if($myServiceType=="tut"){
    header("Location:/EIE3117/tutreg.php");
    }else{
        header("Location:/EIE3117/stdreg.php");
    }
}

?>