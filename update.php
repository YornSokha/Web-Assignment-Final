<?php
//update.php
include("helper/db.php");
$db_connect = new mysqli($host, $user, $password, $dbname);
$query = "
 UPDATE employee SET " . $_POST["name"] . " = '" . $_POST["value"] . "' 
 WHERE id = '" . $_POST["pk"] . "'";
mysqli_query($db_connect, $query);
?>