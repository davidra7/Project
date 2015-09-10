var UserFlowModule = angular.module('project', []);
UserFlowModule.controller('publicflow',function($scope,$http,$sce)
{
	$scope.DataArray = [];
	$scope.CurrentFlowArray = null;

	// load all public flows
	$http.post(	"getPublicFlows.php" ).success(
    		function(response)
    		{
    			//alert( response.length);
    			for( i =0 ; i < response.length; i++)
				{
    				response[i].show = 0;
    				$scope.DataArray.push( response[i] );
				}
    			
    		}
	);
	$scope.SetShowHide = function(x)
	{
		$scope.CurrentFlowArray = x.flow;
	}
	
});