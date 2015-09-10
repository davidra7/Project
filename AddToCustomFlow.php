<?php include 'Params.php';
session_start();
// get parameters from json
$postdata = file_get_contents("php://input");
$request = json_decode($postdata,true);

$Delivery = $request['delivery'];
//$Delivery = "d02";
$FlowName = $request['flowname'];
//$FlowName = "test22";
$currentUser = $_SESSION['Username'];
//$currentUser ="da";


$connn = new mysqli($servername, $dbuser,"",$dbname);


// get the last chunk number
$sqlSelect = "SELECT $CustomFlows_Data FROM $CustomFlows_Table_Name WHERE $CustomFlows_User_id='$currentUser' AND $CustomFlows_Name='$FlowName' AND $CustomFlows_Data='$Delivery'";

$result = $connn->query($sqlSelect);

if( $result->num_rows > 0)
{
	echo "Exist";
	$connn->close();
	return;
}
// get the last chunk number
$sqlSelect = "SELECT $CustomFlows_Chunk FROM $CustomFlows_Table_Name WHERE $CustomFlows_User_id='$currentUser' AND $CustomFlows_Name='$FlowName' ORDER BY $CustomFlows_Chunk DESC";

$result = $connn->query($sqlSelect);
// $arr place 0 is number of the last FlowID of the current user

$row = mysqli_fetch_array($result);



$chunkNumber=$row[$CustomFlows_Chunk];
if ($chunkNumber == null)
	$chunkNumber = 0;
else 
	$chunkNumber++;


// get the FLOW ID
$sqlSelect = "SELECT $CustomFlows_Flow_id FROM $CustomFlows_Table_Name WHERE $CustomFlows_User_id='$currentUser' AND $CustomFlows_Name='$FlowName'";

$result = $connn->query($sqlSelect);
// $arr place 0 is number of the last FlowID of the current user
$row = mysqli_fetch_array($result);

$flowID = $row[$CustomFlows_Flow_id];

// if flowID is null it is not exist -> find the last number of the flow
if ($flowID == null)
{
	// get the FLOW ID
	$sqlSelect = "SELECT DISTINCT $CustomFlows_Flow_id FROM $CustomFlows_Table_Name WHERE $CustomFlows_User_id='$currentUser' ORDER BY $CustomFlows_Flow_id DESC";
	$result = $connn->query($sqlSelect);
	$row = mysqli_fetch_array($result);
	
	$flowID = $row[$CustomFlows_Flow_id];
	if( null == $flowID)
	{
		$flowID = 0;
	}
	else
	{
		$flowID++;
	}
}

$sqlCommand = "INSERT INTO $CustomFlows_Table_Name ($CustomFlows_User_id,$CustomFlows_Flow_id,$CustomFlows_Data,$CustomFlows_Chunk,$CustomFlows_Name) VALUES('$currentUser','$flowID','$Delivery','$chunkNumber','$FlowName')";


if ( $connn->query($sqlCommand) )
{
	echo "Added";
	$connn->close();
}
else
{
	echo "Failed";
	$connn->close();
}



?>