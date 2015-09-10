<?php
include 'Params.php';

session_start();

// get parameters from json
$postdata = file_get_contents("php://input");
$request = json_decode($postdata);

$status = $request->status;

$kbit_name = $request->kbit_name;
$username = $_SESSION['Username'];

// Create connection
$conn = new mysqli($servername, $dbuser,"",$dbname);


// 1. sql query : check if for $username and $kbit_name there is a already a registered status in the db.
$sql_is_registered_status = "SELECT * FROM $UserKbits_Table_Name WHERE $UserKbits_Username = '$username' AND  $UserKbits_Kbitname = '$kbit_name' " ;

$result_is_registered_status = $conn->query($sql_is_registered_status);
//if we already have a status for this kbit in the db, update it.
if ( $result_is_registered_status && $result_is_registered_status->num_rows > 0)
{
	// 2. sql query - update an existing entry.
	$sql = "UPDATE $UserKbits_Table_Name SET $UserKbits_Status ='$status' WHERE $UserKbits_Username ='$username' AND $UserKbits_Kbitname ='$kbit_name'" ;
}


//else - insert into DB new line
else
{
	// 3. sql query - insert new entry.
	$sql = "INSERT INTO $UserKbits_Table_Name  ( $UserKbits_Username , $UserKbits_Kbitname ,$UserKbits_Status) VALUES ('$username','$kbit_name','$status')";
}

$result = $conn->query($sql);


// if update / insert succeeded.
if ($result){
	//echo $result;
	echo "kbit status updated!";
}
else
{
	echo "Error updating your kbit status.";
}

?>