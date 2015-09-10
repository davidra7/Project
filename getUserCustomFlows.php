<?php 
include 'Params.php';
session_start();
// Set current User
$currentUser = $_SESSION['Username'];
//$currentUser = "david";

//TBD
$connn = new mysqli($servername, $dbuser,"",$dbname);
// get number of flows of the current User
$sqlSelectNumberOfUsersFlows = " SELECT DISTINCT ". $CustomFlows_Name." FROM ". $CustomFlows_Table_Name ." Where ".$CustomFlows_User_id."='".$currentUser."'";
$result = $connn->query($sqlSelectNumberOfUsersFlows);
// $arr place 0 is number of the last FlowID of the current user
$rows = array();
while ($row = mysqli_fetch_array($result)) {
	$rows[] = $row[0];
}
// create json of it and send back
echo json_encode($rows);
?>