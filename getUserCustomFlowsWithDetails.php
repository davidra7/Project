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
$sqlSelectNumberOfUsersFlows = " SELECT DISTINCT  $CustomFlows_Name,$CustomFlows_Flow_id FROM ". $CustomFlows_Table_Name ." Where ".$CustomFlows_User_id."='".$currentUser."'";
$result = $connn->query($sqlSelectNumberOfUsersFlows);
// $arr place 0 is number of the last FlowID of the current user
$rows = array();
while ($row = mysqli_fetch_array($result)) {
	$rows[] = array( $CustomFlows_Flow_id=>$row[$CustomFlows_Flow_id],$CustomFlows_Name=>$row[$CustomFlows_Name], "Public"=>"0");
}

// check if the flow is public or not
$sqlSelectNumberOfUsersFlows = " SELECT $PublicFlows_Data,$PublicFlows_Flow_id FROM $PublicFlows_Table_Name Where $PublicFlows_User_id='$currentUser'";
$resultPublic = $connn->query($sqlSelectNumberOfUsersFlows);
$public = array();
while ($pub = mysqli_fetch_array($resultPublic)) {
	$public[] = array( $PublicFlows_Flow_id=>$pub[$PublicFlows_Flow_id],$PublicFlows_Data=>$pub[$PublicFlows_Data]);
}
// end

// for each name bring all the data
for ($i = 0; $i < count($rows) ; $i++)
{
	$PublicFlag = false;
	$tempArray = array();
	$sqlSelectNumberOfUsersFlows = " SELECT ". $CustomFlows_Data." FROM ". $CustomFlows_Table_Name ." Where ".$CustomFlows_User_id."='".$currentUser."' AND $CustomFlows_Name='" . $rows[$i][$CustomFlows_Name] . "' ORDER BY $CustomFlows_Chunk ASC ";
	$result = $connn->query($sqlSelectNumberOfUsersFlows);
	while ($row = mysqli_fetch_array($result)) {
		 array_push($tempArray, $row[$CustomFlows_Data]);
	}
	// search the flow if in the Public Flows
	for ( $j =0 ; $j < count($public) ; $j++)
	{
		if( $rows[$i][$CustomFlows_Flow_id] == $public[$j][$PublicFlows_Flow_id] && $public[$j][$PublicFlows_Data] == true )
		{
			$PublicFlag = true;
			break;
		}
		
	}
	// end search
	$rows[$i]["Public"] =  $PublicFlag;
	array_push( $FinalData , $rows[$i]);
	array_push( $FinalData , $tempArray);
}

$connn->close();
// create json of it and send back
echo json_encode($FinalData);
?>