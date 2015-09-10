<!DOCTYPE html>
<html>
<head><meta charset="ISO-8859-1">
	<script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.3.15/angular.min.js"></script>
	<link rel="stylesheet" href="css/bootstrap.css">
	<title>Registration</title>
	<link rel="stylesheet" href="css/global.css">
</head>
<body data-ng-app="project" data-ng-controller="register" >
<div class="container">
	<div class="form-signin" >
		<h2 class="form-signin-heading">Register</h2>
		<form data-ng-submit="SendForm()" class="form-signin" >
			<label>Username:</label> <input type="text" name="username" data-ng-model="username" class="form-control" required />
			
			<label>Password:</label>  <input type="password" name="pass" data-ng-model="password" class="form-control" required />
			
			<label>Email:</label>  <input type="email" name="email" data-ng-model="email" class="form-control" required />
			<br>
			<button type="submit" name="submit" class="btn btn-lg btn-primary btn-block">Register</button>
			<label data-ng-show="ShowError" style="color:red ">Registration Failed!</label>				
		</form>
	</div>
</div>

</body>
<script>
	var LoginModule = angular.module('project', []);
	LoginModule.controller('register',function($scope,$http)
	{
		$scope.ShowError = false;
		$scope.SendForm = function()
		{
			$http.post(	"registration.php",{"username":$scope.username , "pass":$scope.password,"email":$scope.email} ).success(
	    		    		function(response)
	    		    		{
	    		    			if( response == 0)
								{
									$scope.ShowError = true;
								}
								else if( response == 1)
								{
									 location.replace("search.php");
								}
								
	    		    		}
	    			);
		}
	});
	</script>
</html>

