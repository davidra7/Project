var UserFlowModule = angular.module('project', []);
UserFlowModule.controller('userflow',function($scope,$http,$sce)
{
	$scope.PersonalFlowsNameID = []; 	// array of the name of the Personal flow
	$scope.PersonalFlowsFlow = []; 	// Array of the flow - each place is a flow(array)
	$scope.CustomFlowsNameID = []; 	// array of the name of the Custom flow
	$scope.CustomFlowsFlow = [];	// Array of the flow - each place is a flow(array)
	$scope.WishlistFlowsNameID = [];	// array of the name of the Wishlist flow
	$scope.WishlistFlowsFlow = [];	// Array of the flow - each place is a flow(array)
	
	
	$scope.CurrentIndex  = -1;
	$scope.current_deliv_status_img = "Pic/eye_gray1.jpg";
	
	/* P E R S O N A L
	 * Load the personal flow of the user 
	 * */
	$http.post(	"getUserPersonalFlowsWithDetails.php" ).success(
    		function(response)
    		{
    			for( i = 0 ; i < response.length ; i= i+2)
				{
    				
    				$scope.PersonalFlowsNameID.push( response[i]);
    				$scope.PersonalFlowsFlow.push ( response[i+1] );
				}
    		}
	);
	/* C U S T O M
	 * Load the Custom flow of the user 
	 */
	$http.post(	"getUserCustomFlowsWithDetails.php" ).success(
    		function(response)
    		{
    			for( i = 0 ; i < response.length ; i= i+2)
				{
    				$scope.CustomFlowsNameID.push( response[i]);
    				$scope.CustomFlowsFlow.push ( response[i+1] );
				}
    			
    		}
	);
	/* W I S H L I S T
	 * Load the wishlist flow of the user 
	 */
	$http.post(	"getUserWishlistFlowsWithDetails.php" ).success(
    		function(response)
    		{
    			
    			for( i = 0 ; i < response.length ; i= i+2)
				{
    				$scope.WishlistFlowsNameID.push( response[i]);
    				$scope.WishlistFlowsFlow.push ( response[i+1] );
				}
    		}
	);
	
	/* get the name of the flow ( in parameter X) and search in the Active Type.
	 * then setting it a current flow to show 
	 * Parameters: X - the name of the Flow to show
	 */
	$scope.SetCurrentFlow = function(x)
	{
		// get the lentgh for the search
		len = $scope.ActiveTypeNameID.length;
		for( i = 0 ; i < len ; i++ )
		{
			// we found the flow
			if ( x == $scope.ActiveTypeNameID[i])
			{
				$scope.CurrentIndex = i;
				$scope.CurrentFlow = $scope.ActiveTypeFlow[i];				
				return;
			}
		}
	}
	/*
	 * 
	 */
	$scope.SetFlowType = function(type)
	{
		$scope.type = type;
		$scope.CurrentFlow = null;
		$scope.CurrentIndex = -1;
		if ( "Personal" == type )
		{
			$scope.ActiveTypeNameID = $scope.PersonalFlowsNameID;
			$scope.ActiveTypeFlow = $scope.PersonalFlowsFlow;
		}
		else if ( "Custom" == type)
		{			
			$scope.ActiveTypeNameID = $scope.CustomFlowsNameID;
			$scope.ActiveTypeFlow = $scope.CustomFlowsFlow;
		}
		else if ( "Wishlist" == type)
		{
			$scope.ActiveTypeNameID = $scope.WishlistFlowsNameID;
			$scope.ActiveTypeFlow = $scope.WishlistFlowsFlow;
		}
		
	}
	/* update the custom flow to Public/No public 
	 * Parameters: X - the flow Name/ID
	 * flag: true->public , false - unpublic 
	 */
	$scope.SetAsPublic = function(x,flag)
	{
		$http.post(	"AddToPublic.php",{"id":x.Flow_id,"f":flag,"t":$scope.type} ).success(
	    		function(response)
	    		{
	    			if (response == 1)// if response is 1 update the site - otherwhise do nothing 
	    			{ 
	    				x.Public = !x.Public; 
	    			}
    			}
		);
	}
	
	
	$scope.MoveUp = function(idx,delivery)
	{
		//alert( $scope.ActiveTypeFlow[$scope.CurrentIndex][idx-1]);
		if( idx == 0 )
			return;
		// swap
		$http.post(	"EditCustomFlow.php",{"type":"up","index":idx,"data":delivery,"data2":$scope.ActiveTypeFlow[$scope.CurrentIndex][idx-1],"name":$scope.ActiveTypeNameID[$scope.CurrentIndex].Name} ).success(
	    		function(response)
	    		{
	    			//alert(response);
	    			if ( response == 1)
    				{
		    			var temp = $scope.CurrentFlow[idx];
		    			$scope.CurrentFlow[idx] = $scope.CurrentFlow[idx-1];
		    			$scope.CurrentFlow[idx-1] = temp;
    				}
	    		}
		);
		
	}
	$scope.MoveDown = function(idx,delivery)
	{
		if( idx == ($scope.CurrentFlow.length-1) )
			return;
		
		$http.post(	"EditCustomFlow.php",{"type":"down","index":idx,"data":delivery,"data2":$scope.ActiveTypeFlow[$scope.CurrentIndex][idx+1],"name":$scope.ActiveTypeNameID[$scope.CurrentIndex].Name} ).success(
	    		function(response)
	    		{	 
	    			if ( response == 1)
    				{
		    			var temp = $scope.CurrentFlow[idx];
		    			$scope.CurrentFlow[idx] = $scope.CurrentFlow[idx+1];
		    			$scope.CurrentFlow[idx+1] = temp;
    				}
	    		
	    		}
		);


	
	}
	$scope.Delete = function(idx,delivery)
	{
		
		if ($scope.CurrentFlow.length == 1 && $scope.ActiveTypeNameID[ $scope.CurrentIndex ].Public )
		{
			alert("Can't delete public flow , Please UnPublic it");
			return;
		}
		
		$http.post(	"EditCustomFlow.php",{"type":"delete","index":idx,"data":delivery,"data2":$scope.ActiveTypeFlow[$scope.CurrentIndex].length,"name":$scope.ActiveTypeNameID[$scope.CurrentIndex].Name} ).success(
	    		function(response)
	    		{	 
	    			//alert(response);
	    			if ( response == 1)
					{
	    				$scope.CurrentFlow.splice(idx,1);
						if($scope.CurrentFlow.length == 0)
						{
							$scope.ActiveTypeNameID.splice($scope.CurrentIndex,1);
							alert($scope.ActiveTypeNameID.length);
						}							
					}
	    		
	    		}
		);
	
		
	}
	
	$scope.GetDeliveryWatchedStatus = function(name){

		$http.post("getDeliveryWatchedStatus.php", {"delivery_name":name}).success(
				function(response)
				{
					$scope.current_deliv_status_img = response;
				});
	}
	
	$scope.setDeliveryNameOnServer = function(name)
	{
		$http.post(	"SetDeliveryInSession.php" , { "d": name } ).success(
		    		function(response)
		    		{
						//alert(response);
		    		}
			);
	}
	
	
});