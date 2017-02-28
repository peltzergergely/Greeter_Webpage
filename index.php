<!DOCTYPE html>
<html>
	<head>
		<title>Greeter</title>
		<!-- including the css and the google font -->
		<link href="https://fonts.googleapis.com/css?family=Roboto:500" rel="stylesheet">
		<link rel="stylesheet" type="text/css" href="css/style.css">
		<script src="http://code.jquery.com/jquery-1.9.1.min.js"></script>
		<script type="text/javascript" src="css/script.js"></script>
	</head>
	<body>
		<div class="headerB">
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
						<input type="checkbox" value="New_Year" name='chkbox[]' hidden><span>Újév</span>
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
		</div>
			<div class="container">
				<div class="submit_sms"><span>Expand</span>
				</div>
				<div class="content">
					Itt tudsz beküldeni nekünk új SMS-eket!<br>
					<input type="text" class="input_sms" name="sms_in"/>
					<select name='sms_label'>
						<option value='Christmas'>Karácsony</option>
						<option value='New_Year'>Újév</option>
						<option value='Nameday'>Névnap</option>
						<option value='Birthday'>Szülinap</option>
					</select>
					<button class="add-item">Beküldés</button>
				</div>			
			</div>
			</form>
			
			<div id="status-area"></div>


			<!-- submit form -->

			<?php
			include "connect.php";
	
				/* making the search variable here and checking if it's set */
			$search='';
			if (isset($_POST['search']) and $_POST['search']!="Keresés az sms-ek között") { $search=$_POST['search']; }
			/* QUERY TO SEND IN TEXT */
			if (isset($_POST['sms_in']) and strlen($_POST['sms_in'])>5) {
				 sleep(1);
				 $sms_in=$_POST['sms_in'];
				 $sms_label=$_POST['sms_label'];
				 $sql = "INSERT INTO Message (sms_text, sms_language, sms_label, approved) VALUES ('$sms_in', '$sms_label', 'hu', '0')";
				 //echo "$sql";
				 $result = mysqli_query($connection, $sql) or die("Something is fishy");
			}
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
				if (isset($_POST['chkbox']) AND is_array($_POST['chkbox'])) {
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
				$result = mysqli_query($connection, $sql);
				$numOfRows = mysqli_num_rows($result);
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
					while($row = mysqli_fetch_assoc($result)){
						if ($row['sms_label']=='Birthday') $filter_name='Szülinap';
						elseif ($row['sms_label']=='Christmas') $filter_name='Karácsony';
						elseif ($row['sms_label']=='New_Year') $filter_name='Újév';
						elseif ($row['sms_label']=='Nameday') $filter_name='Névnap';
						$len = strlen($row['sms_text']);
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
									<th>T�pus</th>
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
		</div>

	</body>

</html>
	