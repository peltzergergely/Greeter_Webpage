<!DOCTYPE html>
<html>
	<head>
		<title>Greeter</title>
		<!-- including the css and the google font -->
		<link href="https://fonts.googleapis.com/css?family=Roboto:500" rel="stylesheet">
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
			<form action="" method="post">
			<div class="filter_boxes">			
				<div id="ck-button">
					<label>
						<input type="checkbox" value="Birthday" name='chkbox[]' hidden><span>Születésnap</span>
					</label>					
				</div>
				<div id="ck-button">
					<label>
						<input type="checkbox" value="Nameday" name='chkbox[]' hidden><span>Névnap</span>
					</label>					
				</div>
				<div id="ck-button">
					<label>
						<input type="checkbox" value="Christmas" name='chkbox[]' hidden><span>Karácsony</span>
					</label>					
				</div>
				<div id="ck-button">
					<label>
						<input type="checkbox" value="New_Year" name='chkbox[]' hidden><span>Újjév</span>
					</label>					
				</div>
				<div id="ck-button">
					<label>
						<input type="checkbox" value="All" name='All' hidden><span>Összes</span>
					</label>					
				</div>
			</div>
			<div class="search_bar">
				<input type="text" name= "search" class='search_box' onfocus="if(this.value == 'Keresés az sms-ek között') { this.value = ''; }" value="Keresés az sms-ek között" />
				<input type="submit" class="search_icon" alt="keresés"/>
			</div>
			</form>
			</div>
			
			<!-- submit form -->
			<div class="wrapper">
				<div id="slide">
				Itt tudsz sms-t beküldeni. csak töltsd ki a mezőt és moderátoraink hamarosan jóváhagyják!
				<form>
				  <input id="submitfield" type="text"/>
				 </form>
				</div>
			</div>
			<?php
	
				/* making the search variable here and checking if it's set */
			$search='';
			if ($_POST["search"]!="Keresés az sms-ek között") { $search=$_POST["search"]; }	
			
				/* the connection to the DB is estabilished HERE */
			include "connect.php";
				/* SEARCHING IS HAPPENING FROM HERE seems like done, searches with labels and text*/
			if ($search!='' and $search!="Keresés az sms-ek között") {
					$sql = "SELECT * FROM Message WHERE approved = 1 AND sms_text LIKE '%$search%'";
					if (is_array($_POST['chkbox'])) {
						$sql .= " AND";
						foreach($_POST['chkbox'] AS $value) {
							$sql .= " sms_label='{$value}' OR ";
						}
						$sql  = substr($sql, 0, -4);
						$sql .= " ORDER BY sms_label";
					//	echo "query if= " . $sql . "<br /><br />";
					} 				
					print_result($connection, $sql);
			}else{
				/* query to list filtered or all the SMS */
				if (is_array($_POST['chkbox'])) {
					$sql = "SELECT * FROM Message WHERE approved = 1 AND";
					foreach($_POST['chkbox'] AS $value) {
						$sql .= " sms_label='{$value}' OR ";
					}
					$sql  = substr($sql, 0, -4);
					$sql .= " ORDER BY sms_label";
					//echo "query if= " . $sql . "<br /><br />";
					} else {
						$sql = "SELECT * FROM Message WHERE approved = 1";
					//	echo "query else= " . $sql . "<br /><br />";
					}
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
						elseif ($row[sms_label]=='Nameday') $filter_name='Névnap';
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
	