<?php
include 'Params.php';

session_start();

// get parameters from json
$postdata = file_get_contents("php://input");
$request = json_decode($postdata);

$delivery_name = $request->delivery_name;

$username = $_SESSION['Username'];

$status_img = "Pic/eye_gray1.jpg";

// Create connection
$conn = new mysqli($servername, $dbuser,"",$dbname);


// 1. sql query : check if for $username and $delivery_name there is a already a registered row in the db.
$sql_is_registered_row = "SELECT $PersonalComments_Status FROM $PersonalComments_Table_Name WHERE $PersonalComments_Username = '$username' AND  $PersonalComments_Delivery_name = '$delivery_name' " ;

$result_is_registered_row = $conn->query($sql_is_registered_row);
//if we already have a row for this delivery and user in the db, update it.
if ( $result_is_registered_row && $result_is_registered_row->num_rows > 0)
{
	$status_to_set = "";
	// set the opposite status, for what is already registered in DB
	if ($result_is_registered_row->fetch_assoc()["Status"] == "v")
	{
		$status_to_set = "x";
		$status_img = "Pic/eye_gray1.jpg";
	}
	else
	{
		$status_to_set = "v";
		$status_img = "Pic/eye_blue1.jpg";
	}
	
	// 2. sql query - update an existing entry.
	$sql = "UPDATE $PersonalComments_Table_Name SET $PersonalComments_Status ='$status_to_set' WHERE $PersonalComments_Username ='$username' AND $PersonalComments_Delivery_name ='$delivery_name'" ;
}


//else - insert into DB new line with status = 'v' (and with Comment = "comments")
else
{
	// 3. sql query - insert new entry.
	$sql = "INSERT INTO $PersonalComments_Table_Name  ( $PersonalComments_Username , $PersonalComments_Delivery_name ,$PersonalComments_Comment, $PersonalComments_Status) VALUES ('$username','$delivery_name','comments','v')";
	$status_img = "Pic/eye_blue1.jpg";
}

$result = $conn->query($sql);


// if update / insert succeeded.
if ($result){
	echo $status_img;
}
else
{
	echo "Error changing delivery's watches status";
}

?>