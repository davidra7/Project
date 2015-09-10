<?php 
/*
// get parameters from json
$postdata = file_get_contents("php://input");
$request = json_decode($postdata,true);


$method = 'search';
 $url= 'http://testserver-radjybaba.rhcloud.com/webservice-content.php'; 
 //$query = '{"searchtext":"title","elements":{"delivery":"false","d2k":"false","term":"false","scope":"true"},"field":{"title":"true","info":"false"}}';
 $query = $request;
$data = array('hash' => 'DAVIDGALIT', 'query' => $query, 'withContent' => false, 'method'  => $method);
 $options = array(
     'http' => array(
         'method'  => "POST",
         'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
         'content' => http_build_query($data),
     ),
 );
 $context  = stream_context_create($options);
 $result = file_get_contents($url, false, $context);
 
 echo $result;
 */
 
 /**** STUB ***/
 $str = "{\"code\":1,\"status\":200,\"data\":{\"DELIVERIES\":[{\"UID\":\"149\",\"TITLE\":\"Delivery title 1\",\"DESCRIPTION\":\"Delivery description 1\"}]}}";
 print_r( $str);
/**** END STUB **/
?>