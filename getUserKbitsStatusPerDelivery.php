<?php
include 'Params.php';

session_start();

// get parameters from json
$postdata = file_get_contents("php://input");
$request = json_decode($postdata);



$kbits_needed = $request->kbits_needed;
$kbits_provided = $request->kbits_provided;

$kbits_array = [];
$i=0;


//insert to $kbits_array the kbits_needed
for($i=0; $i<count($request->kbits_needed); $i++)
{
	array_push($kbits_array, $request->kbits_needed[$i]->name);
}
//insert to $kbits_array the kbits_provided
for($i=0; $i<count($request->kbits_provided); $i++)
{
	array_push($kbits_array, $request->kbits_provided[$i]->name);
}
//////////////////////////// TODO GALIT - remove duplications!!!!!!! //////////////////////////////


$username = $_SESSION['Username'];
$where_kbits_statement = " (";

for ($i=0; $i<count($kbits_array)-1; $i++)
{
	$where_kbits_statement = $where_kbits_statement . $UserKbits_Kbitname . "='" . $kbits_array[$i] . "' OR ";
}

$where_kbits_statement = $where_kbits_statement . $UserKbits_Kbitname . "='" . $kbits_array[$i] . "') ";




$sql = "SELECT " . $UserKbits_Kbitname . "," . $UserKbits_Status .
  		" FROM " . $UserKbits_Table_Name .
  		" WHERE " . $UserKbits_Username . "='" . $username . "'" .
  		" AND "  .  $where_kbits_statement;
 
// Create connection
  $conn = new mysqli($servername, $dbuser,"",$dbname);
  $result = $conn->query($sql);

  $results_array=[];
 if ($result && $result->num_rows)
 {
 	while($row = $result->fetch_assoc())
 	{
 		array_push($results_array, $row);
 	}
 }
  
//if we already have a user comment in the db, return it
// if ($result && $result->num_rows > 0){
// 	echo $result->fetch_assoc()["Comment"];
// }
// else
// {
// 	//echo "No user comments in db. You can add/edit comments for this delivery right here.";
// 	echo "No comments registered. \nYou can add/edit your comments right here..";
// }
 echo json_encode($results_array);


$kbits_array2 = array(
		array(
				'name'=>"k01",
				'status'=>"x"
		),
		array(
				'name'=>"k02",
				'status'=>"x"
		),
		array(
				'name'=>"k03",
				'status'=>"q"
		),
);


// echo json_encode($kbits_array2);



?>

