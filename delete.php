<?php
/**
 * Created by PhpStorm.
 * User: Ehtesham Mehmood
 * Date: 11/24/2014
 * Time: 11:55 PM
 */
include("connect.php");
$delete_id=$_GET['del'];
$delete_query="DELETE from Message WHERE sms_id='$delete_id'";//delete query
$run=mysqli_query($connection,$delete_query);
header("location:admin.php");
?>