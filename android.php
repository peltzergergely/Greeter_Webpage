<?php

include "connect.php";

$sql = "SELECT * FROM Message";

$result = mysqli_query($connection,$sql);
if($result){
	while($row = mysqli_fetch_array($result))
	{
		$data[] = $row;
	}
	print(json_encode($data));
}
mysqli_close($connection); // Closing Connection
?>