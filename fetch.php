<?php
include("helper/db.php");
$db_connect = new mysqli($host, $user, $password, $dbname);
$query = "SELECT * FROM employee";
$result = mysqli_query($db_connect, $query);
$output = [];
while ($row = mysqli_fetch_assoc($result)) {
	$output[] = $row;
}
echo json_encode($output);