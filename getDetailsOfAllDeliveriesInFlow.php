<?php
include 'Params.php'; 
session_start();
	/*
	$postdata = file_get_contents("php://input");
	$request = json_decode($postdata,true);

	$flow = $request['flow'];
	// get the ID from the data
	for ( $i = 0 ; $i < count($flow) ; $i++ )
	{
		$flow[$i] = substr($flow[$i], 1);
	}
	
	// the array that we will send and save our data
	$FinalArray = array();
	for ($i =0 ; $i < count($flow) ; $i++)
	{
		// send request to other server to get details of all deliveries in a flow.
		$url= 'http://testserver-radjybaba.rhcloud.com//webservice-content.php'; // url + file.php
		
		$data = array('hash' => 'DAVIDGALIT', 'deliveryUID' => $flow[$i], 'method'  => 'getDeliveryByUID');

		$options = array(
			'http' => array(
				'method'  => "POST",
				'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
				'content' => http_build_query($data),
			),
		);
		$context  = stream_context_create($options);
		$result = file_get_contents($url, false, $context);
		
		
		$conv_result = json_decode( $result );	
		array_push($FinalArray , $conv_result->data  );
	}
	
	echo json_encode($FinalArray);
	*/
	// Dummy Build
$dummy = array(
		array(
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
		),	
		array(
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
		),
		array(
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
		),
		array(
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
		),
		array(
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
		)
);

$dummy_json = json_encode($dummy);
echo $dummy_json;

?>