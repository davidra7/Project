<?php
include 'Params.php';

session_start();

// get parameters from json
$postdata = file_get_contents("php://input");
$request = json_decode($postdata);

$delivery_name = $request->delivery_name;

$username = $_SESSION['Username'];

$sql = "SELECT " . $PersonalComments_Status . 
  		" FROM " . $PersonalComments_Table_Name .
  		" WHERE " . $PersonalComments_Username . "='" . $username . "'" .
  		" AND "  . $PersonalComments_Delivery_name . "='" . $delivery_name . "'";
 
// Create connection
  $conn = new mysqli($servername, $dbuser,"",$dbname);
  $result = $conn->query($sql);

 if ($result && $result->num_rows)
 {
 	$tmp_res = $result->fetch_assoc()["Status"];
 	if ($tmp_res == "v")
 	{
 		echo "Pic/eye_blue1.jpg";
 	}
 	else if ($tmp_res == "x")
 	{
 		echo "Pic/eye_gray1.jpg";
 	}
 	
 }
 else
 {
 	echo "Pic/eye_gray1.jpg";
 }

?>

