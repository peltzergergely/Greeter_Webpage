<?php
include "connect.php";
$name=$_POST['Query'];
$sql = "SELECT * FROM Message WHERE sms_text LIKE '%$name%' AND approved = 1";
$result = mysqli_query($connection,$sql);
if($result){
	while($row = mysqli_fetch_array($result))
	{
		$data[] = $row;
	}
	print(json_encode($data));
}else{
	echo('Not Found ');
}
mysqli_close($connection); // Closing Connection
?>