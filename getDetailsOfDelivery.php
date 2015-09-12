<?php 
include 'Params.php';
session_start();

// test
//$_SESSION['Delivery'] = "d02";

if( !isset($_SESSION['Delivery']))
{
	echo "Failed";
	return;
}

$delivey_name = $_SESSION['Delivery'];
if($delivey_name == "d01")
{
	$dummy = array(
			'name'=>"d01",
			'type'=>"d",
			'description'=>'d01_description',
			'url'=>'http://www.youtube.com/embed/f-aBSV-rVXM',
			'kbits_needed'=>"k01,k02,k03",
			'kbits_provided'=>"k04,k07",
			'deliveries_related'=>"d02,d03",
			'terms'=>"t01,t02,t03",
			'scope'=>"s01,s02",
			'parent'=>null
			
		);
}
else if($delivey_name == "d02")
{
	$dummy = array(
			'name'=>"d02",
			'type'=>"d",
			'description'=>'d02_description',
			'url'=>'http://www.youtube.com/embed/UmfFqhXrN3M',
			'kbits_needed'=>"k01,k02,k03",
			'kbits_provided'=>"k04,k07",
			'deliveries_related'=>"d02,d03,d07",
			'terms'=>"t01,t02,t03",
			'scope'=>"s01,s02",
			'parent'=>null

	);
}
else if($delivey_name == "d03")
{
	$dummy = array(
		'name'=>"d03",
		'type'=>"d",
		'description'=>'d03_description',
		'url'=>'http://www.youtube.com/embed/1TMSF9-4pEE',
		'kbits_needed'=>"k01,k02,k03",
		'kbits_provided'=>"k04,k07",
		'deliveries_related'=>"d02,d03,d04,d07",
		'terms'=>"t01,t02,t03",
		'scope'=>"s01,s02",
		'parent'=>null
			
	);
}
else if($delivey_name == "d04")
{
	$dummy = array(
			'name'=>"d04",
			'type'=>"d",
			'description'=>'d04_description',
			'url'=>'http://www.youtube.com/embed/f-aBSV-rVXM',
			'kbits_needed'=>"k01,k02,k03",
			'kbits_provided'=>"k04,k07",
			'deliveries_related'=>"d06,d03",
			'terms'=>"t01,t02,t03",
			'scope'=>"s01,s02",
			'parent'=>null
			
	);
}
else if($delivey_name == "d05")
{
	$dummy = array(
			'name'=>"d05",
			'type'=>"d",
			'description'=>'d05_description',
			'url'=>'http://www.youtube.com/embed/f-aBSV-rVXM',
			'kbits_needed'=>"k01,k02,k03",
			'kbits_provided'=>"k04,k07",
			'deliveries_related'=>"d07,d01",
			'terms'=>"t01,t02,t03",
			'scope'=>"s01,s02",
			'parent'=>null
			
	);
}
else if($delivey_name == "d06")
{
	$dummy = array(
		'name'=>"d06",
		'type'=>"d",
		'description'=>'d06_description',
		'url'=>'http://www.youtube.com/embed/21w79pFWoRI',
		'kbits_needed'=>"k01,k02,k03,k04",
		'kbits_provided'=>"k07",
		'deliveries_related'=>"d02,d03",
		'terms'=>"t02,t03",
		'scope'=>"s01,s02",
		'parent'=>null
			
	);
}
else if($delivey_name == "d07")
{
	// Dummy Build
	$dummy = array(
		'name'=>"d07",
		'type'=>"d",
		'description'=>'d07_description',
		'url'=>'http://www.youtube.com/embed/Ys3hDAdJBcc',
		'kbits_needed'=>"k01,k03",
		'kbits_provided'=>"k04,k07,k02",
		'deliveries_related'=>"d02,d03",
		'terms'=>"t01,t03",
		'scope'=>"s01",
		'parent'=>null
			
	);
}


$dummy_json = json_encode($dummy);
echo $dummy_json;
// END Dummy build

?>