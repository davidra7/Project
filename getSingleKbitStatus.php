<?php
include 'Params.php';

session_start();

// get parameters from json
$postdata = file_get_contents("php://input");
$request = json_decode($postdata);

$kbit_name = $request->kbit_name;

//////////////////////////// TODO GALIT - remove duplications!!!!!!! //////////////////////////////

$username = $_SESSION['Username'];

$sql = "SELECT " . $UserKbits_Kbitname . "," . $UserKbits_Status .
  		" FROM " . $UserKbits_Table_Name .
  		" WHERE " . $UserKbits_Username . "='" . $username . "'" .
  		" AND "  . $UserKbits_Kbitname . "='" . $kbit_name . "'";
 
// Create connection
  $conn = new mysqli($servername, $dbuser,"",$dbname);
  $result = $conn->query($sql);

 if ($result && $result->num_rows)
 {
 	echo json_encode($result->fetch_assoc());
 }
 else
 {
 	echo $sql;
 }
  

?>

