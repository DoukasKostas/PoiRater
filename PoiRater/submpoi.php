﻿<?php
include 'dbconnect.php';
ini_set("upload_max_filesize", "3200000000");
	$poiname=$_POST['poiname'];
	$poidesc=$_POST['poidesc'];
	$poicat=(int)$_POST['poicat'];
	$filecat=(int)$_POST['filecat'];
	$infolat=$_POST['info1'];
	$infolgn=$_POST['info2'];
	$usrn=$_POST['usr'];
	
	$destination = "uploads/";
	if($filecat!='0'){
	$destination .= $_FILES["upfile"]["name"];
	$filename = $_FILES["upfile"]["tmp_name"];
	move_uploaded_file($filename, $destination);
	}
	mysqli_query ($con,' set character set utf8 '); 
	if($filecat=='1'){
		$sql="INSERT INTO poi (poi_id, poi_name, poi_text, poi_category_id, poi_photo, poi_video, poi_lat, poi_lng, poi_likes, username)
		 VALUES (NULL, '$poiname', '$poidesc', '$poicat', '$destination', NULL, '$infolat', '$infolgn', 0, '$usrn')";
		}
		else if($filecat=='2'){
			$sql="INSERT INTO poi (poi_id, poi_name, poi_text, poi_category_id, poi_photo, poi_video, poi_lat, poi_lng, poi_likes, username)
		 VALUES (NULL, '$poiname', '$poidesc', '$poicat', NULL, '$destination', '$infolat', '$infolgn', 0, '$usrn')";
			
			}
			else{
				$sql="INSERT INTO poi (poi_id, poi_name, poi_text, poi_category_id, poi_photo, poi_video, poi_lat, poi_lng, poi_likes, username)
		 VALUES (NULL, '$poiname', '$poidesc', '$poicat', NULL, NULL, '$infolat', '$infolgn', 0, '$usrn')";
				}
	if (!mysqli_query($con,$sql)){
            die('Error: ' . mysqli_error($con));
   }
  echo "You created a new POI";
  mysqli_close($con);
  echo "<br><p><a href=home.php>Click here</a> to return to our home page </p>";
	
?>