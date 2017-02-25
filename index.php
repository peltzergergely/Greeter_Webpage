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
				/* checking buttonpress here and giving value to $filter */ 
			$filter='';
			if ($_SERVER['REQUEST_METHOD'] === 'POST') {
				//something posted
				if (isset($_POST['Birthday'])) { $filter = 'Birthday';
				} elseif(isset($_POST['Christmas'])) { $filter = 'Christmas';
				} elseif(isset($_POST['New_Year'])) { $filter = 'New_Year'; }
			}
				/* making the search variable here and checking if it's set */
			$search='';
			if ($_POST["search"]!="Keresés az sms-ek között") { $search=$_POST["search"]; }
			
				/* the connection to the DB is estabilished HERE */
			include "connect.php";
						
				/* SEARCHING IS HAPPENING FROM HERE */
			if ($search!='' and $search!="Keresés az sms-ek között") {
				if ($filter=='') {
				/* query for searchbar */
					$sql = "SELECT * FROM Message WHERE approved = 1 AND sms_text LIKE '%$search%'";
					print_result($connection, $sql);
				}
				/* query for the labeling - currently only one at a time*/
			}elseif ($filter!=''){
				$sql = "SELECT * FROM Message WHERE approved = 1 AND sms_label='$filter'";
				print_result($connection, $sql);
			}else{
				/* query to list ALL the SMS */
				$sql = "SELECT * FROM Message WHERE approved = 1";
				print_result($connection, $sql);
			}
			
				/* THE PRINT FUNCTION */
			
			function print_result ($connection, $sql){
				$result = $connection->query($sql);
				$numOfRows = $result->num_rows;
				if ($numOfRows > 0) {
				/* output data for each row */
					$i=1;
					echo "<div class='body_border'>
							<table width=100%>
								<tr>
									<th width=5%>ID</th>
									<th>$numOfRows SMS közül választhatsz</th>
									<th width=12%>Típus</th>
									<th>Hossz</th>
								</tr>";
					while($row = $result->fetch_assoc()){
						if ($row[sms_label]=='Birthday') $filter_name='Szülinap';
						elseif ($row[sms_label]=='Christmas') $filter_name='Karácsony';
						elseif ($row[sms_label]=='New_Year') $filter_name='Újjév';
						$len = strlen($row[sms_text]);
					echo "<tr>	
							<td>$row[sms_id]</td>
							<td>$row[sms_text]</td>
							<td>$filter_name</td>	
							<td>$len</td>
						";
					
					$i++;
					}
				/* fancy no result */
				} else {
					echo "<div class='body_border'>
							<table width=100%>
								<tr>
									<th width=5%>ID</th>
									<th width=80%>$numOfRows SMS közül választhatsz</th>
									<th>Típus</th>
								</tr>
								<tr>
									<td colspan=3>Sajnos nincs a keresésnek megfelelő üzenet a rendszerünkben <br>
									jobb alul találod a beküldés gombot *kacsint*</td>
								</tr>";
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
	