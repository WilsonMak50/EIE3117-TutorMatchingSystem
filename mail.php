<?php
    session_start();
    if(!isset($_SESSION['csrf_token'])){
        header("Location: /EIE3117/login.php?error=logout");
        exit();
    }
?>
<html> 
    <head>
        <title>Tutor Cow - Awesome Tutor Matching Platform in PolyU</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
        <link rel="preconnect" href="https://fonts.googleapis.com"><link rel="preconnect" href="https://fonts.gstatic.com" crossorigin><link href="https://fonts.googleapis.com/css2?family=Sofia+Sans+Extra+Condensed:wght@300;500&display=swap" rel="stylesheet">
        <style> @import url('https://fonts.googleapis.com/css2?family=Sofia+Sans+Extra+Condensed:wght@300;500&display=swap'); </style>
        <link rel="stylesheet" href="style.css">
        <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
        

    </head>
    <body>



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
                            <a class="nav-link active" aria-current="page" href="/EIE3117/index.php">Home</a>
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
                    <button type="button" class="btn btn-primary" data-dismiss = "modal">Cancel</button>
                    <button type="button" onclick="location.href='./logout.php';" class="btn btn-primary" data-dismiss = "modal">OK</button>
                    </div>
                </div>
            </div>
        </div>  


        
    <section id="content">
            <div class="container">
                <div class='col-md-12 text-center' >
                            <h3>Student Requests</h3>
                </div>

                <?php
                    
                    if(isset($_COOKIE['UserID'])){    
                        $myUid=$_COOKIE['UserID'];

                        require "mysql-connect.php";
                        $sql = "SELECT * FROM request WHERE TID=? ;";
                        $stmt=mysqli_stmt_init($connect);
                        if(!mysqli_stmt_prepare($stmt,$sql)){
                            header("Location: /EIE3117/mail.php?error=sqlerror");
                            exit();
                        }else{
                            mysqli_stmt_bind_param($stmt,"s",$myUid);
                            mysqli_stmt_execute($stmt);
                            $result =mysqli_stmt_get_result($stmt);
                            while($row = mysqli_fetch_assoc($result)){
                                $ReqID=$row['RID'];
                                $StdID=$row['SID'];
                                $StdIn=$row['INTRO'];
                                $StdCon=$row['CONTACT'];
                                $ReqTime=$row['TIME'];
                                echo"<div class='div' data-aos='fade-up' data-aos-duration='1000' > ";
                                echo"<div class='row'>";
                                echo"<h3>Student ID: ".$StdID."</h3>";
                                echo"<h3>Student general info: ".$StdIn."</h3>";
                                echo"<h3> Student contacts: ".$StdCon."</h3>";
                                echo"<h3> Send Date : ".$ReqTime. "</h3>";
                                echo"</div>";
                                echo"</div>";
                
                            }
                        }

                    }
                ?>
          

    </section>
    </body>
</html>