﻿<!DOCTYPE html>
<html>
	<head>
	<link rel="shortcut icon" type="image/x-icon" href="images/fav.ico" />
	<title>Top 5</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" type="text/css" href="w3full.css"/>

	</head>
	<body>
		<div class="blue">
		<?php include 'menu.php';?>
		</div>
		<div class="w3-header w3-large blue-d4">
			Top 5
		</div>

		<table class="w3-table w3-bordered w3-hoverable">
			<thead>
			<tr>
			  <th>POI</th>
			  <th>Κατηγορία</th>
			  <th>Περιγραφή</th>
			  <th>Photo/Video</th>
			  <th>Ποσοστό <br> Δημοφιλίας</th>
			  <th>Χρήστης</th>
			</tr>
			</thead>
			<tbody>
				<?php
				include 'dbconnect.php';
				mysqli_query ($con,' set character set utf8 ');
				$likes=0;
				$sql2="SELECT poi_likes FROM poi";
				$result3 = mysqli_query($con, $sql2);
				while($row3 = mysqli_fetch_array($result3)){
					$likes += $row3[0];
				}
				$sql = "SELECT * FROM poi ORDER BY poi_likes DESC";
				$result = mysqli_query($con, $sql);
				
				if (mysqli_num_rows($result) > 0) {
    // output data of each row
		    for ($i = 0; $i < 5; $i++) {
		     	 $row = mysqli_fetch_array($result);
		    
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
							    <div class='w3-modal-content w3-depth-3' style='max-width:100%;height:480px;'>
							      <div class='w3-header teal'> 
							        <a href='' class='w3-closebtn'>&times;</a>
							        
							      		</div>
							      		 <img src=".$row["poi_photo"]." style='width:100%;height:100%'>
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
				        	
				        
				        echo "<td>";
				        echo round($row["poi_likes"]/$likes*100,2)."% των likes!!<td>" . $row["username"]. "</tr>";
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