<?php 
include 'Params.php';
if (! session_start())
{
	return;
}
// Set current User
$currentUser = $_SESSION['Username'];
//$currentUser = "david";
$FinalData = array();
//TBD
$connn = new mysqli($servername, $dbuser,"",$dbname);
// get number of flows of the current User
$sqlSelectNumberOfUsersFlows = " SELECT DISTINCT  $Wishlist_Name,$Wishlist_Flow_id FROM ". $Wishlist_Table_Name ." Where ".$Wishlist_User_id."='".$currentUser."'";
$result = $connn->query($sqlSelectNumberOfUsersFlows);
// $arr place 0 is number of the last FlowID of the current user
$rows = array();
while ($row = mysqli_fetch_array($result)) {
	$rows[] = array( $Wishlist_Flow_id=>$row[$Wishlist_Flow_id],$Wishlist_Name=>$row[$Wishlist_Name]);
}

// for each name bring all the data
for ($i = 0; $i < count($rows) ; $i++)
{
	$tempArray = array();
	$sqlSelectNumberOfUsersFlows = " SELECT ". $Wishlist_Data." FROM ". $Wishlist_Table_Name ." Where ".$Wishlist_User_id."='".$currentUser."' AND $Wishlist_Name='" . $rows[$i][$Wishlist_Name] . "' ORDER BY $Wishlist_Chunk ASC ";
	$result = $connn->query($sqlSelectNumberOfUsersFlows);
	while ($row = mysqli_fetch_array($result)) {
		 array_push($tempArray, $row[$SavedFlows_Data]);
	}
	array_push( $FinalData , $rows[$i]);
	array_push( $FinalData , $tempArray);
}

// create json of it and send back
echo json_encode($FinalData);
?>