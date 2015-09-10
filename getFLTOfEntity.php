<?php 
include 'Params.php';
session_start();

// send request to other server to get details of 1 delivery


// get parameters from json
$postdata = file_get_contents("php://input");
$request = json_decode($postdata);

$entity_name = $request->entity_name;

if($entity_name == "k01")
{
	$dummy = array(
			array(
			'name'=>"k01",
			'type'=>"k",
			'kbits_related'=>"k02,k03",
			'deliveries_related'=>"d01,d04",
			'terms'=>"t01",
			'scope'=>"s01,s02",
			)
		);
}
else if($entity_name == "k02")
{
	$dummy = array(
			array(
			'name'=>"k02",
			'type'=>"k",
			'kbits_related'=>"k01,k03",
			'deliveries_related'=>"d02,d03",
			'terms'=>"t02",
			'scope'=>"s03,s02",
			)
	);
}
else if($entity_name == "k03")
{
	$dummy = array(
			array(
			'name'=>"k03",
			'type'=>"k",
			'kbits_related'=>"k02",
			'deliveries_related'=>"d04,d07",
			'terms'=>"t01",
			'scope'=>"s04",
			)
	);
}
else if($entity_name == "s01")
{
	$dummy = array(
			array(
			'name'=>"s01",
			'type'=>"k",
			'kbits_related'=>"k02",
			'deliveries_related'=>"d04,d07",
			'terms'=>"t01",
			'scope'=>"s04",
			)
	);
}
else if($entity_name == "s02")
{
	$dummy = array(
			array(
			'name'=>"s02",
			'type'=>"s",
			'kbits_related'=>"k02, k01",
			'deliveries_related'=>"d03",
			'terms'=>"t01,t02",
			'scope'=>"s04",
			)
	);
}
else if($entity_name == "t01")
{
	$dummy = array(
			array(
			'name'=>"t01",
			'type'=>"t",
			'kbits_related'=>"k02, k03",
			'deliveries_related'=>"d02, d04",
			'terms'=>"t02,t03",
			'scope'=>"s01",
			)
	);
}
else if($entity_name == "t02")
{
	$dummy = array(
			array(
			'name'=>"t02",
			'type'=>"t",
			'kbits_related'=>"k01",
			'deliveries_related'=>"d01, d03",
			'terms'=>"t01",
			'scope'=>"s01, s02",
			)
	);
}




$dummy_json = json_encode($dummy);
echo $dummy_json;
// END Dummy build

?>