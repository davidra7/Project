
// We use this format of getting entity details when a delivery's link was pressed and this delivery is not part of the returned flow (cause 
// if it is - then we already have it's details)
FlowModule.controller('details',function($scope,$http,$sce)
{
	$scope.entity_details = [];
	$http.post(	"getDetailsOfEntity.php" ).success(
	    		function(response)
	    		{
	    			/// we get from the response in a json format	    			
	    			BuildDetailsStructFromJson(response, $scope.entity_details);
	    		}
		);

	
	/*
	 * Parameters: 
	 * JsonObject: the data we get from the server
	 * entity_details_array - Array of deliveries' details
	 * 
	 * Build a struct containing the details of a requested delivery.
	 */
	function BuildDetailsStructFromJson(JsonObject, entity_details_array)
	{
		entity_details_array[0] = new Object();
		entity_details_array[0].name = JsonObject[0].name;
		entity_details_array[0].type = JsonObject[0].type;
		entity_details_array[0].description = JsonObject[0].description;
		entity_details_array[0].url = $sce.trustAsResourceUrl(JsonObject[0].url);
		entity_details_array[0].kbits_needed = JsonObject[0].kbits_needed;
		entity_details_array[0].kbits_provided = JsonObject[0].kbits_provided;
		entity_details_array[0].deliveries_related = JsonObject[0].deliveries_related;
		entity_details_array[0].terms = JsonObject[0].terms;
		entity_details_array[0].scope = JsonObject[0].scope;
	}

});