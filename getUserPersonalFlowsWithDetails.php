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
$sqlSelectNumberOfUsersFlows = " SELECT DISTINCT  $SavedFlow_Name,$SavedFlows_Flow_id FROM ". $SavedFlows_Table_Name ." Where ".$SavedFlows_User_id."='".$currentUser."'";
$result = $connn->query($sqlSelectNumberOfUsersFlows);
// $arr place 0 is number of the last FlowID of the current user
$rows = array();
while ($row = mysqli_fetch_array($result)) {
	$rows[] = array( $SavedFlows_Flow_id=>$row[$SavedFlows_Flow_id],$SavedFlow_Name=>$row[$SavedFlow_Name]);
}

// for each name bring all the data
for ($i = 0; $i < count($rows) ; $i++)
{
	$tempArray = array();
	$sqlSelectNumberOfUsersFlows = " SELECT ". $SavedFlows_Data." FROM ". $SavedFlows_Table_Name ." Where ".$SavedFlows_User_id."='".$currentUser."' AND $SavedFlow_Name='" . $rows[$i][$SavedFlow_Name] . "' ORDER BY $CustomFlows_Chunk ASC ";
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