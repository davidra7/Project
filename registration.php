<?php 
include 'Params.php';

	session_start();

	$postdata = file_get_contents("php://input");
	$request = json_decode($postdata,true);
	
	
	if ( isset($request['username']) )
	{
		$u = $request['username'];
	}
	else {
		$u = null;
	}
	
	
	if ( isset($request['pass']) )
	{
		$p = $request['pass'];
	}
	else {
		$p = null;
	}
	
	if ( isset($request['email']) )
	{
		$email = $request['email'];
	}
	else {
		$email = null;
	}
	if( $p == null || $u == null|| $email == null)
	{
		echo 0;
		return;
	}
	$sql = "INSERT INTO $Users_Table_Name ($Users_Username,$Users_Password,$Users_Email) VALUES('$u','$p','$email')";

	// Create connection
	$conn = new mysqli($servername, $dbuser,"",$dbname);

	if ( $conn->query($sql) )
	{
		$_SESSION["CREATED"] = time();
		$_SESSION["Username"] = $u;
		//header('Location: search.php');
		echo 1;
	}
	else
	{
		$_SESSION["CREATED"] = null	;
		$_SESSION["Username"] = null;
		echo 0;
	}
	$conn->close();
	return;	

?>
