<?php 
include 'Params.php';
class Node
{
	public  	$name;
	public 	$children;
	public 	$parents;
	
	public function __construct($item)
	{
		$this->name = $item;
		$this->children = array();
		$this->parents = array();
	}
	
	public function add_child( &$item)
	{
		$NumberOfChildren = count($this->children);
		$flag = true;
		
		for ( $i =0 ; $i < $NumberOfChildren ; $i++ )
		{
			if ($this->children[$i]->name == $item->name ) // found the child already
				$flag = false;
		}
		
		if ( $flag)
		{
			array_push( $this->children , $item);// add
			$item->add_parent( $this);
		}
	}
	
	private function add_parent( &$node )
	{
		$NumberOfParents = count($this->parents);
		$flag = true;
		
		for ( $i =0 ; $i < $NumberOfParents ; $i++ )
		{
			if ($this->parents[$i]->name == $node->name ) // found the child already
				$flag = false;
		}
		
		if ( $flag )
			array_push( $this->parents , $node);// add
	}
	

	
}
/*
 * Parameters: FindID  - name/ID of the node that we want to find.
 * return value: reference to the node
 */
function &FindNode(&$tree , $FindID)
{

	if( $FindID == $tree->name )
		return $tree;
	
	for ( $i =0 ; $i < count( $tree->children) ; $i++)
	{
		$returnValue = &FindNode( $tree->children[$i] , $FindID); 
		if ($returnValue != null  && $returnValue->name == $FindID )
			return $returnValue;
	}
	return $tree;
	//return null;
}

/*
 * Parameters:
 * HelpArray - an array that we save references to objects that we created and don't want to create again
 * CheckNode - the node that we will search in the help array.
 *
 * we will check if the CheckNode is in HelpArray
 * 	if yes - return
 * 	if no - add it
 */
function CheckIfItExistOrAddHelpArray(&$HelpArray, &$CheckNode)
{
	$NumberOfItem = count($HelpArray);
	for ( $i =0 ; $i < 	$NumberOfItem ; $i++)
	{
		if ($HelpArray[$i] == $CheckNode)
			return;
	}
	$HelpArray[ $NumberOfItem ] = $CheckNode;
}
/*
 * Parameters:
 * HelpArray - an array that we save references to objects that we created and don't want to create again
 * CheckNode - the node that we will search in the help array.
 * return the index if exist
 * return  -1 if don't exist
 */
function CheckIfExist( &$HelpArray, $CheckName)
{
	$NumberOfItem = count ($HelpArray);
	for ( $i =0 ; $i < $NumberOfItem ; $i++)
	{
	if ($HelpArray[$i]->name == $CheckName)
		return $i;
	}
	return -1;
}


// send request to other server to get dependency tree


// END


function BuildTreeFromJson(&$JsonObject ,$tree, $FindID, $ParentID, &$HelpArray  )
{
	$temptree = null;
	if ( $tree != null)
	{
		$temptree = &FindNode( $tree, $FindID);
	}
	if ( $tree == null)
	{
		$tree = new Node($JsonObject[0]->name);
		$children = explode (",",$JsonObject[0]->children); // split by ,
		for ( $k =0 ; $k < count($children) ; $k++)
		{
			$temp = new Node($children[$k]);
			// add each child as a node
			$tree->add_child( $temp );
			// handle with the tree
			BuildTreeFromJson($JsonObject , $tree , $children[$k] , $tree->name , $HelpArray );
		}
		return $tree;
	}
	else
	{
		// search the object in the array JsonObject
		for ( $k =0 ; $k < count( $JsonObject) ; $k++)
		{
			// if we found the string
			if ( $JsonObject[$k] != null && $JsonObject[$k]->name == $FindID)
			{
				$Parents = explode ("," , $JsonObject[$k]->parent );
				// if the node has more than on parent save it the help array
				//$c = count( $Parents );
				if ( count( $Parents ) > 1 )
				{
					CheckIfItExistOrAddHelpArray($HelpArray,$temptree);
				}
				// if the found object has children
				if ( null != $JsonObject[$k]->children)
				{
					// split children array
					$children = explode (",",$JsonObject[$k]->children); // split by , 
					// for each child
					for ($j = 0 ; $j < count ( $children) ; $j++)
					{
						$FoundIndex = CheckIfExist($HelpArray, $children[$j]);
						if ( -1 == $FoundIndex)
						{
							$temp = new Node($children[$j]);
							// add each child as a node
							$temptree->add_child($temp);
						}
						else // we found the index
						{
							$temptree->add_child( $HelpArray[$FoundIndex] );
						}
						
						// handle with the tree
						BuildTreeFromJson( $JsonObject , $tree , $children[$j], $JsonObject[$k]->name , $HelpArray );
					}
					
					
				}
				return;
				
			}
			
		}
	}
}

/*
 * 
 * 
 */
