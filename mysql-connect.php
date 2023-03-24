<?php
	$server = "localhost";
	$user = "projroot";
	$pw = "Mak22011393d";
    $db = "tutcow";
    
    $connect = mysqli_connect($server, $user, $pw, $db);
	if(!$connect) 
    {
        die("Connection failed: " . mysqli_connect_error());
    }
?>