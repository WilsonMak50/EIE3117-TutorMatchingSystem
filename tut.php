<?php
    session_start();
   
    include_once 'mysql-connect.php';
    
    error_reporting(0);
    $msg = "";
    if(isset($_SESSION['SID'])){    
        $myUid=$_SESSION['SID'];
        $sql="SELECT * FROM tutor WHERE uid=? ;";
        $stmt=mysqli_stmt_init($connect);

        if(!mysqli_stmt_prepare($stmt,$sql)){
            
            header("Location: /EIE3117/login.php?error=sqlerror");
            exit();
        }else{
            mysqli_stmt_bind_param($stmt,"s",$myUid);
            mysqli_stmt_execute($stmt);
            $result =mysqli_stmt_get_result($stmt);
            if($row = mysqli_fetch_assoc($result)){
                $myDescrip=$row['intro']; 
                $mySubject=$row['subject'];                       
            }else{
                echo 'Cannot found record';
            }
        }

    }else{
        header("Location: /EIE3117/login.php?error=logout");
        exit();
    }
    
    // If upload button is clicked ...
    if (isset($_POST['upload'])) {
    
        $filename = $_FILES["uploadfile"]["name"];
        $tempname = $_FILES["uploadfile"]["tmp_name"];
        $folder = "./upimage/" . $filename;

        $sql="UPDATE tutor SET img=? WHERE uid=? ; ";
        $stmt=mysqli_stmt_init($connect);
        if(!mysqli_stmt_prepare($stmt,$sql)){          
            echo'error cannot prepare the sql stmt';
            exit();
        }else{

            echo $filename;
            mysqli_stmt_bind_param($stmt,"ss",$filename,$myUid);
            mysqli_stmt_execute($stmt);

        }

        if (move_uploaded_file($tempname, $folder)) {
            echo "<h3> Image uploaded successfully!</h3>";
        } else {
            echo "<h3> Failed to upload image!</h3>";
        }
    }

    if(isset($_POST['up-profile'])){
        $myIntro=$_POST['des'];
        $checkbox1=$_POST['sub'];  
        $chk="";  

        // for 
        foreach($checkbox1 as $chk1)  
        {  
            $chk .= $chk1.",";  
        } 
        $sql="UPDATE tutor SET intro=? , subject=? WHERE uid=? ; ";
        $stmt=mysqli_stmt_init($connect);
        if(!mysqli_stmt_prepare($stmt,$sql)){          
            echo'error cannot prepare the sql stmt';
            exit();
        }else{

            echo $filename;
            mysqli_stmt_bind_param($stmt,"sss",$myIntro,$chk,$myUid);
            mysqli_stmt_execute($stmt);
            header("Location: /EIE3117/tutview.php");

        }


    }else{
        //echo'You have not make any changes !';
    }  
    
?>

<div class="modal fade" id="logoutModal">
    <div class="modal-dialog">
        <div class="modal-content"> 
            <div class="modal-header">
                <h5 class="modal-title">Log Out</h5> 
            </div>
            <div class="modal-body">
                IF you would like to log out, please click the OK below.
            </div>
            <div class="modal-footer">
            <button type="button" class="btn btn-primary" data-bs-dismiss = "modal">Cancel</button>
            <button type="button" onclick="location.href='./logout.php';" class="btn btn-primary" data-dismiss = "modal">OK</button>
            </div>
        </div>
    </div>
</div>

<html>
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Tutor Cow-Log In</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
        <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
        <link rel="preconnect" href="https://fonts.googleapis.com"><link rel="preconnect" href="https://fonts.gstatic.com" crossorigin><link href="https://fonts.googleapis.com/css2?family=Sofia+Sans+Extra+Condensed:wght@300;500&display=swap" rel="stylesheet">
        <style> @import url('https://fonts.googleapis.com/css2?family=Sofia+Sans+Extra+Condensed:wght@300;500&display=swap'); </style>
        <link rel="stylesheet" href="style1.css">
    </head>
