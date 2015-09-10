<?php 

$servername = "localhost";
$dbuser = "galit";
$dbname = "intel_uni_db";
$RESULT_OK = 0;

$Users_Table_Name = "Users";
$Users_Username = "Username";
$Users_Password  = "Password";
$Users_Email = "Email";
$Users_Reg_date = "Reg_date";


$UserKbits_Table_Name = "UsersKbits";
$UserKbits_Username = "Username";
$UserKbits_Kbitname  = "Kbitname";
$UserKbits_Status = "Status";
$UserKbits_pk = "pk_kbit_user";

// $PersonalComments_Table_Name = "PersonalComments";
// $PersonalComments_Username = "Username";
// $PersonalComments_Delivery_name = "Delivery_name";
// $PersonalComments_Comment = "Comment";
// $PersonalComments_Comment_Size = 1000;
// $PersonalComments_pk = "pk_delivry_user";

$PersonalComments_Table_Name = "UserDetailsPerDelivery";
$PersonalComments_Username = "Username";
$PersonalComments_Delivery_name = "Delivery_name";
$PersonalComments_Comment = "Comment";
$PersonalComments_Comment_Size = 1000;
$PersonalComments_Status = "Status";
$PersonalComments_pk = "pk_delivry_user";

 $SavedFlows_Table_Name = "SavedFlows";
 $SavedFlows_ID = "id";
 $SavedFlows_User_id = "User_id";
 $SavedFlows_Flow_id  = "Flow_id";
 $SavedFlows_Data = "Data";
 $SavedFlows_Chunk = "Chunk";
 $SavedFlows_MaxSizeForData = 1000;
 $SavedFlow_Name = "Name";

 $CustomFlows_Table_Name = "CustomFlows";
 $CustomFlows_ID = "id";
 $CustomFlows_User_id = "User_id";
 $CustomFlows_Flow_id  = "Flow_id";
 $CustomFlows_Data = "Data";
 $CustomFlows_Chunk = "Chunk";
 $CustomFlows_MaxSizeForData = 1000;
 $CustomFlows_Name = "Name";


// whishlist
 $Wishlist_Table_Name = "WishlistFlows";
 $Wishlist_ID = "id";
 $Wishlist_User_id = "User_id";
 $Wishlist_Flow_id  = "Flow_id";
 $Wishlist_Data = "Data";
 $Wishlist_Chunk = "Chunk";
 $Wishlist_MaxSizeForData = 1000;
 $Wishlist_Name = "Name";
 
 // Public Flow
 $PublicFlows_Table_Name = "PublicFlows";
 $PublicFlows_ID = "id"; // 
 $PublicFlows_Flow_id  = "Flow_id"; // flow ID in the type
 $PublicFlows_Data = "Data"; //  1- public 0-not
 $PublicFlows_Type = "Type"; // flow type- custom , personal , whishlist
 $PublicFlows_User_id = "User_id";
 

function checkSession()
{
	session_start();
	if (!isset( $_SESSION['Username']) )
	{
		header('Location: index.php');
	}
}




?>
