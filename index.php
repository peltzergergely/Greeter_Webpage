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
				<div class="sms">elsõ</div>
				<div class="sms">második</div>
				<div class="sms">harmadik</div>
				<div class="sms">negyedik</div>
			</div>
			<div class="submit_sms">
			</div>
		</div>
	</body>
</html>
	