<!DOCTYPE html>
<html>
	<head>
		<link rel="shortcut icon" type="image/x-icon" href="images/fav.ico" />
	<title>Αναζήτηση POI</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" type="text/css" href="w3full.css"/>
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
			
			if (!isset($_SESSION['visited2'])||$_SESSION['visited2']==0) {
				$_SESSION['visited2']=1;
			 	echo "<span id='b' class='bubble'>Πατήστε εδώ για φιλτράρισμα</span>";
			}
			?>
			Αναζήτηση POI
		</div>
		<form id="sidemenu" class="w3-sidenav white w3-depth-2" action="searchpoi.php" method="get">
  <a href="#" class="w3-closenav w3-large">Close ×</a>
    <table><tr><td>Κατηγορία</td>
    <td><select name="poicat" id="poicat">
    						<option value="0">Όλα</option>
							  <option value="1">Παραλία</option>
							  <option value="2">Διαμονή</option>
							  <option value="3">Φαγητό</option>
							  <option value="4">Διασκέδαση</option>
							  <option value="5">Αξιοθέατα</option>
		</select></td></tr>
		<tr><td>Περιεχόμενο</td>
			<td><select name="poivid" id="poivid">
								<option value="0">Όλα</option>
							  <option value="1">Όσα εχουν Photo</option>
							  <option value="2">Όσα  εχουν Video</option>
						
					</select>
			</td>
		</tr>
		</table>
		<input type=submit value="Search" class="w3-btn">
</form>

		<table class="w3-table w3-bordered w3-hoverable">
			<thead>
			<tr>
			  <th>POI</th>
			  <th>Κατηγορία</th>
			  <th>Περιγραφή</th>
			  <th>Photo/Video</th>
			  <th>Χάρτης</th>
			  <th># Likes</th>
			  <th>Χρήστης</th>
			</tr>
			</thead>
			<tbody>
				<?php
				include 'dbconnect.php';
				mysqli_query ($con,' set character set utf8 ');
				$sql = "SELECT * FROM poi";
				if(isset($_GET['poicat'])&& $_GET['poicat']!=0){
					
						$sql .= " WHERE poi_category_id=".$_GET['poicat']."";
						if ($_GET['poivid']==1) {
						 	$sql .= " AND poi_photo!='NULL'";
						}
						else if ($_GET['poivid']==2) {
						 	$sql .= " AND poi_video!='NULL'";
						}
				}
				else{
				if (isset($_GET['poivid']) && $_GET['poivid']==1) {
					 	$sql .= " WHERE poi_photo!='NULL'";
				}
				else if (isset($_GET['poivid']) && $_GET['poivid']==2) {
				 	$sql .= " WHERE poi_video!='NULL'";
				}
				}
				
			  
				$result = mysqli_query($con, $sql);
				
				if (mysqli_num_rows($result) > 0) {
    // output data of each row
		    while($row = mysqli_fetch_array($result)) {
		    	$s1="SELECT * FROM poi_cat WHERE poi_category_id='$row[3]'";
				$result2= mysqli_query($con,$s1);
				
		    				$row2=mysqli_fetch_array($result2);
		    				echo "<tr><td>" . $row["poi_name"]. 
				        "<td>" . $row2["poi_category"]. 
				        "<td>" . $row["poi_text"];
				        
		    				if($row["poi_photo"]!=NULL){
				        echo  "<td><a href='searchpoi.php#full".$row[0]."'><img src=".$row["poi_photo"]." alt='HTML5 Icon' style='width:80px;height:80px'>".
				        "<div id='full".$row[0]."' class='w3-modal'>
							  <div class='w3-modal-dialog'>
							    <div class='w3-modal-content w3-depth-3' style='max-width:100%;height:50%;'>
							      <div class='w3-header teal'> 
							        <a href='' class='w3-closebtn'>&times;</a>
							        
							      		</div>
							      		 <img src=".$row["poi_photo"]." style='width:100%;max-height:580px'>
							      	</div>
							      </div>
							     </div>";
				    	  }
				    	  else if($row["poi_video"]!=NULL){
				    	  	echo 
				        "<td><a href='searchpoi.php#full".$row[0]."'><video src=".$row["poi_video"]." alt='video' style='width:80px;height:80px'>".
				        "<div id='full".$row[0]."' class='w3-modal'>
							  <div class='w3-modal-dialog'>
							    <div class='w3-modal-content w3-depth-3' style='max-width:100%;height:480px;'>
							      <div class='w3-header teal'> 
							        <a href='' class='w3-closebtn'>&times;</a>
							        
							      		</div>
							      		 <video src=".$row["poi_video"]." style='width:100%;height:92%' controls>
							      	</div>
							      </div>
							     </div>";
				        }
				        else{
				        	echo  
				        "<td> No video or photo.";
				        	}
				        if($row["poi_lat"]!=''){	
				        echo "<td><form name='map' id='map' action='map.php' method='post'>
				        <input hidden id='lat' name='lat' value=".$row["poi_lat"].">
				        <input hidden id='lng' name='lng' value=".$row["poi_lng"].">
				        <input id='clickMe' value='Click me!!' type='submit'></form>";
				      	}
				      	else {
				      	 	echo '<td>N/A';
				      	}
							  
							    
				        
				        echo "<td><form name='like' id='like' action='like.php' method='post'>";
				        $searchip=$_SERVER['REMOTE_ADDR'];
				        $s2="SELECT * FROM ip WHERE banned_ip='$searchip'";
				        $result3 = mysqli_query($con, $s2);
				        $row3=mysqli_fetch_array($result3);
				        if(!$row3){
								echo "<input id='sb'name='sb' type='submit' value=".$row[0]." class='likeImage'>
													</form><br>";
				        				}
				        else{
				        	echo "<span id='b' class='likebubble'>Μπορείτε να κάνετε μόνο ένα like</span>
				        	<input disabled id='sb' name='sb' type='submit' value=".$row[0]." class='nolikeImage'>
				        					</form><br>";
				        	}
				        echo $row["poi_likes"]." likes!!<td>" . $row["username"]. "</tr>";
				    	}
				}
				else {
				    echo "0 results";
				}
				
				mysqli_close($con);
				
						
						
				?>
				

			</tbody>
			</table>

		
	</body>
</html>