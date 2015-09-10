
 <?php
include 'Params.php';
echo " ---------- Create Connection ------------";
// Create connection
$conn = new mysqli($servername, $dbuser);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 
echo "<br>---------- Create DB -------------<br>";
//check if db exists
if ($conn->select_db($dbname) === false) {
	//if not - create new db
	$sql = "CREATE DATABASE IF NOT EXISTS ". $dbname;
	if ($conn->query($sql) === TRUE) {
	    echo "Database created successfully";
	} else {
	    echo "Error creating database: " . $conn->error;
	} 	
}
else echo "Database already exists.";


echo "<br><br> ---------- Create Users Table -------------<br>";
// sql to create table
$user_table_create = "CREATE TABLE ".$Users_Table_Name." ("
.$Users_Username." VARCHAR(30) NOT NULL UNIQUE PRIMARY KEY,
".$Users_Password." VARCHAR(30) NOT NULL,
".$Users_Email." VARCHAR(50) UNIQUE,
".$Users_Reg_date." TIMESTAMP DEFAULT CURRENT_TIMESTAMP )";

if ($conn->query($user_table_create) === TRUE) {
	echo "Table Users created successfully";
} else {
	echo "Error creating table: " . $conn->error;
}


echo "<br><br> ----------Table UserKbits-------------";
// sql to create table
$userkbits_table_create = "CREATE TABLE ". $UserKbits_Table_Name . " (".
						   $UserKbits_Kbitname . " VARCHAR(30) NOT NULL, ".
						   $UserKbits_Username . " VARCHAR(30) NOT NULL, ".
						   $UserKbits_Status . " CHAR(1) NOT NULL, ".
						   "CONSTRAINT ".$UserKbits_pk." PRIMARY KEY (" . $UserKbits_Kbitname .",". $UserKbits_Username."))";

echo "<br>";
if ($conn->query($userkbits_table_create) === TRUE) {
	echo "Table UserKbit created successfully";
} else {
	echo "Error creating table: " . $conn->error;
}


echo "<br><br> ----------Table PersonalComment -------------";
// sql to create table
$personalcomment_table_create = "CREATE TABLE ". $PersonalComments_Table_Name ." ("
. $PersonalComments_Username . " VARCHAR(30) NOT NULL,
" . $PersonalComments_Delivery_name  . " VARCHAR(30) NOT NULL,
" . $PersonalComments_Comment . " VARCHAR(".$PersonalComments_Comment_Size.") NOT NULL, 
" . $PersonalComments_Status . " CHAR(1) NOT NULL, ".
" CONSTRAINT ".$PersonalComments_pk." PRIMARY KEY (" .$PersonalComments_Delivery_name.",".$PersonalComments_Username. "))";

echo "<br>";
if ($conn->query($personalcomment_table_create) === TRUE) {
	echo "Table PersonalCommentTable created successfully";
} else {
	echo "Error creating table: " . $conn->error;
}

 echo "<br><br> ----------Personal Flows -------------";
// // sql to create table
 $flow_table_create = "CREATE TABLE ". $SavedFlows_Table_Name ." ("
 . $SavedFlows_ID . " INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
 " . $SavedFlows_User_id . " VARCHAR(30) NOT NULL,
 " . $SavedFlows_Flow_id  . " INT NOT NULL,
 " . $SavedFlow_Name ." VARCHAR(100) NOT NULL,
 " . $SavedFlows_Data . " VARCHAR(".$SavedFlows_MaxSizeForData."),
 " . $SavedFlows_Chunk . " INT)";


 echo "<br>";
 if ($conn->query($flow_table_create) === TRUE) {
 	echo "Table $SavedFlows_Table_Name created successfully";
 } else {
 	echo "Error creating table: " . $conn->error;
 }


echo "<br><br> ----------Table Custom Flows -------------";
// sql to create table
 $flow_table_create = "CREATE TABLE $CustomFlows_Table_Name  (
	$CustomFlows_ID  INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  	$CustomFlows_User_id  VARCHAR(30) NOT NULL,
  	$CustomFlows_Flow_id   INT NOT NULL,
  	$CustomFlows_Name  VARCHAR(30) NOT NULL,
 	$CustomFlows_Data  VARCHAR($CustomFlows_MaxSizeForData),
 	$CustomFlows_Chunk  INT )";


 echo "<br>";
 if ($conn->query($flow_table_create) === TRUE) {
 	echo "Table $CustomFlows_Table_Name created successfully";
 } else {
 	echo "Error creating table: " . $conn->error;
 }

 echo "<br><br> ----------Table Wishlist Flows -------------";
 // sql to create table
 $flow_table_create = "CREATE TABLE ". $Wishlist_Table_Name ." ("
 		. $Wishlist_ID . " INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
 " . $Wishlist_User_id . " VARCHAR(30) NOT NULL,
 " . $Wishlist_Flow_id  . " INT NOT NULL,
 " . $Wishlist_Name . " VARCHAR(30) NOT NULL,
 " . $Wishlist_Data . " VARCHAR(".$Wishlist_MaxSizeForData."),
 " . $Wishlist_Chunk . " INT )";
 
 
 echo "<br>";
 if ($conn->query($flow_table_create) === TRUE) {
 	echo "Table $Wishlist_Table_Name created successfully";
 } else {
 	echo "Error creating table: " . $conn->error;
 }
 

echo "<br><br> ----------Public Flows -------------";
// sql to create table
 $flow_table_create = "CREATE TABLE $PublicFlows_Table_Name  (
  	$PublicFlows_Flow_id   INT NOT NULL,
  	$PublicFlows_User_id VARCHAR(30) NOT NULL,
 	$PublicFlows_Data  VARCHAR(5) NOT NULL,
 	$PublicFlows_Type VARCHAR(13) NoT NULL,
 	CONSTRAINT pk PRIMARY KEY($PublicFlows_Flow_id,$PublicFlows_User_id)
 	)";

 
echo "<br>";
if ($conn->query($flow_table_create) === TRUE) {
	echo "Table $PublicFlows_Table_Name created successfully";
} else {
	echo "Error creating table: " . $conn->error;
}

$conn->close();
?>
