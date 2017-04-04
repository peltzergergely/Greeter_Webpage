<!DOCTYPE html>
<?php	include "connect.php"; ?>
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
						<!-- ------------------ header ------------------ -->
		<div class="headerB">
			<h1>GREETER</h1>
			<h2>Special Greetings - When you just need something catchy!</h2>
			<div class="lang_hu" onclick="location.href='http://greeter.hostei.com/index.php';" style="cursor:pointer;">
			</div>
						<!-- ------------------ search bar ------------------ -->
			<form action="" method="post">
				<div class="search_bar">
					<input placeholder="Search in sms text" type="text" name= "search" class='search_box' autofocus />
					<input type="submit" class="search_icon" alt="keresés"/>
				</div>
							<!-- ------------------ filter boxes ------------------ -->			
				<div class="filter_boxes">			
					<div id="ck-button">
						<label>
							<input type="checkbox" value="Birthday" name='chkbox[]' hidden><span>Birthday</span>
						</label>					
					</div>
					<div id="ck-button">
						<label>
							<input type="checkbox" value="Nameday" name='chkbox[]' hidden><span>Nameday</span>
						</label>					
					</div>
					<div id="ck-button">
						<label>
							<input type="checkbox" value="Christmas" name='chkbox[]' hidden><span>Christmas</span>
						</label>					
					</div>
					<div id="ck-button">
						<label>
							<input type="checkbox" value="New_Year" name='chkbox[]' hidden><span>New Year</span>
						</label>					
					</div>
					<div id="ck-button">
						<label>
							<input type="checkbox" value="All" name='All' hidden><span>All</span>
						</label>					
					</div>
				</div>
				<div class="info">To narrow down the results click on one or more labels and click on the seach button!
				</div>		
							<!-- ------------------ sms input START ------------------ -->			
			</div>
				<div class="container">
					<div class="submit_sms"><span>Expand</span>
					</div>
					<div class="content">
						Here you can send us new messages!<br>
						<textarea class="input_sms" name="sms_in"> </textarea>
						<br>
						<select name='sms_label' class='sms_label'>
							<option value='Christmas'>Christmas</option>
							<option value='New_Year'>New Year</option>
							<option value='Nameday'>Nameday</option>
							<option value='Birthday'>Birthday</option>
						</select>
							<!-- ------------------ WEBSITE  input START ------------------ -->	
						<button class="add-item">Send</button>
							<?php 
								if (isset($_POST['web_in']) and strlen($_POST['web_in'])>5) {
								 sleep(1);
								 $web_in=$_POST['web_in'];
								 $sql = "INSERT INTO Webpages (web_url, web_appr) VALUES ('$web_in', '0')";
								 //echo "$sql";
								 $result = mysqli_query($connection, $sql) or die("Something is fishy");
							}?>							
					</div>			
				</div>				
				<div class="container_web">
					<div class="submit_web"><span>Expand</span></div>
						<div class="content_web">
							Here you can send us similar sites where from we can extract new messages!<br>
							<input type="text" class="input_web" name="web_in"> 
							<button class="add-item">Send</button>
							<br>
							<div class="web_limiter">
							<table class="web_out" width=100%>
								<?php
								$sql = "SELECT * FROM Webpages WHERE web_appr = 1";
								$result = mysqli_query($connection, $sql);
								$numOfRows = mysqli_num_rows($result);
								if ($numOfRows > 0) {
									/* output data for each row */
										$i=1;					
									?>
												<tr class="out">
													<th class="out">What we have so far:</th>
												</tr>
									<?php 
										while($row = mysqli_fetch_assoc($result)){
									?>
												<tr class="out">	
													<td class="out"><a target="_blank" href="<?php echo $row['web_url']?>"><?php echo $row['web_url']?></a></td>
												</tr>
									<?php
										$i++;
										}
									}
									?>
							</table>
						</div>
					</div>		
				</div>			
			</form>			
			<?php 
				if (isset($_POST['sms_in']) and strlen($_POST['sms_in'])>5) {
				 sleep(1);
				 $sms_in=$_POST['sms_in'];
				 $sms_label=$_POST['sms_label'];
				 $sql = "INSERT INTO Message (sms_text, sms_language, sms_label, approved) VALUES ('$sms_in', 'en', '$sms_label', '0')";
				 //echo "$sql";
				 $result = mysqli_query($connection, $sql) or die("Something is fishy");
			}?>			
			<div id="status-area"></div>
			<?php
				/* making the search variable here and checking if it's set */
			$search='';
			if (isset($_POST['search']) and $_POST['search']!="") { $search=$_POST['search']; } //GIVE SEARCH VARIABLE THE DATA FROM THE FIELD
			if ($search!='' and $search!="Keresés az sms-ek között") { //Check if search is filled
					$sql = "SELECT * FROM Message WHERE approved = 1 AND sms_language = 'en' AND sms_text LIKE '%$search%'";
					//echo "query = " . $sql . "<br /><br />";
					// check if checkboxes are ticked and make the query lining them together
					if (isset($_POST['chkbox'])) { 
						$sql .= " AND (";
						foreach($_POST['chkbox'] AS $value) {
							$sql .= " sms_label='{$value}' OR ";
						}
						$sql  = substr($sql, 0, -4);
						$sql .= ") ORDER BY sms_label";
						//echo "query = " . $sql . "<br /><br />";
					} 				
			}else{				
				if (isset($_POST['chkbox']) AND is_array($_POST['chkbox'])) {  /* query to list filtered or all the SMS */
					$sql = "SELECT * FROM Message WHERE approved = 1 AND sms_language = 'en' AND (";
					foreach($_POST['chkbox'] AS $value) {
						$sql .= " sms_label='{$value}' OR ";
					}
					$sql  = substr($sql, 0, -4);
					$sql .= ") ORDER BY sms_label";
					//echo "query = " . $sql . "<br /><br />";
					} else {
						$sql = "SELECT * FROM Message WHERE approved = 1 AND sms_language = 'en'";
						//echo "query = " . $sql . "<br /><br />";
					}
			}
			print_result($connection, $sql);
			?>
			
			<?php
				/* THE PRINT FUNCTION */			
			function print_result ($connection, $sql){
				$result = mysqli_query($connection, $sql);
				$numOfRows = mysqli_num_rows($result);
				if ($numOfRows > 0) {
				/* output data for each row */
					$i=1; ?>
					<div class='body_border'>
							<table width=100%>
								<tr>
									<th width=5%>ID</th>
									<th><?php echo $numOfRows ?> SMS to choose from</th>
									<th width=12%>Type</th>
									<th>Length</th>
								</tr>								
					<?php 
						while($row = mysqli_fetch_assoc($result)){
						if ($row['sms_label']=='Birthday') $filter_name='Birthday';
						elseif ($row['sms_label']=='Christmas') $filter_name='Christmas';
						elseif ($row['sms_label']=='New_Year') $filter_name='New Year';
						elseif ($row['sms_label']=='Nameday') $filter_name='Nameday';
						$len = strlen($row['sms_text']);
					?> 
						<tr>	
							<td><?php echo $row['sms_id']?></td>
							<td><?php echo $row['sms_text']?></td>
							<td><?php echo $filter_name?></td>	
							<td><?php echo $len ?></td>
					<?php 					
					$i++;
					}
				/* fancy no result */
				} else {?>
					<div class='body_border'>
							<table width=100%>
								<tr>
									<th width=5%>ID</th>
									<th width=80%><?php echo $numOfRows ?> SMS to choose from</th>
									<th>Típus</th>
								</tr>
								<tr>
									<td colspan=3>Unfortunately the search did not bring any results <br>
									on the bottom you can send us new messages *wink*</td>
								</tr>
				<?php 
				}
			}
			$connection->close();
			?>
						</table>
					</table>
				</div>
			</div>
	</body>
</html>
	