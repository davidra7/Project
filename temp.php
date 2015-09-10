<?php 
include 'AlgorithmFunction.php';
session_start();
// get data from the client

	//example call for getTreeOfDelivery function
	$url= 'http://testserver-radjybaba.rhcloud.com//webservice-content.php'; // url + file.php
	
	$data = array('hash' => 'DAVIDGALIT', 'deliveryUID' => "149", 'method'  => 'getTreeOfDelivery');

	$options = array(
	    'http' => array(
	        'method'  => "POST",
	        'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
	        'content' => http_build_query($data),
	    ),
	);
	$context  = stream_context_create($options);
	$result = file_get_contents($url, false, $context);
	

//print_r($result);

$JsonConvert = json_decode( $result );
$JsonObject = $JsonConvert->data;


// Allocate array for HelpArray and the Final array that we send
$HelpArray = array();
$FinalFlow = array();
$tree  = null;

$Tree = BuildTreeFromJson($JsonObject, $tree,null,null,$HelpArray);
$temp = CalculateMinPreqs ($Tree);
OrderDeliveriesByPrecedence($Tree ,$temp,$FinalFlow);

echo json_encode($FinalFlow);


?>