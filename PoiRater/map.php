<!DOCTYPE html>
<html>
	<head>
		<link rel="shortcut icon" type="image/x-icon" href="images/favicon.ico" />
	<title>Αναζήτηση στον χάρτη</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" type="text/css" href="w3full.css"/>
	<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"></script>
	</head>
	<body>
		<script type="text/javascript">
	
	
	function initialize() {
	  var latLng = new google.maps.LatLng(<?php echo $_POST['lat'].",".$_POST['lng'];?>);
	  var map = new google.maps.Map(document.getElementById('mapCanvas'), {
	    zoom: 10,
	    center: latLng,
	    mapTypeId: google.maps.MapTypeId.ROADMAP
	  });
	  <?php
	  include 'dbconnect.php';
	 		mysqli_query ($con,' set character set utf8 ');
			$sql = "SELECT * FROM poi WHERE poi_lat=".$_POST['lat']." AND poi_lng=".$_POST['lng']."";
			$result = mysqli_query($con, $sql);
			$row = mysqli_fetch_array($result);
		
			 	echo "var latlng". $row["poi_id"]." = new google.maps.LatLng(". $row["poi_lat"].",". $row["poi_lng"].");";
			  echo "var marker = new google.maps.Marker({
							    position: latlng". $row["poi_id"].",
							    title: '". $row["poi_name"]."',
							    map: map,
							    });}";
							    
			
		?>
			google.maps.event.addDomListener(window, 'load', initialize);
		</script>
		<div class="w3-header teal"> 
        <a href="searchpoi.php" class="w3-closebtn w3-left">&times;</a>
		<div class="w3-depth-2" id="mapCanvas" style="position:absolute;margin-top:50px;width: 98%;height: 90%;"></div>
	</body>
</html>