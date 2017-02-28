<?php
   include("connect.php");
   session_start();
   
   $user_check = $_SESSION['login_user'];
   $query="SELECT * FROM admins WHERE admin_name = '$user_check' ";
   $result=mysqli_query($connection,$query) or die("lekérdezési hiba: ".mysqli_error($connection));   
   $row = mysqli_fetch_assoc($result);
   $login_session = $row['admin_name'];  
   if(!isset($_SESSION['login_user'])){
      header("location:admin_login.php");
   }
?>