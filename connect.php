<?php
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
?>