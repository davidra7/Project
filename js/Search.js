var Searchmodule = angular.module('project', []);
Searchmodule.controller('search',function($scope,$http,$sce){
	
	$scope.resultDeliveries = [];
	
	$scope.delivery = false;
	$scope.d2k = false;
	$scope.term = false;
	$scope.scope = false;
	$scope.title = false;
	$scope.description = false;
	
	// flag that show if the search is done
	$scope.SearchDone = false;
	
	//Flag
	$scope.ShowFlagDELIVERY = false;
	$scope.ShowFlagD2K = false;
	$scope.ShowFlagTERM = false;
	$scope.ShowFlagSCOPE = false;
	
	
	$scope.Search = function() 
	{	
		// don't send empty search to server
		if ($scope.Searchfield == null )
		{
			alert("You Must fill the the search textbox!");
			return;
		}
		if ( !($scope.delivery || $scope.d2k || $scope.term || $scope.scope  ) )
		{
			alert("You Must choose at least one element!")
			return;
		}
		
		if ( !( $scope.title || $scope.description ) )
		{
			alert("You Must choose at least one search!")
			return;
		}
		
		var obj = {};
	    obj.searchtext =  $scope.Searchfield;
	    obj.elements = {};
	    obj.elements.delivery =  JSON.stringify($scope.delivery);
	    obj.elements.d2k =  JSON.stringify($scope.d2k);
	    obj.elements.term = JSON.stringify( $scope.term );
	    obj.elements.scope =  JSON.stringify( $scope.scope);
	    obj.field={};
	    obj.field.title = JSON.stringify( $scope.title);
	    obj.field.description =  JSON.stringify( $scope.description);
	    var stringToSend = JSON.stringify(obj);
		
		
		//document.write(stringToSend);
		// Build JSON
		 
	    $http.post(	"SearchServer.php" , stringToSend ).success(
		    		function(response)
		    		{
						//alert("entered");
						//alert(response);
						//document.write(response);
						//alert(JSON.stringify(response));

		    			if (response.data.DELIVERIES != null )
						{
							//temp = JSON.parse(response);
							//alert(JSON.stringify( response.data.DELIVERIES) );
							for ( k in response.data.DELIVERIES)
							{
								
								$scope.resultDeliveries.push( response.data.DELIVERIES[k] );
								//alert ( JSON.stringify($scope.resultDeliveries[k] ));
							}
							/*
							for( x in $scope.resultDeliveries)
							{
								alert( $scope.resultDeliveries[x].UID+","+$scope.resultDeliveries[x].DESCRIPTION +","+$scope.resultDeliveries[x].TITLE);
							}
							*/
						}
						/*
						if (response.data.D2K != null )
						{
							for ( x in response.data.D2K)
							{
								$scope.resultD2k.push( response.data.D2K[x] );
							}
						}
						if (response.data.TERMS != null )
						{
							for ( x in response.data.TERMS)
							{
								$scope.resultTerm.push( response.data.TERMS[x] );
							}
						}
						if (response.data.SCOPES != null )
						{
							for ( x in response.data.SCOPES)
							{
								$scope.resultScope.push( response.data.SCOPES[x] );
							}
						}
						*/
		    		}
			);
		$scope.SearchDone = true;

	} //end search function
	
	$scope.SaveFlowIDInSession = function(msgid)
	{
		//alert(msgid);
		$http.post(	"SetIDinSession.php" , { "id":msgid }
	    ).success(
		    		function(response)
		    		{
						//alert(response);
		    			if( response == "1")
						{
							window.location = "flows.php";
						}
		    		}
			);
	}
	
	$scope.CheckBoxPressButton = function( obj )
	{
		if ( obj == 'delivery')
		{
			$scope.delivery = !$scope.delivery;
		}
		else if (obj == 'd2k')
		{
			$scope.d2k = !$scope.d2k;
		}
		else if (obj == 'term')
		{
			$scope.term = !$scope.term;
		}
		else if (obj == 'scope')
		{
			$scope.scope = !$scope.scope;
		}
		else if (obj == 'title')
		{
			$scope.title = !$scope.title;
		}
		else if (obj == 'description')
		{
			$scope.description = !$scope.description;
		}
	}
	
	$scope.ShowFlag = function(type)
	{
		if( type == "DELIVERY")
		{
			$scope.ShowFlagDELIVERY = !$scope.ShowFlagDELIVERY;
		}
		else if( type == "D2K")
		{
			$scope.ShowFlagD2K = !$scope.ShowFlagD2K;
		}
		else if( type == "TERM")
		{
			$scope.ShowFlagTERM = !$scope.ShowFlagTERM;
		}
		else if( type == "SCOPE")
		{
			$scope.ShowFlagSCOPE = !$scope.ShowFlagSCOPE;
		}		
	}

});


