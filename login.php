<?php 
include 'Params.php';
session_start();

$postdata = file_get_contents("php://input");
$request = json_decode($postdata,true);
	
	$u = $request['username'];
	$p = $request['pass'];
	if ( $u == null || $p == null)
	{
		echo "0";
		return;
	}
	$sql = "SELECT * FROM Users WHERE Username='$u' AND Password='$p'";

	// Create connection
	$conn = new mysqli($servername, $dbuser,"",$dbname);
	$result = $conn->query($sql);
	if ($result && $result->num_rows > 0)
	{
		$_SESSION["CREATED"] = time();
		$_SESSION["Username"] = $u;
			
		echo "1";
	}
	else
	{
		$_SESSION["CREATED"] = null	;
		$_SESSION["Username"] = null;
		echo "0";
	}
	
	$conn->close();
	

?>