<?php

include "connect.php";

$sql = "SELECT * FROM Message WHERE approved = 1 AND sms_language='hu' AND sms_label='Nameday'";

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