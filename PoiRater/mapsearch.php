﻿<!DOCTYPE html>
<html>
	<head>
		<link rel="shortcut icon" type="image/x-icon" href="images/fav.ico" />
	<title>Αναζήτηση στον χάρτη</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" type="text/css" href="w3full.css"/>
	<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"></script>
	<script type="text/javascript" src="http://code.jquery.com/jquery-1.8.2.js"></script>
	<script type="text/javascript">
		setTimeout(function() {
    $('#b').fadeOut('fast');
			}, 3000);
			</script>
	</head>
	<body>
		
		<div class="blue">
		<?php include 'menu.php';?>
		</div>
		<div class="w3-header w3-large blue-d4">
			<a href="#sidemenu" class="w3-opennav w3-xlarge white w3-depth-3 w3-circle" style="color:#0D47A1;"><b>🔍</b></a>  
			<?php
			
			if (!isset($_SESSION['visited'])||$_SESSION['visited']==0) {
				$_SESSION['visited']=1;
			 	echo "<span id='b' class='bubble'>Πατήστε εδώ για φιλτράρισμα</span>";
			}
			?>
			
			Αναζήτηση POI στον χάρτη
		</div>
		<form id="sidemenu" class="w3-sidenav w3-right white w3-depth-2" style="height: 300px;" action="mapsearch.php" method="get">
  <a href="#" class="w3-closenav w3-large" >Close ×</a>
  	<table><tr><th>Κατηγορία</th><td></td></tr>
    	<tr class="red-l2"><td>Παραλία</td><td><input type="checkbox"  name="poicat1" id="poicat1" value=1></td></tr>
			<tr class="blue-l2"><td>Διαμονή</td><td><input type="checkbox" name="poicat2" id="poicat2" value=2></td></tr>
			<tr class="green-l2"><td>Φαγητό</td><td><input type="checkbox"  name="poicat3" id="poicat3" value=3></td></tr>
			<tr class="yellow-l2"><td>Διασκέδαση</td><td><input type="checkbox"  name="poicat4" id="poicat4" value=4></td></tr>
			<tr class="orange-l2"><td>Αξιοθέατα</td><td><input type="checkbox"  name="poicat5" id="poicat5" value=5></td></tr>
			</table>
		<input type=submit value="Search" class="w3-btn">
</form>
<script type="text/javascript">
	
	
	function initialize() {
	  var latLng = new google.maps.LatLng(37.984, 23.751);
	  var map = new google.maps.Map(document.getElementById('mapCanvas'), {
	    zoom: 7,
	    center: latLng,
	    mapTypeId: google.maps.MapTypeId.ROADMAP
	  });
	 <?php
	 		include 'dbconnect.php';
	 		mysqli_query ($con,' set character set utf8 ');
			$sql = "SELECT * FROM poi WHERE poi_lat!='' AND poi_category_id IN (";
				if (isset($_GET['poicat1'])){
				$sql .= "'".$_GET['poicat1']."',";}
				if (isset($_GET['poicat2'])){
				$sql .= "'".$_GET['poicat2']."',";}
				if (isset($_GET['poicat3'])){
				$sql .= "'".$_GET['poicat3']."',";}
			  if (isset($_GET['poicat4'])){
				$sql .= "'".$_GET['poicat4']."',";}
				if (isset($_GET['poicat5'])){
				$sql .= "'".$_GET['poicat5']."',";}	
				$sql .="'')";
			
		
			$result = mysqli_query($con, $sql);
			if (mysqli_num_rows($result) > 0) {
			    // output data of each row
					    while($row = mysqli_fetch_array($result)) {
					    echo "var latlng". $row["poi_id"]." = new google.maps.LatLng(". $row["poi_lat"].",". $row["poi_lng"].");";
					    echo "var content = '<h5>". $row["poi_name"]."</h5><p>". $row["poi_text"]."</p>';
					    			var marker = new google.maps.Marker({
									    position: latlng". $row["poi_id"].",
									    title: '". $row["poi_name"]."',
									    map: map,";
							if($row["poi_category_id"]==1){
								echo "icon:'http://maps.google.com/mapfiles/ms/icons/red-dot.png',
	  					});";
							}
							else if($row["poi_category_id"]==2){
								echo "icon:'http://maps.google.com/mapfiles/ms/icons/blue-dot.png',
	  					});";
							}
							else if($row["poi_category_id"]==3){
								echo "icon:'http://maps.google.com/mapfiles/ms/icons/green-dot.png',
	  					});";
						
							}
							else if($row["poi_category_id"]==4){
								echo "icon:'http://maps.google.com/mapfiles/ms/icons/yellow-dot.png',
	  					});";
							
							}
							else if($row["poi_category_id"]==5){
								echo "icon:'http://maps.google.com/mapfiles/ms/icons/orange-dot.png',
	  					});";
							
							}
							echo "var infowindow = new google.maps.InfoWindow()
							google.maps.event.addListener(marker,'click', (function(marker,content,infowindow){ 
        return function() {
           infowindow.setContent(content);
           infowindow.open(map,marker);
        };
    })(marker,content,infowindow)); ";
						}
					}
				else {
				    echo "0 results";
				}
				
				mysqli_close($con);
	?>
				
}
	
	// Onload handler to fire off the app.
	google.maps.event.addDomListener(window, 'load', initialize);

	</script>


<div id="mapCanvas" style="margin-top:30px;margin-left:200px;width: 800px;height: 600px;"></div>
<div class="w3-panel w3-left w3-depth-4" style="position:absolute;top:450px;left:40px;z-index:-1;" >
	<table><tr><th>Κατηγορία</th><td></td></tr>
		<tr class="red-l2"><td>Παραλία</td></td>
		<tr class="blue-l2"><td>Διαμονή</td></tr>
		<tr class="green-l2"><td>Φαγητό</td></tr>
		<tr class="yellow-l2"><td>Διασκέδαση</td></tr>
		<tr class="orange-l2"><td>Αξιοθέατα</td></tr>
		</table>
		</div>
	</body>
</html>