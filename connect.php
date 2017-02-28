<?php

    // az adatbazis kapcsolat parameterei
    $host="localhost";
    $user="id893021_greeter";
    $pass="Greeter_sms_01";
    $db="id893021_greeter";

    // adatbazis kapcsolat letrehozasa
	$connection=mysqli_connect($host,$user,$pass) or die("Could not connect");
	

    // adatbazis kivalasztasa
	mysqli_select_db($connection,$db) or die("Could not select database");
	
?>