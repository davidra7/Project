<?php 
include 'Params.php';

//checkSession();

//TBD
$connn = new mysqli($servername, $dbuser,"",$dbname);
// get number of flows of the current User
$sqlSelect = " SELECT  DISTINCT $PublicFlows_Table_Name.$PublicFlows_Flow_id , $PublicFlows_Table_Name.$PublicFlows_User_id , $CustomFlows_Table_Name.$CustomFlows_Name FROM $PublicFlows_Table_Name,$CustomFlows_Table_Name Where $PublicFlows_Table_Name.$PublicFlows_Flow_id=$CustomFlows_Table_Name.$CustomFlows_Flow_id AND $PublicFlows_Table_Name.$PublicFlows_User_id=$CustomFlows_Table_Name.$CustomFlows_User_id AND $PublicFlows_Table_Name.$PublicFlows_Data='1' ORDER BY $PublicFlows_Table_Name.$PublicFlows_Flow_id ASC ";
$result = $connn->query($sqlSelect);
// extract from the result to array.
$rows = array();
while ($row = mysqli_fetch_array($result)) {
	$rows[] = array( $PublicFlows_User_id=>$row[$PublicFlows_User_id],$PublicFlows_Flow_id=>$row[$PublicFlows_Flow_id],$CustomFlows_Name=>$row[$CustomFlows_Name]);;
}
$FinalArray = array();

// Go over each row and extract flow 
for ( $i =0 ; $i < count($rows) ; $i++)
{
	$f = $rows[$i][$CustomFlows_Flow_id];
	$u = $rows[$i][$CustomFlows_User_id];
	$sqlSelect = " SELECT  $CustomFlows_Data  FROM $CustomFlows_Table_Name Where $CustomFlows_Flow_id = '$f' AND $CustomFlows_User_id='$u'  ";
	$res = $connn->query($sqlSelect);
	$flows = array();
	while ($flow = mysqli_fetch_array($res)) {
		$flows[] = $flow[$CustomFlows_Data];
	}
	array_push($FinalArray, array($PublicFlows_User_id=>$u, $CustomFlows_Name=>$rows[$i][$CustomFlows_Name] ,"flow"=>$flows ));
	
	
}
echo json_encode($FinalArray);
?>