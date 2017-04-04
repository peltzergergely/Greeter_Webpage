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
			<div class="container_web">
				<div class="submit_web"><span>Expand</span>
				</div>
				<div class="content_web">
					Itt tudsz beküldeni nekünk hasonló oldalakat, hogy a miénk legyen végül a legnagyobb!<br>
					<input type="text" class="input_web" name="sms_in"> 
					<button class="add-item">Beküldés</button>
					<br>
					<div class="web_limiter">
					<?php
					$sql = "SELECT * FROM Webpages WHERE web_appr = 1";
					$result = mysqli_query($connection, $sql);
					$numOfRows = mysqli_num_rows($result);
					if ($numOfRows > 0) {
					/* output data for each row */
						$i=1;					
					?>
					<table class="web_out" width=100%>
								<tr class="out">
									<th class="out">Eddig beküldött hasonló oldalak</th>
								</tr>
										<?php 
						while($row = mysqli_fetch_assoc($result)){
							?>
								<tr class="out">	
									<td class="out"><a target="_blank" href="<?php echo $row['web_url']?>"><?php echo $row['web_url']?></a></td>
							<?php
							$i++;
						}
					}?>
					</div>
				</div>			
			</div>
	</body>
</html>