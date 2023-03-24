<?php 
    session_start();
    if(!isset($_SESSION['SID'])){
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
        <link rel="stylesheet" href="aos-by-red.css">
        <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />
        <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>


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

        <section id="info">
        <section id="info">
            <div class='container'>
                <div class='row'>
                    <div class='col-md-12 text-center' >
                        <h3>Latest Cases</h3>
                    </div>
                </div> 
                <?php
                    
                    require"mysql-connect.php";
                    $sql = "SELECT caseID FROM tutor";
      
                    // Execute the query and store the result set
                    $result = mysqli_query($connect, $sql);
                      
                    if ($result)
                    {
                        // it return number of rows in the table.
                        $loop = mysqli_num_rows($result);
  
                    }
                  
                    echo"<div class='row'>";
                    $counter=1;
                    for ($i=1;$i<=$loop;$i++)
                    {    
                        $sql="SELECT * FROM tutor WHERE caseID=? ;";
                        $stmt=mysqli_stmt_init($connect);
                
                        if(!mysqli_stmt_prepare($stmt,$sql)){
                            
                            header("Location: /EIE3117/tutview.php?error=sqlerror");
                            exit();
                        }else{
                            mysqli_stmt_bind_param($stmt,"i",$i);
                            mysqli_stmt_execute($stmt);
                            $result =mysqli_stmt_get_result($stmt);
                            if($row = mysqli_fetch_assoc($result)){
                                $myID=$row['uid'];
                                $myName=$row['name'];
                                $myDescrip=$row['intro']; 
                                $mySubject=$row['subject']; 
                                $myImg=$row['img'];          
                            }else{
                                echo 'Cannot found record';
                            }
                        }
                        echo"<div class='col-md-4'>";
                        echo" <div class='outer'>";
                        echo"<div class='upper'>";
                        echo"<img src='./upimage/".$myImg."'>";
                        echo"<div class='innertext'>";
                        echo"<h4>".$myName."</h4>";
                        echo"</div>";
                        echo"</div>";   
                        echo"<div class='lower'>";
                        echo"<h2>".$mySubject." Tutor</h2>";
                        //echo"<span>JAN 13, 2023 08:00PM</span>";
                        echo"<input type='hidden' name='nid".$i."' id='nid".$i."' value=".$myID.">";
                        
                        echo"<input type='hidden' name='marks".$i."' id='marks".$i."' value=\"$myDescrip\">";
                        echo"<button type='button' id=".$i."  data-toggle='modal' data-target='#detailsModal'>
                        More Details</button>";

                        echo"</div>";
                        echo"</div>";
                        echo"</div>";

                        if(($i % 3 ==0))
                        {   
                            echo"</div>";}
                        if($i % 3 ==0)
                        {  echo"<div class='row'>";}
                    }

                ?>

                <script type="text/javascript">
                    var buttons = document.getElementsByTagName("button");
                    for (let index = 0; index < buttons.length; index++) {
                        buttons[index].onclick = function () {
                        var nameid= $("#nid"+this.id).val();
                        var marks = $("#marks"+this.id).val();
                        var str ="Name "+ nameid 
                        var str1="Introduction: " + marks;
                        $("#modal_name").html(str);
                        $("#modal_des").html(str1);
                        
                        }
                    }
                </script>

        </section>

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

        <div class="modal fade" id="detailsModal"
			tabindex="-1"
			aria-labelledby="exampleModalLabel"
			aria-hidden="true">
			
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title"
							id="detailsModalLabel">
							About the tutor: 
						</h5>
						
						<button type="button"
							class="close"
							data-dismiss="modal"
							aria-label="Close">
							<span aria-hidden="true">
								×
							</span>
						</button>
					</div>

					<div class="modal-body">


						<h6 id="modal_name"></h6>
                        <br>
                        <h6 id="modal_des"></h6>
						<button type="button"
							class="btn btn-success btn-sm"
							data-toggle="modal"
                            data-dismiss="modal"
							>
							OK
						</button>
					</div>
				</div>
			</div>
        </div>


    </body>
    
</html>