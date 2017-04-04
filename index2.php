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
	<body>	<script>  window.fbAsyncInit = function() {    FB.init({      appId      : '182349362274094',      xfbml      : true,      version    : 'v2.8'    });    FB.AppEvents.logPageView();  };  (function(d, s, id){     var js, fjs = d.getElementsByTagName(s)[0];     if (d.getElementById(id)) {return;}     js = d.createElement(s); js.id = id;     js.src = "//connect.facebook.net/en_US/sdk.js";     fjs.parentNode.insertBefore(js, fjs);   }(document, 'script', 'facebook-jssdk'));</script>
						<!-- ------------------ header ------------------ -->
		<div class="headerB">
			<h1>GREETER</h1>
			<h2>Ünnepi köszöntések - ha éppen semmi frappáns nem jut az eszedbe!</h2>
			<div class="lang">
			</div>
						<!-- ------------------ search bar ------------------ -->
			<form action="" method="post">
				<div class="search_bar">
					<input placeholder="Keresés az sms-ek között" type="text" name= "search" class='search_box' autofocus />
					<input type="submit" class="search_icon" alt="keresés"/>
				</div>
							<!-- ------------------ filter boxes ------------------ -->			
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
				<div class="info">A találatok szűkítéséhez jelölj ki egy vagy több kategóriát majd kattints a keresés gombra!
				</div>		
							<!-- ------------------ sms input START ------------------ -->			
			</div>
				<div class="container">
					<div class="submit_sms"><span>Expand</span>
					</div>
					<div class="content">
						Itt tudsz beküldeni nekünk új SMS-eket!<br>
						<textarea class="input_sms" name="sms_in"> </textarea>
						<br>
						<select name='sms_label' class='sms_label'>
							<option value='Christmas'>Karácsony</option>
							<option value='New_Year'>Újév</option>
							<option value='Nameday'>Névnap</option>
							<option value='Birthday'>Szülinap</option>
						</select>
						<button class="add-item">Beküldés</button>
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
							Itt tudsz beküldeni nekünk hasonló oldalakat, hogy a mi adatbázisunk legyen végül a legnagyobb!<br>
							<input type="text" class="input_web" name="web_in"> 
							<button class="add-item">Beküldés</button>
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
													<th class="out">Eddig beküldött hasonló oldalak</th>
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
				 $sql = "INSERT INTO Message (sms_text, sms_language, sms_label, approved) VALUES ('$sms_in', 'hu', '$sms_label', '0')";
				 //echo "$sql";
				 $result = mysqli_query($connection, $sql) or die("Something is fishy");
			}?>			
			<div id="status-area"></div>
			<?php
				/* making the search variable here and checking if it's set */
			$search='';
			if (isset($_POST['search']) and $_POST['search']!="") { $search=$_POST['search']; } //GIVE SEARCH VARIABLE THE DATA FROM THE FIELD
			//Check if search is filled
			if ($search!='' and $search!="Keresés az sms-ek között") { 
					$sql = "SELECT * FROM Message WHERE approved = 1 AND sms_text LIKE '%$search%'";
					// check if checkboxes are ticked and make the query lining them together
					if (isset($_POST['chkbox'])) { 
						$sql .= " AND";
						foreach($_POST['chkbox'] AS $value) {
							$sql .= " sms_label='{$value}' OR ";
						}
						$sql  = substr($sql, 0, -4);
						$sql .= " ORDER BY sms_label";
						//echo "query if= " . $sql . "<br /><br />";
					} 				
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
						//echo "query else= " . $sql . "<br /><br />";
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
									<th><?php echo $numOfRows ?> SMS közül választhatsz</th>
									<th width=12%>Típus</th>
									<th>Hossz</th>									<th>Megosztás</th>
								</tr>								
					<?php 
						while($row = mysqli_fetch_assoc($result)){
						if ($row['sms_label']=='Birthday') $filter_name='Szülinap';
						elseif ($row['sms_label']=='Christmas') $filter_name='Karácsony';
						elseif ($row['sms_label']=='New_Year') $filter_name='Újév';
						elseif ($row['sms_label']=='Nameday') $filter_name='Névnap';
						$len = strlen($row['sms_text']);						$roww = ($row['sms_text']);
					?> 
						<tr>															
							<td><?php echo $row['sms_id']?></td>
							<td><?php echo $row['sms_text']?></td>
							<td><?php echo $filter_name?></td>	
							<td><?php echo $len ?></td>							
							<td>
								<div class="well">  
									<button class="btn btn-info share-btn">Share</button></div>
								<script type="text/javascript">
								function fb_share(){  
									FB.ui( {  
										method: 'feed',    
										name: "Greeter - Ünnepi köszöntések",	
										quote: "<?php echo $row['sms_text']?>" ,    
										link: "http://greeter.hostei.com/",    
										caption: "A világ legismertebb üdvözletküldő oldala",    
										actions: {"name":"Üdvözlet", "link":"http://greeter.hostei.com/"}}, 
										function( response ) {  
										} 
										);}
										
										$(document).ready(function(){
										$('.share-btn').on( 'click', fb_share );
								});
								</script>
							</td>
					<?php 					
					$i++;
					}
				/* fancy no result */
				} else {?>
					<div class='body_border'>
							<table width=100%>
								<tr>
									<th width=5%>ID</th>
									<th width=80%><?php echo $numOfRows ?> SMS közül választhatsz</th>
									<th>Típus</th>
								</tr>
								<tr>
									<td colspan=3>Sajnos nincs a keresésnek megfelelő üzenet a rendszerünkben <br>
									jobb alul találod a beküldés gombot *kacsint*</td>
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
	