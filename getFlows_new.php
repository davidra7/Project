<?php 
//include 'AlgorithmFunction.php';
//session_start();
// send request to other server to get dependency tree
//$request = array ( "deliveryid" => $_SESSION['ID']);

 $url= 'http://testserver-radjybaba.rhcloud.com/test-delivery.php'; 
 //$query = json_encode($request);
 $query = "1213";
 $data = array('hash' => 'DAVIDGALIT', 'query' => $query, 'method'  => 'getdelivery' );
 $options = array(
     'http' => array(
         'method'  => "POST",
         'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
         'content' => http_build_query($data)
     )
 );
 $context  = stream_context_create($options);
 $result = file_get_contents($url, false, $context);

// get the json and parse him into objects
$JsonObject = json_decode($result);
print_r( $JsonObject);

// Allocate array for HelpArray and the Final array that we send
$HelpArray = array();
$FinalFlow = array();
$tree  = null;

//$Tree = BuildTreeFromJson($JsonObject, $tree,null,null,$HelpArray);
//$temp = CalculateMinPreqs ($Tree );
//OrderDeliveriesByPrecedence($Tree ,$temp,$FinalFlow);

//echo json_encode($FinalFlow);


?>