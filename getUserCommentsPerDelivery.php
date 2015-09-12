<?php
include 'Params.php';

session_start();

// get parameters from json
$postdata = file_get_contents("php://input");
$request = json_decode($postdata);

$delivey_name = $request->data;
$username = $_SESSION['Username'];

  $sql = "SELECT " . $PersonalComments_Comment .
		" FROM " . $PersonalComments_Table_Name .
		" WHERE " . $PersonalComments_Username . "='" . $username . "'" .
		" AND "  .  $PersonalComments_Delivery_name . "='" . $delivey_name . "'";


// Create connection
$conn = new mysqli($servername, $dbuser,"",$dbname);
$result = $conn->query($sql);

//if we already have a user comment in the db, return it
if ($result && $result->num_rows > 0){
	echo $result->fetch_assoc()["Comment"];
}
else
{
	//echo "No user comments in db. You can add/edit comments for this delivery right here.";
	echo "comments";
}
?>

