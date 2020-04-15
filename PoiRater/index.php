<?php
session_start();
 
if (isset($_POST["usr"])) {
        
	include_once("dbConnect.php");
	
	
	$usname=$_POST["usr"];
	$paswd=$_POST["pass"];
	
	$sql = "SELECT  username, pass FROM users WHERE username = '$usname' LIMIT 1";
	$query = mysqli_query($con, $sql);
	$row = mysqli_fetch_row($query);
	$dbUsname = $row[0];
	$dbPassword = $row[1];
	
	// Check if the username and the password they entered was correct
	if ($usname == $dbUsname && $paswd == $dbPassword) {
		// Set session 
		session_unset();
		$_SESSION['username'] = $usname;
		mysqli_close($con);
		// Now direct to users feed
		header("Location: home.php");
	} else {
		echo "<h3>Oops that username or password combination was incorrect.
		<br /> Please try again.</h3>";
	}
	
}
?>
<!DOCTYPE html>
<html>
	<head>
		<link rel="shortcut icon" type="image/x-icon" href="images/fav.ico" />
	<title>Welcome</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" type="text/css" href="w3full.css"/>
	</head>
	<body class="blue">
		<div class="w3-header w3-center" style="position: absolute;top: 35%;left: 30%;right: 30%;;">
			<h1>WELCOME TO POIRATER</h1>
			<form name="formlog" id="formlog" action="index.php" method="post">
			<p>Username<br><input required class="white" name="usr" id="usr" type="text"></p>
			<p>Password<br><input required class="white" name="pass" id="pass" type="password"></p>
			<button type="submit" id="logbtn" name="logbtn" class="w3-btn w3-center teal">login</button>
			<a class="w3-btn w3-center blue-d3" href="home.php">Guest</a>
			</form>	
		</div>
		</body>
	</html>
	