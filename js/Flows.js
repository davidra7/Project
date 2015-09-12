
var FlowModule = angular.module('project', []);
FlowModule.controller('flow',function($scope,$http,$sce)
{
	$scope.current_deliv_status_img = "Pic/eye_gray1.jpg";
	$scope.ShowCustomFlowAddingFlag = false;
	$scope.ShowEntireFlowAddingFlag = false;
	$scope.ShowWishlistFlowAddingFlag = false;
	$scope.flow = [];
	$scope.flowID = [];
	$scope.entities_details = [];
	$scope.show_delivery_flag = false;
	$scope.delivery_to_view_index;
	$scope.kbits_status = [];
	$scope.updated_kbit_index;
	$scope.index = 0 //temp
	$scope.ShowFirstLevelTree = false;
	
	$http.post(	"getFlows.php" ).success(
	    		function(response)
	    		{
					//alert(response);
					//document.write( JSON.stringify(response) );
					//return;
	    			// we get from the response in a json format  - the first place is our root.
//	    			flow_dellivery_names = [];
    				for ( var i =0 ; i < response.length ; i++)
					{
    					$scope.flow[i] = new Object();
    					$scope.flow[i].name = response[i];
    					$scope.flow[i].watched_status_img = "Pic/eye_gray1.jpg";
//    					flow_dellivery_names.push($scope.flow[i].name);
//    					$scope.flow.push(response[i]);
					}
//    				alert(flow_dellivery_names);
//    				$http.post(	"getWatchedStatusOfAllDeliveriesInFlow.php",flow_dellivery_names ).success(
//    						function(response)
//    						{
//    							
//    						}
//    				);
    				
					// build the object
					var SendFlow = {};
					SendFlow.flow = $scope.flow;
					var SendJson = JSON.stringify(SendFlow);
					//alert(SendJson);
	    			// After we got the final list of min required deliveries, we ask the server for all these deliveries' contents.
	    			
					$http.post(	"getDetailsOfAllDeliveriesInFlow.php", SendJson ).success(
	    		    		function(response)
	    		    		{
	    		    			BuildDetailsStructFromJson(response, $scope.entities_details);
	    		    			$scope.index += response.length;
	    		    			
	    		    		}
	    			);
					
					

	    		}
		);
	// get user flow name from the serv
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
	
	
	$scope.AddToPersonalFlow = function() {
		// Take the flow and make it string
		var SendFlow = JSON.stringify($scope.flow);
		var temp = { "type" : "AddToPersonalFlow" , "string" : SendFlow };
		// Send a request for adding the 
		$http.post(	"personalflow.php", temp ).success(
	    		function(response)
	    		{
	    			alert(response);
	    		}
		);
	}
	
	
	/*
	 * Parameters: 
	 * JsonObject: the data we get from the server
	 * entities_details_array - Array of deliveries' details
	 * 
	 * Build a struct containing the details of all final deliveries in the flow.
	 */
	function BuildDetailsStructFromJson(JsonObject, entities_details_array)
	{	
		index = $scope.index;
		for ( var i = 0 ; i < JsonObject.length ; i++)
		{
			entities_details_array[index] = new Object();
			entities_details_array[index].name = JsonObject[i].name;
			entities_details_array[index].type = JsonObject[i].type;
			entities_details_array[index].description = JsonObject[i].description;
			entities_details_array[index].url = $sce.trustAsResourceUrl(JsonObject[i].url);
			//entities_details_array[index].watched_status_img = "Pic/eye_gray1.jpg";
			
			entities_details_array[index].kbits_needed = [];
			entities_details_array[index].kbits_provided = [];
			entities_details_array[index].deliveries_related = [];
			entities_details_array[index].terms = [];
			entities_details_array[index].scope = [];
			
			entities_details_array[index].kbits_needed = JsonObject[i].kbits_needed.split(',');
			entities_details_array[index].kbits_provided = JsonObject[i].kbits_provided.split(',');
			entities_details_array[index].deliveries_related = JsonObject[i].deliveries_related.split(',');
			entities_details_array[index].terms = JsonObject[i].terms.split(',');
			entities_details_array[index].scope = JsonObject[i].scope.split(',');
			
			//kbits_needed structure initialization
			for(var j=0; j < entities_details_array[index].kbits_needed.length ; j++)
			{
				kbit_name = entities_details_array[index].kbits_needed[j];
				entities_details_array[index].kbits_needed[j] = new Object();
				entities_details_array[index].kbits_needed[j].name = kbit_name;
				entities_details_array[index].kbits_needed[j].index = j;	
				entities_details_array[index].kbits_needed[j].is_status_v = false;
				entities_details_array[index].kbits_needed[j].is_status_q = false;
				entities_details_array[index].kbits_needed[j].is_status_x = false;
			}
			//kbits_provided structure initialization
			for(var j=0; j < entities_details_array[i].kbits_provided.length ; j++)
			{
				kbit_name = entities_details_array[index].kbits_provided[j];
				entities_details_array[index].kbits_provided[j] = new Object();
				entities_details_array[index].kbits_provided[j].name = kbit_name;
				entities_details_array[index].kbits_provided[j].index = j;	
				entities_details_array[index].kbits_provided[j].is_status_v = false;
				entities_details_array[index].kbits_provided[j].is_status_q = false;
				entities_details_array[index].kbits_provided[j].is_status_x = false;
			}
			index ++ ;
		}
		//alert("done loading");
	}
	
	/*
	 * Parameters: 
	 * delivery_name - the name of the delivery we want to view **TODO: change to primary-key**
	 * 
	 * activate the "show_delivery_flag" - which will show the delivery's panel
	 * (this method is only for the case the user pressed one delivery of the final flow)
	 */
	$scope.PressedDeliveryInFlow = function (delivery_name)
	{
		//UID = delivery_name.substring(1, delivery_name.length);
		$scope.show_delivery_flag = true;
		$scope.ShowFirstLevelTree = false;
		for(var i=0 ; i < $scope.entities_details.length ; i++)
		{
			if($scope.entities_details[i].name == delivery_name)
			{
				$scope.delivery_to_view_index = i;
				break;
			}
		}
		// populate delivery status (per current user) 
		$http.post("getDeliveryWatchedStatus.php", {"delivery_name":delivery_name}).success(
		function(results)
		{
			$scope.current_deliv_status_img = results;
		});
		
		//populate user comments per delivery
		$http.post("getUserCommentsPerDelivery.php", {"data":delivery_name}).success(
			function(results)
			{
				
			  // the output of the response is now handled via a variable call 'results'
			  $scope.UserComments = results;
			}
		);
		
		//populate kbits status of current watched delivery
		$http.post("getUserKbitsStatusPerDelivery.php", {"kbits_needed":$scope.entities_details[$scope.delivery_to_view_index].kbits_needed, "kbits_provided":$scope.entities_details[$scope.delivery_to_view_index].kbits_provided}).success(
				function(results)
				{
					// insert kbits status (results) into - kbits_needed
					for (var j = 0 ; j < $scope.entities_details[$scope.delivery_to_view_index].kbits_needed.length ; j++)
					{
						for (var i = 0 ; i < results.length ; i++)
						{
							if ($scope.entities_details[$scope.delivery_to_view_index].kbits_needed[j].name.localeCompare(results[i]["Kbitname"]) == 0)
							{
								if(results[i]["Status"].localeCompare("v") == 0)
								{
									$scope.entities_details[$scope.delivery_to_view_index].kbits_needed[j].is_status_v = true;
									$scope.entities_details[$scope.delivery_to_view_index].kbits_needed[j].is_status_x = false;
									$scope.entities_details[$scope.delivery_to_view_index].kbits_needed[j].is_status_q = false;
								}
								else if(results[i]["Status"].localeCompare("q") == 0)
								{
									$scope.entities_details[$scope.delivery_to_view_index].kbits_needed[j].is_status_q = true;
									$scope.entities_details[$scope.delivery_to_view_index].kbits_needed[j].is_status_x = false;
									$scope.entities_details[$scope.delivery_to_view_index].kbits_needed[j].is_status_v = false;
								}
								else if(results[i]["Status"].localeCompare("x") == 0)
								{
									$scope.entities_details[$scope.delivery_to_view_index].kbits_needed[j].is_status_q = false;
									$scope.entities_details[$scope.delivery_to_view_index].kbits_needed[j].is_status_x = true;
									$scope.entities_details[$scope.delivery_to_view_index].kbits_needed[j].is_status_v = false;
								}
								break;
							}
						}
					}
					
					// insert kbits status (results) into - kbits_provided
					for (var j = 0 ; j < $scope.entities_details[$scope.delivery_to_view_index].kbits_provided.length ; j++)
					{
						for (var i = 0 ; i < results.length ; i++)
						{
							if ($scope.entities_details[$scope.delivery_to_view_index].kbits_provided[j].name.localeCompare(results[i]["Kbitname"]) == 0)
							{
								if(results[i]["Status"].localeCompare("v") == 0)
								{
									$scope.entities_details[$scope.delivery_to_view_index].kbits_provided[j].is_status_v = true;
									$scope.entities_details[$scope.delivery_to_view_index].kbits_provided[j].is_status_x = false;
									$scope.entities_details[$scope.delivery_to_view_index].kbits_provided[j].is_status_q = false;
								}
								else if(results[i]["Status"].localeCompare("q") == 0)
								{
									$scope.entities_details[$scope.delivery_to_view_index].kbits_provided[j].is_status_q = true;
									$scope.entities_details[$scope.delivery_to_view_index].kbits_provided[j].is_status_x = false;
									$scope.entities_details[$scope.delivery_to_view_index].kbits_provided[j].is_status_v = false;
								}
								else if(results[i]["Status"].localeCompare("x") == 0)
								{
									$scope.entities_details[$scope.delivery_to_view_index].kbits_provided[j].is_status_q = false;
									$scope.entities_details[$scope.delivery_to_view_index].kbits_provided[j].is_status_x = true;
									$scope.entities_details[$scope.delivery_to_view_index].kbits_provided[j].is_status_v = false;
								}
								break;
							}
						}
					}
				}
			);	
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
								$scope.entities_details[$scope.delivery_to_view_index].kbits_needed[kbit_index].is_status_q = true;
								$scope.entities_details[$scope.delivery_to_view_index].kbits_needed[kbit_index].is_status_x = false;
								$scope.entities_details[$scope.delivery_to_view_index].kbits_needed[kbit_index].is_status_v = false;
							}
							else if(new_kbit_status_bit.localeCompare("x") == 0)
							{
								$scope.entities_details[$scope.delivery_to_view_index].kbits_needed[kbit_index].is_status_q = false;
								$scope.entities_details[$scope.delivery_to_view_index].kbits_needed[kbit_index].is_status_x = true;
								$scope.entities_details[$scope.delivery_to_view_index].kbits_needed[kbit_index].is_status_v = false;
							}
							else if(new_kbit_status_bit.localeCompare("v") == 0)
							{
								$scope.entities_details[$scope.delivery_to_view_index].kbits_needed[kbit_index].is_status_q = false;
								$scope.entities_details[$scope.delivery_to_view_index].kbits_needed[kbit_index].is_status_x = false;
								$scope.entities_details[$scope.delivery_to_view_index].kbits_needed[kbit_index].is_status_v = true;
							}
						}
						else
						{
							if(new_kbit_status_bit.localeCompare("q") == 0)
							{
								$scope.entities_details[$scope.delivery_to_view_index].kbits_provided[kbit_index].is_status_q = true;
								$scope.entities_details[$scope.delivery_to_view_index].kbits_provided[kbit_index].is_status_x = false;
								$scope.entities_details[$scope.delivery_to_view_index].kbits_provided[kbit_index].is_status_v = false;
							}
							else if(new_kbit_status_bit.localeCompare("x") == 0)
							{
								$scope.entities_details[$scope.delivery_to_view_index].kbits_provided[kbit_index].is_status_q = false;
								$scope.entities_details[$scope.delivery_to_view_index].kbits_provided[kbit_index].is_status_x = true;
								$scope.entities_details[$scope.delivery_to_view_index].kbits_provided[kbit_index].is_status_v = false;
							}
							else if(new_kbit_status_bit.localeCompare("v") == 0)
							{
								$scope.entities_details[$scope.delivery_to_view_index].kbits_provided[kbit_index].is_status_q = false;
								$scope.entities_details[$scope.delivery_to_view_index].kbits_provided[kbit_index].is_status_x = false;
								$scope.entities_details[$scope.delivery_to_view_index].kbits_provided[kbit_index].is_status_v = true;
							}
						}
					}
				}
			);
		
	}
	
	
	/* 
	 * 
	 * Parameters: 
	 * 
	 */
	$scope.PressedDeliveryNotInFlow = function (delivery_name)   
	{
		// ask server for delivery details (from the other team server)
		$http.post("getDetailsOfDelivery.php", {"delivery_name":delivery_name}).success(
				function(results)
				{
					$scope.ShowFirstLevelTree = false;
					$scope.delivery_to_view_index = -1;
					for(var i=0 ; i < $scope.entities_details.length ; i++)
					{
						if($scope.entities_details[i].name.localeCompare(delivery_name) == 0)
						{
							$scope.delivery_to_view_index = i;
							break;
						}
					}
					if($scope.delivery_to_view_index == -1)
					{
						BuildDetailsStructFromJson(results, $scope.entities_details);
						$scope.delivery_to_view_index = $scope.index;
						$scope.index += 1;
					}
					
						// populate delivery status (per current user) 
						$http.post("getDeliveryWatchedStatus.php", {"delivery_name":delivery_name}).success(
						function(results)
						{
							$scope.current_deliv_status_img = results;
						});
					
						// get user comments per this delivery from our db
						$http.post("getUserCommentsPerDelivery.php", {"data":delivery_name}).success(
							function(results)
							{
								$scope.UserComments = results;
							}
						);
						
						// populate kbits_status per current presented delivery
						$http.post("getUserKbitsStatusPerDelivery.php", {"kbits_needed":$scope.entities_details[$scope.delivery_to_view_index].kbits_needed, "kbits_provided":$scope.entities_details[$scope.delivery_to_view_index].kbits_provided}).success(
								function(results)
								{
									// insert kbits status (results) into - kbits_needed
									for (var j = 0 ; j < $scope.entities_details[$scope.delivery_to_view_index].kbits_needed.length ; j++)
									{
										for (var i = 0 ; i < results.length ; i++)
										{
											if ($scope.entities_details[$scope.delivery_to_view_index].kbits_needed[j].name.localeCompare(results[i]["Kbitname"]) == 0)
											{
												if(results[i]["Status"].localeCompare("v") == 0)
												{
													$scope.entities_details[$scope.delivery_to_view_index].kbits_needed[j].is_status_v = true;
													$scope.entities_details[$scope.delivery_to_view_index].kbits_needed[j].is_status_x = false;
													$scope.entities_details[$scope.delivery_to_view_index].kbits_needed[j].is_status_q = false;
												}
												else if(results[i]["Status"].localeCompare("q") == 0)
												{
													$scope.entities_details[$scope.delivery_to_view_index].kbits_needed[j].is_status_q = true;
													$scope.entities_details[$scope.delivery_to_view_index].kbits_needed[j].is_status_x = false;
													$scope.entities_details[$scope.delivery_to_view_index].kbits_needed[j].is_status_v = false;
												}
												else if(results[i]["Status"].localeCompare("x") == 0)
												{
													$scope.entities_details[$scope.delivery_to_view_index].kbits_needed[j].is_status_q = false;
													$scope.entities_details[$scope.delivery_to_view_index].kbits_needed[j].is_status_x = true;
													$scope.entities_details[$scope.delivery_to_view_index].kbits_needed[j].is_status_v = false;
												}
												break;
											}
										}
									}
									
									// insert kbits status (results) into - kbits_provided
									for (var j = 0 ; j < $scope.entities_details[$scope.delivery_to_view_index].kbits_provided.length ; j++)
									{
										for (var i = 0 ; i < results.length ; i++)
										{
											if ($scope.entities_details[$scope.delivery_to_view_index].kbits_provided[j].name.localeCompare(results[i]["Kbitname"]) == 0)
											{
												if(results[i]["Status"].localeCompare("v") == 0)
												{
													$scope.entities_details[$scope.delivery_to_view_index].kbits_provided[j].is_status_v = true;
													$scope.entities_details[$scope.delivery_to_view_index].kbits_provided[j].is_status_x = false;
													$scope.entities_details[$scope.delivery_to_view_index].kbits_provided[j].is_status_q = false;
												}
												else if(results[i]["Status"].localeCompare("q") == 0)
												{
													$scope.entities_details[$scope.delivery_to_view_index].kbits_provided[j].is_status_q = true;
													$scope.entities_details[$scope.delivery_to_view_index].kbits_provided[j].is_status_x = false;
													$scope.entities_details[$scope.delivery_to_view_index].kbits_provided[j].is_status_v = false;
												}
												else if(results[i]["Status"].localeCompare("x") == 0)
												{
													$scope.entities_details[$scope.delivery_to_view_index].kbits_provided[j].is_status_q = false;
													$scope.entities_details[$scope.delivery_to_view_index].kbits_provided[j].is_status_x = true;
													$scope.entities_details[$scope.delivery_to_view_index].kbits_provided[j].is_status_v = false;
												}
												break;
											}
										}
									}
									
								}
							);	
				}

			);

		
	}
	
	$scope.SaveFlow = function (flow,Flag)
	{		
		if ( true == Flag)
		{
			// Send a request for adding the 
			$http.post("AddPersonalFlow.php", { "flow" : flow , "flowname": $scope.ShowEntireFlowName }).success(
		    		function(response)
		    		{
		    			alert(response);
						if (response == "Added")
						{
							$scope.ShowEntireFlowAddingFlag = !$scope.ShowEntireFlowAddingFlag;
						}
		    		}
			);
		}
		else if (false == Flag)
		{
			$scope.ShowEntireFlowAddingFlag = !$scope.ShowEntireFlowAddingFlag; // show the Flow name and button
		}
	}
	$scope.SaveWishlist = function (flow,Flag)
	{		
		if ( true == Flag)
		{
			// Send a request for adding the 
			$http.post("AddWishlistFlow.php", { "flow" : flow , "flowname": $scope.ShowWishlistFlowName }).success(
		    		function(response)
		    		{
		    			alert(response);
						if(response == "Added")
						{
							$scope.ShowWishlistFlowAddingFlag = !$scope.ShowWishlistFlowAddingFlag;
						}
		    		}
			);
		}
		else if (false == Flag)
		{
			$scope.ShowWishlistFlowAddingFlag = !$scope.ShowWishlistFlowAddingFlag; // show the Flow name and button
		}
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
		$d = $scope.entities_details[$scope.delivery_to_view_index].name ;
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
					for(var j=0; j < $scope.flow.length ; j++)
					{
						if($scope.flow[j].name.localeCompare(delivery_name) == 0)
						{
							$scope.flow[j].watched_status_img = results;
						}
					}
				});
	}
	
	$scope.MarkAsWatched = function(delivery_name){
		$http.post("MarkDeliveryWatchedStatus.php", {"delivery_name":delivery_name}).success(
				function(results)
				{
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
	
});