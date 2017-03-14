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
				<div class="login_container">
                                <input placeholder="Name" name="admin_name" type="text" autofocus><br>
                                <input placeholder="Password" name="admin_pass" type="password" value=""><br>
                            <input class="button" type="submit" value="login" name="admin_login" >
				</div>

</body>

</html>

<?php

include("connect.php");
session_start();

if(isset($_POST['admin_login']))//this will tell us what to do if some data has been post through form with button.
{
    $admin_name=$_POST['admin_name'];
    $admin_pass=$_POST['admin_pass'];

    $sql="SELECT * FROM admins WHERE admin_name ='$admin_name' AND admin_pass='$admin_pass'";

    $result=mysqli_query($connection,$sql) or die("something went wrong");

    if(mysqli_num_rows($result)>0)
    {
		$_SESSION['login_user'] = $admin_name;
        header("location: admin.php");
    }
    else {echo"<script>alert('Admin Details are incorrect!')</script>";}

}

?>