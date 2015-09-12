<?php 
include 'Params.php';
session_start();
// get parameters from json
$postdata = file_get_contents("php://input");
$request = json_decode($postdata,true);

// Flow array - each Delivery is accesable with $FlowArray[1]
$FlowArray = $request['flow'];
//$FlowArray = "1";
$FlowName = $request['flowname'];
//$FlowName = "test";

// Set current User
$currentUser = $_SESSION['Username'];
//$currentUser = "David23"; // for testing 

if (  null == $FlowArray || null == $currentUser )
{
	echo "Failed";
	return;
}
//TBD
$connn = new mysqli($servername, $dbuser,"",$dbname);

// get number of flows of the current User
$sqlSelectNumberOfUsersFlows = " SELECT DISTINCT $Wishlist_Flow_id , $SavedFlows_User_id FROM $Wishlist_Table_Name  Where $Wishlist_User_id='$currentUser' ORDER BY $Wishlist_User_id DESC";
$result = $connn->query($sqlSelectNumberOfUsersFlows);

// $arr place 0 is number of the last FlowID of the current user
$arr = mysqli_fetch_array ($result);
if ( null == $arr)
{
	$FlowNumber = 0;
}
else
{
	$FlowNumber = $arr[0] + 1;
}

// per each flow add it by chuncks
for ( $i = 0; $i < count($FlowArray) ; $i++)
{
	$D_Name = $FlowArray[$i]['name'];
	$sqlCommand = "INSERT INTO $Wishlist_Table_Name ($Wishlist_User_id,$Wishlist_Flow_id,$Wishlist_Data,$Wishlist_Chunk,$Wishlist_Name) VALUES ( '$currentUser','$FlowNumber','$D_Name','$i','$FlowName' )" ;
	$result = $connn->query($sqlCommand);
	if (true != $result)
	{
		//TBD - remove added messages. 	
		echo Failed;
		return;
	}
}


echo "Added";
?>