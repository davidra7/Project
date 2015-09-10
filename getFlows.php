<?php 
include 'AlgorithmFunction.php';
session_start();
/*
//example call for getTreeOfDelivery function
$url= 'http://testserver-radjybaba.rhcloud.com//webservice-content.php'; // url + file.php

$data = array('hash' => 'DAVIDGALIT', 'deliveryUID' => $_SESSION['ID'], 'method'  => 'getTreeOfDelivery');

$options = array(
	'http' => array(
		'method'  => "POST",
		'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
		'content' => http_build_query($data),
	),
);
$context  = stream_context_create($options);
$result = file_get_contents($url, false, $context);


$JsonConvert = json_decode( $result );
$JsonObject = $JsonConvert->data;
*/
/** STUB */
$dummy = array(
		array(
			'name'=>"d01",
			'type'=>"d",
			'children'=>"k01,k02,k03",
			'parent'=>null
		),
		array(
			'name'=>"k01",
			'type'=>"k",
			'children'=>"d02",
			'parent'=>"d01"
		),
		array(
			'name'=>"k02",
			'type'=>"k",
			'children'=>"d03",
			'parent'=>"d01"
		),
		array(
			'name'=>"k03",
			'type'=>"k",
			'children'=>"d03,d04",
			'parent'=>"d01"
		),
		array(
			'name'=>"k05",
			'type'=>"k",
			'children'=>"d02",
			'parent'=>"d03,d04"
		),
		
		array(
			'name'=>"d02",
			'type'=>"d",
			'children'=>"k06,k07,k08", // null
			'parent'=>"k05,k01"		
		),
		array(
			'name'=>"d03",
			'type'=>"d",
			'children'=>"k05",
			'parent'=>"k03,k02"
		),
		array(
			'name'=>"d04",
			'type'=>"d",
			'children'=>"k05",
			'parent'=>"k03"
		),
		///*
		array(
			'name'=>"k06",
			'type'=>"k",
			'children'=>"d07",
			'parent'=>"d02"
		),
		array(
			'name'=>"k08",
			'type'=>"k",
			'children'=>"d06",
			'parent'=>"d02"
		),
		array(
			'name'=>"k07",
			'type'=>"k",
			'children'=>"d06,d05",
			'parent'=>"d02"
		),
		array(
			'name'=>"d07",
			'type'=>"d",
			'children'=>null,
			'parent'=>"k06"
		),
		array(
			'name'=>"d06",
			'type'=>"d",
			'children'=>null,
			'parent'=>"k08,k07"
		),
		array(
			'name'=>"d05",
			'type'=>"d",
			'children'=>null,
			'parent'=>"k07"
		)
		//*/
);
$dummy2 = json_encode($dummy);
$JsonObject = json_decode($dummy2);

/** STUB **/

//return;
// Allocate array for HelpArray and the Final array that we send
$HelpArray = array();
$FinalFlow = array();
$FinalFlowID = array();
$tree  = null;

$Tree = BuildTreeFromJson($JsonObject, $tree,null,null,$HelpArray);
$temp = CalculateMinPreqs ($Tree);
OrderDeliveriesByPrecedence($Tree ,$temp,$FinalFlow);

echo json_encode($FinalFlow);


?>