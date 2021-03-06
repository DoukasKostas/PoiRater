﻿<!DOCTYPE html>
<html>
	<head>
		<link rel="shortcut icon" type="image/x-icon" href="images/fav.ico" />
	<title>Καταχώρηση POI</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" type="text/css" href="w3full.css"/>
	<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"></script>
	<script type="text/javascript">
		
	function check(){
		var cat = document.getElementById('filecat');
		if(cat.value==1||cat.value==2){
			document.getElementById("upfile").disabled = false;
			}
			else{
				document.getElementById("upfile").disabled = true;}
		}
		
		
	var geocoder = new google.maps.Geocoder();
	
	function geocodePosition(pos) {
	  geocoder.geocode({
	    latLng: pos
	  }, function(responses) {
	    if (responses && responses.length > 0) {
	      updateMarkerAddress(responses[0].formatted_address);
	    } else {
	      updateMarkerAddress('Cannot determine address at this location.');
	    }
	  });
	}
	
	function updateMarkerStatus(str) {
	  document.getElementById('markerStatus').innerHTML = str;
	}
	function updateMarkerPosition(latLng) {
  document.getElementById('info').innerHTML = [
    latLng.lat(),
    latLng.lng()
  ].join(', ');
}


	
	function updateMarkerAddress(str) {
	  document.getElementById('address').innerHTML = str;
	}
	
	function initialize() {
	  var latLng = new google.maps.LatLng(37.984, 23.751);
	  var map = new google.maps.Map(document.getElementById('mapCanvas'), {
	    zoom: 7,
	    center: latLng,
	    mapTypeId: google.maps.MapTypeId.ROADMAP
	  });
	  var marker = new google.maps.Marker({
	    position: latLng,
	    title: 'Point A',
	    map: map,
	    draggable: true
	  });
	  
	  // Update current position info.
	  updateMarkerPosition(latLng);
	  geocodePosition(latLng);
	  
	  // Add dragging event listeners.
	  google.maps.event.addListener(marker, 'dragstart', function() {
	    updateMarkerAddress('Dragging...');
	  });
	  
	  google.maps.event.addListener(marker, 'drag', function() {
	    updateMarkerStatus('Dragging...');
	    updateMarkerPosition(marker.getPosition());
	  });
	  
	  google.maps.event.addListener(marker, 'dragend', function() {
	    updateMarkerStatus('Drag ended');
	    geocodePosition(marker.getPosition());
	    document.getElementById('info1').value = this.getPosition().lat();
	    document.getElementById('info2').value = this.getPosition().lng();
	  });
	}
	
	// Onload handler to fire off the app.
	google.maps.event.addDomListener(window, 'load', initialize);
	</script>
	</head>
	<body>
		<div class="blue">
		<?php include 'menu.php';?>
		</div>
		<div class="w3-header w3-large blue-d4">
			Καταχώρηση Νέου POI
		</div>
		<div class="w3-panel w3-left">
			<div class="w3-header"><b>Συμπληρώστε αυτη τη φόρμα:</b>
				</div>
			<form class="w3-left w3-padding-left" name="addform" id="addform" action="submpoi.php" method="post" enctype="multipart/form-data">
				<table class="w3-table">
					<tr>
						<td>Όνομα:</td>
						<td><input required name="poiname" id="poiname" type="text"></td>
					</tr>
					<tr>
						<td>Περιγραφή:</td>
						<td><textarea name="poidesc" id="poidesc" rows=4></textarea></td>
					</tr>
					<tr>
						<td>Κατηγορία:</td>
						<td><select name="poicat" id="poicat">
							  <option value="1">Παραλία</option>
							  <option value="2">Διαμονή</option>
							  <option value="3">Φαγητό</option>
							  <option value="4">Διασκέδαση</option>
							  <option value="5">Αξιοθέατα</option>
							</select></td>
					</tr>
					<tr>
						<td>Είδος Αρχείου:</td>
						<td><select name="filecat" id="filecat" onchange="check();">
							  <option value="0">Δεν ανεβάζω</option>
							  <option value="1">Φωτογραφία</option>
							  <option value="2">Video</option> 
							</select></td>
					</tr>
					<tr>
						<td>Επιλέξτε Αρχείο:</td>
						<td><input  type="file" name="upfile" id="upfile" disabled ></td>
					</tr>
					
				</table>
				<div hidden><input id="info1" name="info1" class="w3-btn w3-center black" type="text"/>
				<input id="info2" name="info2" class="w3-btn w3-center teal" type="text" />
				</div>
				
				<input class="w3-btn blue-l1" type="submit" value="Καταχώρηση"/>
				<input class="w3-btn w3-center teal" type="reset" value="Καθαρισμός Πεδίων"/>
				
			  <div hidden id="infoPanel">
			    <b>Marker status:</b>
			    <div id="markerStatus"><i>Click and drag the marker.</i></div>
			    <b>Current position:</b>
			    <div id="info"></div>
			    <b>Closest matching address:</b>
			    <div id="address"></div>
			  </div>
			  <div hidden>
			  <input id="usr" name="usr" class="w3-btn w3-center teal" type="text" value="<?php echo htmlspecialchars($usname); ?>" />
			</div>
				
				
			</form>
			<div class="w3-right">
			<p><b>Σύρετε την πίνεζα για να δείξετε την τοποθεσία</b></p>
			<div id="mapCanvas"></div>
		</div>
	</body>
</html>