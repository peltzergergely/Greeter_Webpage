<!DOCTYPE html>
<html>
	<head>
		<title>Greeter</title>
		<!-- including the css and the google font -->
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
						<!-- search bar and filter buttons -->
			<form method=post>
			<div class="search_bar">
				<input type="text" name= "search" class='search_box' onfocus="if(this.value == 'Keresés az sms-ek között') { this.value = ''; }" value="Keresés az sms-ek között" />
				<input type="submit" class="search_icon" alt="keresés"/>
				</div>
			</div>	
			<div class="filter_boxes">
				<input type='submit' value='Születésnap' class="filter_box" name='Birthday'/>
				<input type='submit' value='Karácsony' class="filter_box" name='Christmas'/>
				<input type='submit' value='Újjév' class="filter_box" name='New_Year'/>
				<input type='submit' value='Összes' class="filter_box" name='All'/>
			</form>
			</div>
		
			<?php
			$filter='';
			if ($_SERVER['REQUEST_METHOD'] === 'POST') {
				//something posted
				if (isset($_POST['Birthday'])) {
				// bday
				$filter = 'Birthday';
				} elseif(isset($_POST['Christmas'])) {
				// xmas
				$filter = 'Christmas';
				}
				 elseif(isset($_POST['New_Year'])) {
				// ny
				$filter = 'New_Year';
				}
			}
			$search='';
			if ($_POST["search"]!="Keresés az sms-ek között") {
				$search=$_POST["search"];
			}
			//G: we should make a separate connection.php
			$servername = "localhost";
			$username = "id893021_greeter";
			$password = "Greeter_sms_01";
			$dbname = "id893021_greeter_db";

			// Create connection
			$connection = new mysqli($servername, $username, $password, $dbname);
			// Check connection
			if ($connection->connect_error) {
				die("Connection failed: " . $connection->connect_error);
			}

			//ha van kereses de nincs filter, majd a ketto egyutt
			if ($search!='' and $search!="Keresés az sms-ek között") {
				if ($filter=='') {
				// SQL query to select sms text from Message table with filters
					$sql = "SELECT * FROM Message WHERE approved = 1 AND sms_text LIKE '%$search%'";
					$result = $connection->query($sql);
					$numOfRows = $result->num_rows;
					if ($numOfRows > 0) {
					// output data of each row
						$i=1;
						echo "<div class='body_border'>
								<table>
									<tr>
										<th>ID</th>
										<th>$numOfRows SMS közül választhatsz</th>
										<th>Típus</th>
									</tr>";
						while($row = $result->fetch_assoc()){
						echo "<tr class='sms'>	
								<td>$row[sms_id]</td>
								<td>$row[sms_text]</td>
								<td>$row[sms_label]</td>
							</tr>";
						$i++;
						}
						echo "</table></div>";
					} else {
						echo "<div class='body_border'>
								<table class>
									<tr>
										<th>ID</th>
										<th>$numOfRows SMS közül választhatsz</th>
										<th>Típus</th>
									</tr>
									<tr class>
										<td></td><td>Sajnos ezeknek a feltételeknek nem felel meg semmi...
										<br>jobb alul van a beküldés gomb *kacsint*
										<td></td>
									</td>
						</div>";
					}
					// ide kéne hogyha van keresés és van filter is, de ahhoz a filtereket checkboxra kéne állítani... meg amúgyis arra kéne
				}else{
					
				}				
			}elseif ($filter!=''){
				// SQL query to select sms text from Message table with filters
				$sql = "SELECT * FROM Message WHERE approved = 1 AND sms_label='$filter'";
				$result = $connection->query($sql);
				$numOfRows = $result->num_rows;
				if ($numOfRows > 0) {
				// output data of each row
					$i=1;
					echo "<div class='body_border'>
							<table>
								<tr>
									<th>ID</th>
									<th>$numOfRows SMS közül választhatsz</th>
									<th>Típus</th>
								</tr>";
					while($row = $result->fetch_assoc()){
					echo "<tr>	
							<td>$row[sms_id]</td>
							<td>$row[sms_text]</td>
							<td>$row[sms_label]</td>";
					$i++;
					}					
				} else {
					echo "Nincs találat!";
				}
			}else{
				// SQL query to select ALL sms text from Message table
				$sql = "SELECT * FROM Message WHERE approved = 1";
				$result = $connection->query($sql);
				$numOfRows = $result->num_rows;
				if ($numOfRows > 0) {
				// output data of each row
					$i=1;
					echo "<div class='body_border'>
							<table>
								<tr>
									<th>ID</th>
									<th>$numOfRows SMS közül választhatsz</th>
									<th>Típus</th>
								</tr>";
					while($row = $result->fetch_assoc()){
					echo "<tr>	
							<td>$row[sms_id]</td>
							<td>$row[sms_text]</td>
							<td>$row[sms_label]</td>
							
						";
					
					$i++;
					}					
				} else {
					echo "Nincs találat!";
				}
			}
			
			$connection->close();
			?>
			</div>
			<div class="submit_sms">
			</div>
		</div>
	</body>

</html>
	