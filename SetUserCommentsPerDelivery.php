<?php
include 'Params.php';

session_start();

// get parameters from json
$postdata = file_get_contents("php://input");
$request = json_decode($postdata);

$delivey_name = $request->data;


$comment = $request->comment;
$username = $_SESSION['Username'];


// Create connection
$conn = new mysqli($servername, $dbuser,"",$dbname);

// 1. sql query : check if for $username and $delivery_name there is a already a registered comment in the db.
$sql_is_registered_comment = "SELECT * " .							 " FROM " . $PersonalComments_Table_Name . 
 							 " WHERE " . $PersonalComments_Delivery_name . "='" . $delivey_name . "' AND " . $PersonalComments_Username . "='" . $username . "'" ;
$result_is_registered_comment = $conn->query($sql_is_registered_comment);
//if we already have a user comment for this delivery in the db, update it.
if ( $result_is_registered_comment && $result_is_registered_comment->num_rows > 0)
{
	// 2. sql query - update an existing entry.
	$sql = "UPDATE " . $PersonalComments_Table_Name . 
			" SET " . $PersonalComments_Comment . "='" . $comment . "'" .
			" WHERE " . $PersonalComments_Username . "='" . $username . "' AND " . $PersonalComments_Delivery_name . "='" . $delivey_name . "'";
}
else
{
	// 3. sql query - insert new entry.
	$sql = "INSERT INTO " . $PersonalComments_Table_Name . " (". $PersonalComments_Username .",". $PersonalComments_Delivery_name .",".$PersonalComments_Comment.") ".
		" VALUES (". "'". $username ."'" . ", '".$delivey_name."', " . "'" . $comment . "')";
}

$result = $conn->query($sql);


// if update / insert succeeded.
if ($result){
	echo "Comment updated!";
}
else
{
	echo "Error updating your comment.";
}
?>