function &CalculateMinPreqs(&$Tree)
{
	// if the tree is not allocated return or if we got handled with this variable - not to do it
	if ( $Tree == null )
		return;
	$temp_minpreqs = array();
	
	// if there is not children its a leaf - push the leaf
	if ( 0 == count($Tree->children  ) )
	{
		array_push ( $temp_minpreqs , $Tree->name);
		return $temp_minpreqs;
	}
	// for each child enter into the recursion and calculate min preqs
	for ( $i =0 ; $i < count($Tree->children ) ; $i++)
	{
		$temp = &CalculateMinPreqs( $Tree->children[$i]);
		array_push ( $temp_minpreqs , $temp);
		
	}
	// check if it not the root
	if (  count( $Tree->parents ) > 0 )
	{
		// index of the minimum place in the array
		$min = findMinimumLength($Tree,$temp_minpreqs);
		// if it is kbit
		if ( strstr($Tree->name,"k") != false) 
		{
			return $temp_minpreqs[$min];
		}
		else if ( strstr($Tree->name,"d") != false)// if it delivery
		{
			$tempArray = array();
			for ( $i =0 ; $i <count( $temp_minpreqs) ; $i++ )
			{
				for ( $j =0 ; $j < count($temp_minpreqs[$i]) ; $j++)
				{
					CheckIfNameExistOrAddInArray($tempArray,$temp_minpreqs[$i][$j] );
				}
			}
			array_push($tempArray , $Tree->name);
			return $tempArray;
		}
		
		
	}
	else
	{
		$Final_Delivery_Array = array();
		for ( $i = 0 ; $i < count($temp_minpreqs) ; $i++)
		{
			for( $k =0 ; $k < count($temp_minpreqs[$i]) ; $k++)
			{
				CheckIfNameExistOrAddInArray($Final_Delivery_Array , $temp_minpreqs[$i][$k]);
			}
		}
		array_push($Final_Delivery_Array, $Tree->name);
		return $Final_Delivery_Array;
	}
}

/*
 * Parameters:
 * Tree - The tree we traverse on
 * DeliveryArray - Array of delivries that we know is in the final Flow
 *
 * We search Delivery Array in the tree and dicide in a greedy way the flow
 */
function OrderDeliveriesByPrecedence(&$Tree,&$DeliveryArray,&$FinalFlow)
{
	if ( $Tree == null || 0 == count($Tree->children) )
		return;
	
	
	for ( $i =0 ; $i < count($Tree->children); $i++ )
	{
		OrderDeliveriesByPrecedence( $Tree->children[$i],$DeliveryArray,$FinalFlow);
		for ( $j =0 ; $j < count($DeliveryArray) ; $j++)
		{
			CheckIfNameExistOrAddInArrayAndDeleteFromArray($DeliveryArray, $Tree->children[$i]->name,$FinalFlow); // true if we add , false is exist
			
		}
	}
		if( 0 ==  count($Tree->parents) ) // it is the root
			array_push($FinalFlow, $Tree->name);

}

/*
 * Paramter: 	Arr - Array of Array which we calculate the minimum length
 * 				Tree - the node that we calculate the tree , we use it for the case that we have number even we decide by number of parents.
 * return value - return the index of the minimum length
 */
function findMinimumLength(&$Tree,$Arr)
{
	$minIndex = -1;;
	$minValue = 0;

	for ($j=0 ; $j < count($Arr) ; $j++ )
	{
		if ( -1 == $minIndex)
		{
			$minIndex = 0;
			$minValue = count($Arr[0]);
		}
		else
		{
			// if we found the minimum update it
			if ( count($Arr[$j]) < $minValue)
			{
				$minIndex = $j;
				$minValue = count($Arr[j]);
			}
			// if we have a tie -> choose the variable with the higher number of parents
			else if ( count($Arr[$j]) == $minValue && $minIndex != $j )
			{
				// if current index has less parents update to a new minIndex
				if ( count($Tree->children[$minIndex]->parents) < count($Tree->children[$j]->parents ) )
				{
					$minIndex = $j;
					$minValue = count($Arr[$j]);
				}
			}
		}
	}

	return $minIndex;

}
/*
 * Parameters:
 * Arr - the array we want to search in
 * Name - the name that we search
 *
 * we will check if the CheckNode is in HelpArray
 * 	if yes - return true
 * 	if no - return false
 */
function CheckIfNameExistOrAddInArray(&$Arr , $Name)
{
	
	for ( $i = 0 ; $i < count($Arr) ; $i++)
	{
	if ($Arr[$i] == $Name )
		return;
	}
	array_push($Arr, $Name);
}


/*
 * Parameters:
 * Arr - the array we want to search in
 * Name - the name that we search
 *
 * we will check if the Name is in Arr
 * 	if not exist we will exit
 * 	if exist - we will search Name In AddToFlow
 */
function CheckIfNameExistOrAddInArrayAndDeleteFromArray($Arr , $Name, &$AddToFlow)
{
	//var Found = false;
	$AddFlag = true;
	for ( $i = 0 ; $i < count($Arr) ; $i++)
	{
		if ($Arr[$i] == $Name ) // we find Name in Arr
		{
			for ( $j =0 ; $j < count($AddToFlow) ; $j++)
			{
				if ( $AddToFlow[$j] == $Name)
				{
					$AddFlag = false;
					break;
				}
			}
			if ( $AddFlag ) // if add flag is true - add Name
				array_push($AddToFlow, $Name);
			
			return;
		}
	}

	return true;
}


?>