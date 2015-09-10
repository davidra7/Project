
function Node(value) {
 
    this.value = value;
    this.children = [];
    this.parent = [];
    this.minpreqs;
    this.tempMinPreqs=[];
    
    this.addParent = function(node) {
        //this.parent = node;
    	var AddParentFlag = true;
    	for ( var i = 0 ; i < this.parent.length; i++)
		{
    		if (this.parent[i].value == node.value )
    			AddParentFlag = false;
		}
    	if ( AddParentFlag)
    		this.parent[this.parent.length] = node;
    }
 
    this.getParentNode = function() {
        return this.parent;
    }
 
    this.addChild = function(node) {
    	var AddChildrenFlag = true;
    	// before adding the parent or the child lets check if it no exist
    	for ( var i = 0 ; i < this.children.length; i++)
		{
    		if (this.children[i].value == node.value )
    			AddChildrenFlag = false;
		}
    	
    	node.addParent(this);
    	
    	if ( AddChildrenFlag)
    		this.children[this.children.length] = node;
    }
 
    this.getChildren = function() {
        return this.children;
    }
 
    this.removeChildren = function() {
        this.children = [];
    }
}

function temp(){

	var string = '[{"name":"d01","type":"d","children":"k01,k02,k03","parent":null},{"name":"k01","type":"k","children":"d02","parent":"d01"},{"name":"k02","type":"k","children":"d03","parent":"d01"},{"name":"k03","type":"k","children":"d03,d04","parent":"d01"},{"name":"k05","type":"k","children":"d02","parent":"d03,d04"},{"name":"d02","type":"d","children":null,"parent":"k05,k01"},{"name":"d03","type":"d","children":"k05","parent":"k03,k02"},{"name":"d04","type":"d","children":"k05","parent":"k03"}]';
	
	var JsonObject = JSON.parse(string);
	
	var TempHelpArray=[];
	var Tree =BuildTreeFromJson(JsonObject,null,null,null,TempHelpArray);
	CalculateMinPreqs(Tree);
	
	
	
}
/*
 * Parameters: FindID  - name/ID of the node that we want to find.
 * return value: reference to the node 
 */
function findNode(Tree,FindID)
{
	var tempTree = Tree;
	var returnValue = null;
	if (tempTree.value == FindID )
		return tempTree;
	for ( var i =0 ; i < tempTree.children.length; i++)
	{
		returnValue=  findNode(tempTree.children[i],FindID ) ;
		if ( returnValue != null)
			return returnValue;
		
	}
	
	return null;
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
function CheckIfItExistOrAddHelpArray(HelpArray, CheckNode)
{
	for ( var i =0 ; i < HelpArray.length ; i++)
	{
		if (HelpArray[i] == CheckNode)
			return;
	}
	HelpArray[ HelpArray.length ] = CheckNode;
}

/*
* Parameters: 
* tempTree - the node that we suspect that the child exist
* childName - the node name that we will search in the child array.
* 
* we will check if the CheckNode is in HelpArray 
* 	if yes - return true
* 	if no - return false
*/
function CheckIfTheChildExistInParent(tempTree , childName)
{
	// check if you have this child already
	if ( tempTree.children == null)
		return false;
	for( var z = 0 ; z < tempTree.children.length; z++)
	{
		if ( tempTree[z].value == childName)
			return true;
	}	
	return false;
}

/*
 * Parameters: 
 * HelpArray - an array that we save references to objects that we created and don't want to create again
 * CheckNode - the node that we will search in the help array.
 * return the index if exist 
 * return  -1 if don't exist
 */
function CheckIfExist(HelpArray,CheckName)
{
	for ( var i =0 ; i < HelpArray.length ; i++)
	{
		if (HelpArray[i].value == CheckName)
			return i;
	}
	return -1;
}
/*
 * Parameters: 
 * JsonObject: the data we get from the server
 * Tree: the tree is generated in the end
 * FindID : the node we are searching for building the tree
 * HelpArray will save all the pointers of the variable that has 2 parents
 */

function BuildTreeFromJson(JsonObject,Tree, FindID,ParentID, HelpArray)
{
	var tempTree = null;
	// find the place that need to be add       TBD
	if ( Tree != null && FindID != null)
	{
		tempTree = findNode(Tree, FindID);
	}
	// end
	
	//root hanlde
	if( Tree == null )
	{
		// create the tree node
		Tree = new Node(JsonObject[0].name);
		// array that handle the children
		var children = JsonObject[0].children.split(",");
		// enter the children 
		var k =0;
		for  ( k = 0 ; k  < children.length ; k++ )
		{
			// add each child as a node
			Tree.addChild(new Node(children[k]));
			// handle with the tree
			BuildTreeFromJson( JsonObject , Tree , children[k] ,JsonObject[0].name , HelpArray );

		}
		return Tree;
	}// end if tree == FindID
	else
	{
		var i =0;
		// search the FindID in our JsonObject
		for ( i =0 ; i < JsonObject.length ; i++ )
		{
			// if we found the corect ID - create his children
			if ( JsonObject[i] != null && JsonObject[i].name == FindID)
			{
				// if the node has more than on parent save it the help array
				if (JsonObject[i].parent.split(",").length > 1 )
				{
					CheckIfItExistOrAddHelpArray( HelpArray , tempTree);
				}
				// we are doning split for children, but the leaves dont have children. it is null
				if ( null != JsonObject[i].children)
				{
					// parse the children and start adding them also
					var children = JsonObject[i].children.split(",");
					// enter the children 
					var j =0;
					for  ( j =0  ; j < children.length  ; j++ )
					{
						// search the node before creating a new node
						var FoundIndex = CheckIfExist(HelpArray, children[j]);	
						if ( -1 == FoundIndex)
						{
							// add each child as a node
							tempTree.addChild(new Node(children[j]));
						}
						else // we found the index
						{
							tempTree.addChild( HelpArray[FoundIndex] );
						}
						// handle with the tree
						BuildTreeFromJson( JsonObject , Tree , children[j], JsonObject[i].name , HelpArray );
	
					}
				}
				// if we found the node we can exit
				return; 
			}
		}
	
	}
	
	
}

function CalculateMinPreqs(Tree)
{
	// if the tree is not allocated return or if we got handled with this variable - not to do it
	if ( Tree == null )
		return;
	var temp_minpreqs = [];
	if ( Tree.children.length == 0 )
		return temp_minpreqs.push(Tree.value);
		
	var i =0;
	for ( i =0 ; i < Tree.children.length ; i++)
	{
		temp_minpreqs.push(CalculateMinPreqs( Tree.children[i]));
		
	}
	
	/*
	//var min = Math.min.apply(null,temp_minpreqs)

	if ( Tree.value.indexOf('k') >= 0) // if it kbit
		return min;
	else if ( Tree.value.indexOf('d') >= -1) // if it delivery
		return 1+min;
	*/
	
}

/*
function CalculateMinPreqs(Tree)
{
	// if the tree is not allocated return or if we got handled with this variable - not to do it
	if ( Tree == null )
		return;
	if ( Tree.children.length == 0 )
	{
		
		return 1;
	}
		
	var i =0;
	var temp_minpreqs = [];
	for ( i =0 ; i < Tree.children.length ; i++)
	{
		temp_minpreqs.push(CalculateMinPreqs( Tree.children[i]));
		
	}
	
	var min = Math.min.apply(null,temp_minpreqs)

	if ( Tree.value.indexOf('k') >= 0) // if it kbit
		return min;
	else if ( Tree.value.indexOf('d') >= -1) // if it delivery
		return 1+min;

	
}
*/

