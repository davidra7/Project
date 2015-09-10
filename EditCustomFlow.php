<?php 
include 'Params.php';
session_start();

// get parameters from json
$postdata = file_get_contents("php://input");
$request = json_decode($postdata,true);

$idx = $request['index'];
$d2 = $request['data2'];
$type = $request['type'];
$d = $request['data'];
$name = $request['name'];
$user = $_SESSION['Username'];
$connn = new mysqli($servername, $dbuser,"",$dbname);

if ($type == "up")
{
	// set new Index
	$NewIdx = $idx-1;
	// Update the first one
	$sqlCommand = "UPDATE $CustomFlows_Table_Name SET $CustomFlows_Data='$d' WHERE $CustomFlows_Chunk='$NewIdx' AND $CustomFlows_Name='$name' AND $CustomFlows_User_id='$user' ";
	$result = $connn->query($sqlCommand);
	if ( $result == true)
	{
		// Update the second delivery
		$sqlCommandSwap = "UPDATE $CustomFlows_Table_Name SET $CustomFlows_Data='$d2' WHERE $CustomFlows_Chunk='$idx' AND $CustomFlows_Name='$name' AND $CustomFlows_User_id='$user' ";
		$resultSwap = $connn->query($sqlCommandSwap);
		if ( $resultSwap == true)
		{
			echo 1;
		}
		else
		{
			echo 0;
		}
	}
	else
	{
		echo 0;
	}
	
}
else if ( $type == "down")
{
	// set new Index
	$NewIdx = $idx+1;
	// Update the first one
	$sqlCommand = "UPDATE $CustomFlows_Table_Name SET $CustomFlows_Data='$d' WHERE $CustomFlows_Chunk='$NewIdx' AND $CustomFlows_Name='$name' AND $CustomFlows_User_id='$user' ";
	$result = $connn->query($sqlCommand);
	if ( $result == true)
	{
		// Update the second delivery
		$sqlCommandSwap = "UPDATE $CustomFlows_Table_Name SET $CustomFlows_Data='$d2' WHERE $CustomFlows_Chunk='$idx' AND $CustomFlows_Name='$name' AND $CustomFlows_User_id='$user' ";
		$resultSwap = $connn->query($sqlCommandSwap);
		if ( $resultSwap == true)
		{
			echo 1;
		}
		else 
		{
			echo 0;
		}
	}
	else
	{
		echo 0;
	}
}
else if ( $type == "delete")
{
	$NeedToUpdate = $d2 - $idx - 1;
	// delete the row
	$sqlCommand = "DELETE FROM $CustomFlows_Table_Name WHERE $CustomFlows_Chunk='$idx' AND $CustomFlows_Name='$name' AND $CustomFlows_User_id='$user' ";
	$resultSwap = $connn->query($sqlCommand);
	
	for( $i = $idx ; $i < $NeedToUpdate ; $i++)
	{
		$newIndex = $i+1;
		$sqlCommandUpdate = "UPDATE $CustomFlows_Table_Name SET $CustomFlows_Chunk='$i' WHERE $CustomFlows_Chunk='$newIndex' AND $CustomFlows_Name='$name' AND $CustomFlows_User_id='$user' ";
		$resultSwap = $connn->query($sqlCommandUpdate);
	}
	
	echo $resultSwap;

}


$connn->close();

//echo $sqlCommand;

?>