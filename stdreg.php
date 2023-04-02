<?php 
session_start();
$sertype = "std";
$token =bin2hex(random_bytes(32));


?>
<html>
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Tutor Cow-Student Registration</title>
        <link rel="stylesheet" href="style.css">
    </head>
<body>
    <section id="loginpage">
        <div class="container">
            <div class="login-left">
                <div class="login-header">
                    <h1>Welcome to Tutor Cow</h1>
                    <h2>Sign In For Student</h2>
                    <p>Please register your account to use the platform</p>
                </div>
                <?php
                    $secmsg=urldecode($_GET['error']);
                    if(isset($secmsg)){
                        if(urldecode($_GET['error'])=="emptyfields"){
                            echo'<p class="signuperror"> Fill in all fields !</p>';
                        }else if(urldecode($_GET['error'])=="uidtaken"){
                            echo'<p class="signuperror"> Username has been taken ! </p>';
                        }else if(urldecode($_GET['error'])=="invalidmailnn"){
                            echo'<p class="signuperror"> Invalid Nickname ! </p>';
                        }else if(urldecode($_GET['error'])=="invalidmail"){
                            echo'<p class="signuperror"> Invalid Email ! </p>';
                        }else if(urldecode($_GET['error'])=="invliduid"){
                            echo'<p class="signuperror"> Invalid Username ! </p>';
                        }else if(urldecode($_GET['error'])=="invlidpwd"){
                            echo'<p class="signuperror"> Invalid Password ! </p>';
                        }

                    } 
                ?>
                <form class="login-form" action = "create_acc.php" method = "post" id="formid" enctype="multipart/form-data">
                    <div class="login-form-content">
                        <div class="form-item">
                            <label for="username">Enter Username / User ID</label>
                            <input type="text" name="username" id="username" placeholder="username">
                        </div>
                        <div class="form-item">
                            <label for="username">Enter your nick name</label>
                            <input type="text" name="nickname" id="nickname" placeholder="nickname">
                        </div>
                        <div class="form-item">
                            <label for="username">Enter your email address</label>
                            <input type="email" name="email" id="email" placeholder="email">
                        </div>
                        <div class="form-item">
                            <label for="password">Enter your Password</label>
                            <input type="password" name="password" id="password" placeholder="password">
                        </div>
                        <div class="form-item">
                            <label for="password">Repeat your Password</label>
                            <input type="password" name="rpassword" id="rpassword" placeholder="repeat your password">
                        </div>

                        <div class="form-item">
                            <label for="date">Choose your birthday</label>
                            <input type= "date" id = "birthday" name = "birthday" placeholder="birthday">  
                        </div>

                        <input type="hidden" name="servicetype" value=<?php echo $sertype; ?>> 
                        <input type="hidden" name="csrf_token" value="<?php echo $token; ?>">
                        <fieldset>
                            <legend>Select your gender:</legend>

                            <div>
                                <input type="radio" id="male" name="gender" value="male" placeholder="gender"
                                       checked>
                                <label for="male">Male</label>
                            </div>
                          
                 
                            <div>
                                <input type="radio" id="female" name="gender" value="female" placeholder="gender">
                                <label for="female">Female</label>
                            </div>
                    
                        </fieldset> 


                        <button type="submit" name="signup-submit" >Sign Up</button>

                    


                        <a class="btn" href="index.php" role="button">Back</a>
                    </div>
                    <div class="login-form-footer">
                        

                    </div>
                </form>
            </div>
            <div class="login-right">
                <img src="./img/stdreg.svg">
            </div>
        </div>
    </section>
    
</body>
</html>