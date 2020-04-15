<?php
include 'dbconnect.php';

$ip=$_SERVER['REMOTE_ADDR'];
$lk=$_POST["sb"];
mysqli_query ($con,' set character set utf8 '); 
$get= "SELECT * FROM poi WHERE poi_id='$lk'";
$result = mysqli_query($con, $get);
$row = mysqli_fetch_row($result);

$plus=$row[8]+1;
$sql="UPDATE `poi` SET `poi_likes` = '$plus' WHERE `poi_id` = '$lk';";
mysqli_query($con, $sql);
$banip="INSERT INTO ip (banned_ip) VALUES ('$ip')";
mysqli_query($con,$banip);


header("location:searchpoi.php");
?>