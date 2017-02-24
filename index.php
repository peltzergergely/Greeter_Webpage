<!DOCTYPE html>
<html>
	<head>
		<title>Greeter</title>
		<link href="https://fonts.googleapis.com/css?family=Roboto:100" rel="stylesheet">
		<link rel="stylesheet" type="text/css" href="style.css">
		<script src="http://code.jquery.com/jquery-1.9.1.min.js"></script>
		<script type="text/javascript" src="script.js"></script>
	</head>
	<body>
		<div class="header">
			<h1>GREETER</h1>
			<h2>Ünnepi köszöntések - ha éppen semmi frappáns nem jut az eszedbe!</h2>
			<div class="lang">
			</div>
			<div class="search_bar">
				<input type="text" name= 'search' class='search_box' onfocus="if(this.value == 'Keresés...') { this.value = ''; }" value="Keresés..." />
				<div class="search_icon"><input type="submit" name="" value=""></div>
				</div>
			</div>
			<div class="filter_boxes">
				<div class="filter_box">nulla</div>
				<div class="filter_box">egy</div>
				<div class="filter_box">ketto</div>
				<div class="filter_box">harom</div>
				<div class="filter_box">negy</div>
			</div>
			
			<div class="body_border">
			
			<?php
			$servername = "localhost";
			$username = "ncep2y";
			$password = "D_9db9f2";
			$dbname = "ncep2y";

			// Create connection
			$connection = new mysqli($servername, $username, $password, $dbname);
			// Check connection
			if ($connection->connect_error) {
				die("Connection failed: " . $connection->connect_error);
			} 
			// SQL query to select sms text from Message table
			$sql = "SELECT sms_text_hu FROM Message WHERE approved = 1";
			$result = $connection->query($sql);

			if ($result->num_rows > 0) {
			// output data of each row
				$i=1;
				while($row = $result->fetch_assoc()){
				echo "<div class='sms'>$row[sms_text_hu]</div>";
				
				$i++;
				}
			} else {
				echo "Nincs találat!";
			}
			$connection->close();
			?>
				<div class="sms">első</div>
				<div class="sms">második</div>
				<div class="sms">harmadik</div>
				<div class="sms">negyedik</div>
			</div>
			<div class="submit_sms">
			</div>
		</div>
	</body>
</html>
	