<body>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
    <section id="nav">
        <!-- Nav Bar-->
            <nav class="navbar navbar-expand-lg bg-body-tertiary">
                <div class="container-fluid">
                <a class="navbar-brand" href="#">
                    <img src="/EIE3117/img/Tutorcowicon.png" width="200" height="200">
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="/EIE3117/index.html">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="tut.php">Profile</a>             
                    </li>
                    <li class="nav-item2">
                        <a class="nav-link" href="tutview.php">Post</a>
                    </li>
                    <li class="nav-item3">
                            <a class="nav-link" href="mail.php">Private Mail</a>
                        </li>
                    <li class="nav-item4">
                        <a class="nav-link" id="logoutbtn" >Log out</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link disabled"></a>
                    </li>
                    </ul>
                </div>
                </div>
            </nav>
    </section>

    
    <script>
        $("#logoutbtn").on("click",function(e){
        e.preventDefault();
        $('#logoutModal').modal('show');
        })
    </script>



    <section id="profile">
        <div class="container">
            <div class="login-left">
                <div class="login-header">
                    <h1>Edit Profile</h1>
                    <?php 

                        if(isset($_SESSION['SID'])){   
                            
                            echo '<p><i><b>'.$_SESSION['SName'].',  </i></b>';
                        }else{
                            echo "You are logged out !";
                        }
                    ?> 
                     Please tell us more details !</p>
                    <h3>Profile Picture</h3> 
                </div>



                
                <div id="display-image">
                <?php
                   $sql="SELECT img FROM tutor WHERE uid=? ; ";
                   $stmt=mysqli_stmt_init($connect);
                   if(!mysqli_stmt_prepare($stmt,$sql)){          
                       echo'error cannot prepare the sql stmt';
                       exit();
                   }else{
                        mysqli_stmt_bind_param($stmt,"s",$myUid);
                        mysqli_stmt_execute($stmt);
                        $result =mysqli_stmt_get_result($stmt);
                        if($row = mysqli_fetch_assoc($result)){
                            $myImg=$row['img'];              
                        }else{
                            echo 'Cannot found record';
                        }
                   };
                ?>

                <img src="./upimage/<?php echo $myImg; ?>"
                class="rounded-circle"
                style="width: 220px">

                </div>

                <form method="POST" action="" enctype="multipart/form-data">
			    <div class="form-group">
				<input class="form-control" type="file" name="uploadfile" value="" />
			    </div>
			    <div class="form-group">
				<button class="btn-primary" type="submit" name="upload">UPLOAD</button>
			    </div>
		        </form>

                <form class="login-form" action = "" method = "post" id="formid" enctype="multipart/form-data">
                    <div class="login-form-content">



                        <fieldset>
                            <legend>Select your subject (s) you would like to teach:</legend>

                            <div>

                                <!-- <label>&nbsp&nbsp&nbsp</label> -->
                                <label  style="word-wrap:break-word">
                                <input type="checkbox" id="subject1" name="sub[]" value="chin" <?php if((strpos($mySubject,'chin')!== false) )echo "checked='checked'"?>/>
                                Chinese &nbsp&nbsp&nbsp&nbsp&nbsp</label>

                                <label  style="word-wrap:break-word">
                                <input type="checkbox" id="subject2" name="sub[]" value="eng" <?php if((strpos($mySubject,'eng')!== false) )echo "checked='checked'"?>/>
                                English &nbsp&nbsp&nbsp&nbsp&nbsp</label>


                                <label  style="word-wrap:break-word">
                                <input type="checkbox" id="subject3" name="sub[]" value="math" <?php if((strpos($mySubject,'math')!== false) )echo "checked='checked'"?>/>
                                Maths &nbsp&nbsp&nbsp&nbsp&nbsp</label>

                                <label  style="word-wrap:break-word">
                                <input type="checkbox" id="subject4" name="sub[]" value="ls" <?php if((strpos($mySubject,'ls')!== false) )echo "checked='checked'"?>>
                                Liberal Studies &nbsp&nbsp&nbsp&nbsp&nbsp</label>

                            </div>
                          
                 
                            <div>

                              
                                <label style="word-wrap:break-word">
                                <input type="checkbox" id="subject5" name="sub[]" value="phy"  <?php if((strpos($mySubject,'phy')!== false) )echo "checked='checked'"?>/>
                                Physics &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp</label>

                                <label style="word-wrap:break-word">
                                <input type="checkbox" id="subject6" name="sub[]" value="bio" <?php if((strpos($mySubject,'bio')!== false) )echo "checked='checked'"?>/>
                                Biology &nbsp&nbsp&nbsp&nbsp&nbsp</label>

                                <label style="word-wrap:break-word">
                                <input type="checkbox" id="subject7" name="sub[]" value="ict" <?php if((strpos($mySubject,'ict')!== false) )echo "checked='checked'"?>>
                                ICT &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp</label>

                                <label style="word-wrap:break-word">
                                <input type="checkbox" id="subject8" name="sub[]" value="econ" <?php if((strpos($mySubject,'econ')!== false) )echo "checked='checked'"?>/>
                                Economics &nbsp&nbsp&nbsp&nbsp&nbsp</label>

                            </div>
                    
                        </fieldset> 

                        <label for="name">Description:</label><br>
                        <input type="text" id="des" name="des" value="<?=$myDescrip;?>" style="height:220px; width:600px; border-radius:20px; ">
                        
                        <div class="buttons">
                            <button type="submit" name="up-profile">Done</button>
                            <a class="btn" href="index.html" role="button">Back</a>

                        </div>
                        
                    </div>
                </form>
            </div>
           
        </div>
    </section>



    
</body>
</html>