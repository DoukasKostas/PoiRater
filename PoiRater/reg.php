﻿<?php
include 'dbconnect.php';
	$usr=$_POST['usr'];
	$pas=$_POST['pas'];
	$name=$_POST['name'];
	$lname=$_POST['lastname'];
	$email=$_POST['email'];
	mysqli_query ($con,' set character set utf8 '); 
	mysqli_query($con,"INSERT INTO `users` (`username`, `pass`, `firstname`, `lastname`, `mail`) 
	VALUES ('$usr', '$pas', '$name', '$lname', '$email');");
	mysqli_close($con);
	echo 'You created an account <br>
<p><a href="home.php#id01">Click here</a> to return to our home page </p>';

?>