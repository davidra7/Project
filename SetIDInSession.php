<?php
session_start();
if(!isset($_SESSION['Username']) ) 
{
	echo "0";
	return;
}
$postdata = file_get_contents("php://input");
$request = json_decode($postdata,true);

$_SESSION['ID'] = $request['id'];
if ( $request['id'] == $_SESSION['ID'])
	echo "1";
else
	echo "0";


?>