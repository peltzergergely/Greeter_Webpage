<!DOCTYPE html>
<html>
	<head>
		<title>Greeter</title>
		<!-- including the css and the google font -->
		<link href="https://fonts.googleapis.com/css?family=Roboto:500" rel="stylesheet">
		<link rel="stylesheet" type="text/css" href="css/adminstyle.css">
		<script src="http://code.jquery.com/jquery-1.9.1.min.js"></script>
		<script type="text/javascript" src="css/script.js"></script>
	</head>
	<body>
		<div class="headerB">
			<h1>GREETER</h1>
			<h2>Admin Page</h2>
			<form action="" method="post">

			<!-- meghekkelni logout buttonnak! 
			<input type="submit" class="lang" alt="logout" name="logout"/> -->
			<h2><br><a href='logout.php'>KILÉPÉS</a></h2>
						<!-- search bar and filter buttons -->
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

			</form>			
		<div class='body_border'>
				<table width=100%>
								<tr>
									<th width=5%>ID</th>
									<th width=75%>SMS szöveg</th>
									<th width=8%>Típus</th>									
									<th width=4%>Nyelv</th>
									<th width=4%>Approved</th>
									<th>Hossz</th>
									<th></th>										
									<th></th>
									<th></th>
								</tr>
			<form method=POST>
					<tr>
						<td><input name='sms_id' class='addid'/></td>
						<td><input name='sms_text' type=text class='addsms' placeholder='Módosításhoz add meg az id-t felvitelhez hagyd üresen.'/></td>
						<td>
							<select name='sms_label'>
								<option value='Christmas'>Karácsony</option>
								<option value='New_Year'>Újév</option>
								<option value='Nameday'>Névnap</option>
								<option value='Birthday'>Szülinap</option>
							</select>
						</td>
						<td><select name='sms_lang'>
								<option value='hu'>HUN</option>
								<option value='en'>ENG</option>
							</select>
						</td>
						<td><select name='sms_appr'>
								<option value='1'>Igen</option>
								<option value='0'>Nem</option>
							</select>
						</td>
						<td></td>
						<td colspan='2'><input type=submit name='addsms' value='Felvisz/Módosít'></td>
					</tr>
			</form>
			<!--<div id="status-area"></div>
			-->

			<!-- submit form -->

			<?php
			ob_start();
			include "adminsession.php";
	
				/* making the search variable here and checking if it's set */
			$search='';
			if (isset($_POST['search']) and $_POST['search']!="Keresés az sms-ek között") { $search=$_POST['search']; }
			/* QUERY TO SEND IN TEXT */

				/* SEARCHING IS HAPPENING FROM HERE seems like done, searches with labels and text*/
			if ($search!='' and $search!="Keresés az sms-ek között") {
					$sql = "SELECT * FROM Message WHERE sms_text LIKE '%$search%'";
					if (is_array($_POST['chkbox'])) {
						$sql .= " AND";
						foreach($_POST['chkbox'] AS $value) {
							$sql .= " sms_label='{$value}' OR ";
							//echo $sql;
						}
						$sql  = substr($sql, 0, -4);
						//$sql .= " ORDER BY sms_label";
						//echo "query if= " . $sql . "<br /><br />";
					} 				
					print_result($connection, $sql);
			}else{
				/* query to list filtered or all the SMS */
				if (isset($_POST['chkbox']) AND is_array($_POST['chkbox'])) {
					$sql = "SELECT * FROM Message WHERE";
					foreach($_POST['chkbox'] AS $value) {
						$sql .= " sms_label='{$value}' OR ";
					}
					$sql  = substr($sql, 0, -4);
					//$sql .= " ORDER BY sms_label";
					//echo "query if= " . $sql . "<br /><br />";
					} else {
						$sql = "SELECT * FROM Message";
						//echo "query else= " . $sql . "<br /><br />";
					}
				print_result($connection, $sql);
			}
			
			if(isset($_POST['addsms'])) {
				if(isset($_POST['sms_id']) AND $_POST['sms_id']!='') {
					$sms_id=$_POST['sms_id'];
					if(isset($_POST['sms_text'])){
						$sms_text=$_POST['sms_text'];
						$sms_label=$_POST['sms_label'];
						$sms_lang=$_POST['sms_lang'];
						$sms_appr=$_POST['sms_appr'];
						$sql = "UPDATE Message SET sms_text='$sms_text', sms_language='$sms_lang', sms_label='$sms_label', approved='$sms_appr' WHERE sms_id='$sms_id'";
						$result = mysqli_query($connection, $sql) or die("Something is fishy");
					}else echo "sms szöveg hiányzik";
				}else{
					if(isset($_POST['sms_text'])){
						$sms_text=$_POST['sms_text'];
						$sms_label=$_POST['sms_label'];
						$sms_lang=$_POST['sms_lang'];
						$sms_appr=$_POST['sms_appr'];						
						$sql = "INSERT INTO Message (sms_text, sms_language, sms_label, approved) VALUES ('$sms_text', '$sms_lang', '$sms_label', '$sms_appr')";
						//echo "$sql";
						$result = mysqli_query($connection, $sql) or die("Something is fishy");
					}else echo "sms szöveg hiányzik";
				}
				header('Location: '.$_SERVER['PHP_SELF']); 
			}
			
			
				/* THE PRINT FUNCTION */
			
			function print_result ($connection, $sql){
				$sql .= " ORDER BY approved, sms_id DESC";
				//echo $sql;
				$result = mysqli_query($connection, $sql);
				$numOfRows = mysqli_num_rows($result);
				if ($numOfRows > 0) {
				/* output data for each row */
					$i=1;
					
					while($row = mysqli_fetch_assoc($result)){
						if ($row['sms_label']=='Birthday') $filter_name='Szülinap';
						elseif ($row['sms_label']=='Christmas') $filter_name='Karácsony';
						elseif ($row['sms_label']=='New_Year') $filter_name='Újév';
						elseif ($row['sms_label']=='Nameday') $filter_name='Névnap';
						else $filter_name=$row['sms_label'];
						
						if ($row['approved']=='0') $appr='Nem'; else $appr='Igen';
						
						if ($row['sms_language']=='hu') $lang='HUN'; else $lang='ENG';

						$len = strlen($row['sms_text']);
						
					echo "

						<tr>	
							<td width=5%>$row[sms_id]</td>
							<td width=75%>$row[sms_text]</td>
							<td width=8%>$filter_name</td>	
							<td width=4%>$lang</td>
							<td width=4%>$appr</td>
							<td width=5%>$len</td>
							<form method=post>";
								if ($row['approved']=='0')  echo "<td width=7%><button type='submit' class='button_appr' name='appr_sms' value=\"$row[sms_id]\"/>Jóváhagy</button></td>";
								else echo "<td></td>";
					echo "		
							<td width=7%><button type='submit' name='delete_sms' class='button_del' value=\"$row[sms_id]\"/>Törlés</button></td>
							</form>
						";
					
					$i++;
					}

					
					
					if (isset($_POST['delete_sms'])) {
						$sms_id = $_POST['delete_sms'];
						$sql="DELETE FROM Message WHERE sms_id = '$sms_id'";
						$result = mysqli_query($connection, $sql) or die("Something is fishy");
						header('Location: '.$_SERVER['PHP_SELF']);
					}
					
					if (isset($_POST['appr_sms'])) {
						$sms_id = $_POST['appr_sms'];
						$sql = "UPDATE Message SET approved='1' WHERE sms_id= '$sms_id'";
						$result = mysqli_query($connection, $sql) or die("Something is fishy");
						header('Location: '.$_SERVER['PHP_SELF']);
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
									<td colspan=3>Nincs találat <br>
								</tr>";
				}
			}		
			$connection->close();
			?>
			</div>
		</div>

	</body>

</html>
	