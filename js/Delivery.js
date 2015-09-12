
var FlowModule = angular.module('project', []);
FlowModule.controller('delivery',function($scope,$http,$sce)
{
	$scope.current_deliv_status_img = "Pic/eye_gray1.jpg";
	$scope.ShowCustomFlowAddingFlag = false;
	$scope.entities_details = new Object();;
	$scope.kbits_status = [];
	$scope.ShowFirstLevelTree = false;
	$scope.delivery_name;
	
	// Load Details of the t
	$http.post(	"getDetailsOfDelivery.php").success(
		function(response)
		{
			//alert(response);
			BuildDetailsStructFromJson(response);
			$scope.delivery_name = $scope.entities_details.name;
			
			//populate user comments per delivery
			$http.post("getUserCommentsPerDelivery.php", {"data":$scope.delivery_name}).success(
				function(results)
				{
				  // the output of the response is now handled via a variable call 'results'
				  $scope.UserComments = results;
				}
			);

			//populate kbits status of current watched delivery
			$http.post("getUserKbitsStatusPerDelivery.php", {"kbits_needed":$scope.entities_details.kbits_needed, "kbits_provided":$scope.entities_details.kbits_provided}).success(
				function(results)
				{
					// insert kbits status (results) into - kbits_needed
					for (var j = 0 ; j < $scope.entities_details.kbits_needed.length ; j++)
					{
						for (var i = 0 ; i < results.length ; i++)
						{
							if ($scope.entities_details.kbits_needed[j].name.localeCompare(results[i]["Kbitname"]) == 0)
							{
								if(results[i]["Status"].localeCompare("v") == 0)
								{
									$scope.entities_details.kbits_needed[j].is_status_v = true;
									$scope.entities_details.kbits_needed[j].is_status_x = false;
									$scope.entities_details.kbits_needed[j].is_status_q = false;
								}
								else if(results[i]["Status"].localeCompare("q") == 0)
								{
									$scope.entities_details.kbits_needed[j].is_status_q = true;
									$scope.entities_details.kbits_needed[j].is_status_x = false;
									$scope.entities_details.kbits_needed[j].is_status_v = false;
								}
								else if(results[i]["Status"].localeCompare("x") == 0)
								{
									$scope.entities_details.kbits_needed[j].is_status_q = false;
									$scope.entities_details.kbits_needed[j].is_status_x = true;
									$scope.entities_details.kbits_needed[j].is_status_v = false;
								}
								break;
							}
						}
					}
					
					// insert kbits status (results) into - kbits_provided
					for (var j = 0 ; j < $scope.entities_details.kbits_provided.length ; j++)
					{
						for (var i = 0 ; i < results.length ; i++)
						{
							if ($scope.entities_details.kbits_provided[j].name.localeCompare(results[i]["Kbitname"]) == 0)
							{
								if(results[i]["Status"].localeCompare("v") == 0)
								{
									$scope.entities_details.kbits_provided[j].is_status_v = true;
									$scope.entities_details.kbits_provided[j].is_status_x = false;
									$scope.entities_details.kbits_provided[j].is_status_q = false;
								}
								else if(results[i]["Status"].localeCompare("q") == 0)
								{
									$scope.entities_details.kbits_provided[j].is_status_q = true;
									$scope.entities_details.kbits_provided[j].is_status_x = false;
									$scope.entities_details.kbits_provided[j].is_status_v = false;
								}
								else if(results[i]["Status"].localeCompare("x") == 0)
								{
									$scope.entities_details.kbits_provided[j].is_status_q = false;
									$scope.entities_details.kbits_provided[j].is_status_x = true;
									$scope.entities_details.kbits_provided[j].is_status_v = false;
								}
								break;
							}
						}
					}
				}
			);
			// Check Watched or not
			$http.post("getDeliveryWatchedStatus.php", {"delivery_name":$scope.delivery_name}).success(
				function(results)
				{
					//alert(results);
					$scope.current_deliv_status_img = results;
				}
			);		
		}
	);

	// get user flow name from the server
	$http.post(	"getUserCustomFlows.php" ).success(
	    		function( response )
	    		{
	    			$scope.NewFlowName = "";
	    			$scope.UserFlowNames = response;
	    			$scope.UserFlowNames.push("New Flow");
	    			$scope.ComboBoxPersonalFlows = $scope.UserFlowNames[0];
	    			if ("New Flow" == $scope.UserFlowNames[0] )
    				{
	    				$scope.NewFlowShowFlag = true;
    				}
	    		}
		);
	
	
	
	/*
	 * Parameters: 
	 * JsonObject: the data we get from the server
	 * entities_details_array - Array of deliveries' details
	 * 
	 * Build a struct containing the details of all final deliveries in the flow.
	 */
	function BuildDetailsStructFromJson(JsonObject)
	{	
			
			$scope.entities_details.name = JsonObject.name;
			$scope.entities_details.type = JsonObject.type;
			$scope.entities_details.description = JsonObject.description;
			$scope.entities_details.url = $sce.trustAsResourceUrl(JsonObject.url);
			//entities_details_array[index].watched_status_img = "Pic/eye_gray1.jpg";
			
			$scope.entities_details.kbits_needed = [];
			$scope.entities_details.kbits_provided = [];
			$scope.entities_details.deliveries_related = [];
			$scope.entities_details.terms = [];
			$scope.entities_details.scope = [];
			
			$scope.entities_details.kbits_needed = JsonObject.kbits_needed.split(',');
			$scope.entities_details.kbits_provided = JsonObject.kbits_provided.split(',');
			$scope.entities_details.deliveries_related = JsonObject.deliveries_related.split(',');
			$scope.entities_details.terms = JsonObject.terms.split(',');
			$scope.entities_details.scope = JsonObject.scope.split(',');
			
			//kbits_needed structure initialization
			for(var j=0; j < $scope.entities_details.kbits_needed.length ; j++)
			{
				kbit_name = $scope.entities_details.kbits_needed[j];
				$scope.entities_details.kbits_needed[j] = new Object();
				$scope.entities_details.kbits_needed[j].name = kbit_name;
				$scope.entities_details.kbits_needed[j].index = j;	
				$scope.entities_details.kbits_needed[j].is_status_v = false;
				$scope.entities_details.kbits_needed[j].is_status_q = false;
				$scope.entities_details.kbits_needed[j].is_status_x = false;
			}
			//kbits_provided structure initialization
			for(var j=0; j < $scope.entities_details.kbits_provided.length ; j++)
			{
				kbit_name = $scope.entities_details.kbits_provided[j];
				$scope.entities_details.kbits_provided[j] = new Object();
				$scope.entities_details.kbits_provided[j].name = kbit_name;
				$scope.entities_details.kbits_provided[j].index = j;	
				$scope.entities_details.kbits_provided[j].is_status_v = false;
				$scope.entities_details.kbits_provided[j].is_status_q = false;
				$scope.entities_details.kbits_provided[j].is_status_x = false;
			}
			//alert("done");
	}
	
	
	/*
	 * Parameters: 
	 * delivery_name - the name of the delivery we want to view **TODO GALIT: change to primary-key ?? maybe not...**
	 * UserComments - The edited comment that the user wrote for delivery "delivery_name".
	 * 
	 */
	$scope.setUserCommentsPerDelivery = function (delivery_name, userComments)   
	{
		$http.post("SetUserCommentsPerDelivery.php", {"data":delivery_name, "comment":userComments}).success(
				function(results)
				{
				  // the output of the response is now handled via a variable call 'results'
				  $scope.UserComments = userComments;
				  alert(results);
				}
			);
		
	}
	
	/* If user pressed on a kbit status - save it's choise in DB.
	 * 
	 * Parameters: 
	 * new_kbit_status_bit - the new status user gives the kbit. possible values = [v,x,q]
	 * kbit_name
	 */
	$scope.MarkKbit = function (new_kbit_status_bit, kbit_name, kbit_index, kbit_type)   
	{
		$http.post("MarkKbit.php", {"status":new_kbit_status_bit, "kbit_name":kbit_name}).success(
				function(results)
				{
					
					if (results.localeCompare("kbit status updated!") == 0 )
					{
						if(kbit_type.localeCompare("needed") == 0)
						{
							if(new_kbit_status_bit.localeCompare("q") == 0)
							{
								$scope.entities_details.kbits_needed[kbit_index].is_status_q = true;
								$scope.entities_details.kbits_needed[kbit_index].is_status_x = false;
								$scope.entities_details.kbits_needed[kbit_index].is_status_v = false;
							}
							else if(new_kbit_status_bit.localeCompare("x") == 0)
							{
								$scope.entities_details.kbits_needed[kbit_index].is_status_q = false;
								$scope.entities_details.kbits_needed[kbit_index].is_status_x = true;
								$scope.entities_details.kbits_needed[kbit_index].is_status_v = false;
							}
							else if(new_kbit_status_bit.localeCompare("v") == 0)
							{
								$scope.entities_details.kbits_needed[kbit_index].is_status_q = false;
								$scope.entities_details.kbits_needed[kbit_index].is_status_x = false;
								$scope.entities_details.kbits_needed[kbit_index].is_status_v = true;
							}
						}
						else
						{
							if(new_kbit_status_bit.localeCompare("q") == 0)
							{
								$scope.entities_details.kbits_provided[kbit_index].is_status_q = true;
								$scope.entities_details.kbits_provided[kbit_index].is_status_x = false;
								$scope.entities_details.kbits_provided[kbit_index].is_status_v = false;
							}
							else if(new_kbit_status_bit.localeCompare("x") == 0)
							{
								$scope.entities_details.kbits_provided[kbit_index].is_status_q = false;
								$scope.entities_details.kbits_provided[kbit_index].is_status_x = true;
								$scope.entities_details.kbits_provided[kbit_index].is_status_v = false;
							}
							else if(new_kbit_status_bit.localeCompare("v") == 0)
							{
								$scope.entities_details.kbits_provided[kbit_index].is_status_q = false;
								$scope.entities_details.kbits_provided[kbit_index].is_status_x = false;
								$scope.entities_details.kbits_provided[kbit_index].is_status_v = true;
							}
						}
					}
				}
			);
		
	}
	

	
	$scope.ShowNameAndDelivery = function()
	{
		$scope.ShowCustomFlowAddingFlag = !$scope.ShowCustomFlowAddingFlag;
		//$scope.DeliveryOrderShowFlag = true;
		
		
	}
	$scope.ComboBoxPersonalFlowHandler = function()
	{
		if ( "New Flow" == $scope.ComboBoxPersonalFlows)
		{
			$scope.NewFlowShowFlag = true;
		}
		else 
		{
			$scope.NewFlowShowFlag = false;
			// Load all deliveries of the flow.
			
			
		}
	}
	$scope.AddCustomFlow = function()
	{
		
		if ( true == $scope.NewFlowShowFlag &&  "" == $scope.NewFlowName ) // New Flow
		{
			alert("Empty Field");
			return;
		}
		//check if this delviery exist
		$d = $scope.entities_details.name ;
		var name;
		if ( "" != $scope.NewFlowName )
		{
			name = $scope.NewFlowName;
		}
		else
		{
			name = $scope.ComboBoxPersonalFlows;
		}
		
		$http.post(	"AddToCustomFlow.php", {"flowname" : name , "delivery": $d} ).success(
	    		function( response )
	    		{
	    			alert(response);
	    		}
		);		
		
	}
	
	
	
	
	
	$scope.ShowEntityFirstLevelTree = function(entity_name, entity_type)
	{
		$scope.ShowFirstLevelTree = true;
		$scope.entity_to_view_flt = new Object();
		$scope.entity_to_view_flt.name = entity_name;
		$scope.entity_to_view_flt.kbits_related = [];
		$scope.entity_to_view_flt.terms = [];
		$scope.entity_to_view_flt.scope = [];
		$scope.entity_to_view_flt.deliveries_related = [];
		
		$http.post(	"getFLTOfEntity.php", {"entity_name":entity_name}).success(
	    		function(response)
	    		{
	    			$scope.entity_to_view_flt.kbits_related = response[0].kbits_related.split(',');
	    			for(var j=0; j < $scope.entity_to_view_flt.kbits_related.length ; j++)
	    			{
	    				kbit_name = $scope.entity_to_view_flt.kbits_related[j];
	    				$scope.entity_to_view_flt.kbits_related[j] = new Object();
	    				$scope.entity_to_view_flt.kbits_related[j].name = kbit_name;
	    				$scope.entity_to_view_flt.kbits_related[j].is_status_v = false;
	    				$scope.entity_to_view_flt.kbits_related[j].is_status_x = false;
	    				$scope.entity_to_view_flt.kbits_related[j].is_status_q = false;
	    			}
	    			$scope.entity_to_view_flt.terms = response[0].terms.split(',');
	    			$scope.entity_to_view_flt.scope = response[0].scope.split(',');
	    			$scope.entity_to_view_flt.deliveries_related = response[0].deliveries_related.split(',');
	    		}
		);
		
	}
	
	
	
	
	$scope.GetKbitStatus = function(kbit_name){
		$http.post("getSingleKbitStatus.php", {"kbit_name":kbit_name}).success(
				function(results)
				{
					for(var j=0; j < $scope.entity_to_view_flt.kbits_related.length ; j++)
					{
						if($scope.entity_to_view_flt.kbits_related[j].name.localeCompare(results["Kbitname"]) == 0)
						{
							if(results["Status"].localeCompare("v") == 0)
							{
								$scope.entity_to_view_flt.kbits_related[j].is_status_v = true;
								$scope.entity_to_view_flt.kbits_related[j].is_status_x = false;
								$scope.entity_to_view_flt.kbits_related[j].is_status_q = false;
							}
							else if(results["Status"].localeCompare("q") == 0)
							{
								$scope.entity_to_view_flt.kbits_related[j].is_status_q = true;
								$scope.entity_to_view_flt.kbits_related[j].is_status_x = false;
								$scope.entity_to_view_flt.kbits_related[j].is_status_v = false;
							}
							else if(results["Status"].localeCompare("x") == 0)
							{
								$scope.entity_to_view_flt.kbits_related[j].is_status_q = false;
								$scope.entity_to_view_flt.kbits_related[j].is_status_x = true;
								$scope.entity_to_view_flt.kbits_related[j].is_status_v = false;
							}
							break;
						}
					}
				});
	}
	
	$scope.GetDeliveryWatchedStatus = function(delivery_name){
		$http.post("getDeliveryWatchedStatus.php", {"delivery_name":delivery_name}).success(
				function(results)
				{
				
					$scope.watched_status_img = results;
					
				
				});
	}
	
	$scope.MarkAsWatched = function(delivery_name){
		$http.post("MarkDeliveryWatchedStatus.php", {"delivery_name":delivery_name}).success(
				function(results)
				{
					//alert(results);
					$scope.current_deliv_status_img = results;
				});
	}
	$scope.GetDeliveryInFLTWatchedStatus = function(delivery_name){
		$http.post("getDeliveryWatchedStatus.php", {"delivery_name":delivery_name}).success(
				function(results)
				{
					$scope.FLT_deliv_status_img = results;
				});
	}
	$scope.setDeliveryNameOnServer = function(name)
	{

		$http.post(	"SetDeliveryInSession.php" , { "d":name }
	    ).success(
		    		function(response)
		    		{
						//alert(response);
		    		}
			);
	}
	
});