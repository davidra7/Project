<?php 
include 'Params.php';
session_start();

// get parameters from json
$postdata = file_get_contents("php://input");
$request = json_decode($postdata,true);

$flowid =  $request['id'];
//$flowid = 1;
$flag = $request['f'];
//$flag = 0;
$type = $request['t'];
//$type = 1;
$user = $_SESSION['Username'];
//$user = "d";

if( $flowid == null  || $type == null || $user == null  )
{
	echo 0;
	return;
}
if($flag == null)
	$flag = 0;
$connn = new mysqli($servername, $dbuser,"",$dbname);

$sqlCommand = "INSERT INTO $PublicFlows_Table_Name ($PublicFlows_Flow_id,$PublicFlows_User_id,$PublicFlows_Data,$PublicFlows_Type) VALUES('$flowid','$user','$flag','$type')";
$result = $connn->query($sqlCommand);
// if we cannot add it -> it exist 
if ( false == $result )
{
	$sqlCommand = "UPDATE $PublicFlows_Table_Name SET $PublicFlows_Data=$flag WHERE $PublicFlows_Flow_id='$flowid' AND $PublicFlows_User_id='$user' AND $PublicFlows_Type='$type' ";
	$result = $connn->query($sqlCommand);
}
$connn->close();
echo $result;
?>