<?php 
include 'Params.php';
session_start();
// get parameters from json
$postdata = file_get_contents("php://input");
$request = json_decode($postdata,true);
// Flow array - each Delivery is accesable with $FlowArray[1]
$FlowArray = $request['flow'];
$FlowName = $request['flowname'];

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
$sqlSelectNumberOfUsersFlows = " SELECT DISTINCT ". $SavedFlows_Flow_id .",". $SavedFlows_User_id ." FROM ".$SavedFlows_Table_Name ." Where ".$SavedFlows_User_id."='".$currentUser."' ORDER BY ".$SavedFlows_Flow_id." DESC";
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
	$sqlCommand = "INSERT INTO ".$SavedFlows_Table_Name." (".$SavedFlows_User_id.",".$SavedFlows_Flow_id.",".$SavedFlows_Data.",".$SavedFlows_Chunk.",".$SavedFlow_Name.") VALUES ( '".$currentUser."','". $FlowNumber ."','". $FlowArray[$i]." ','". $i ."','".$FlowName."' )" ;
	$result = $connn->query($sqlCommand);
	
}


echo "Added";
?>