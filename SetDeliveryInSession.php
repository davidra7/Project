<?php
session_start();
if(!isset($_SESSION['Username']) ) 
{
	echo "0";
	return;
}
$postdata = file_get_contents("php://input");
$request = json_decode($postdata,true);

$_SESSION['Delivery'] = $request['d'];

if ( $request['d'] == $_SESSION['Delivery'])
	echo "1";
else
	echo "0";


?>