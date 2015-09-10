<!DOCTYPE html>
<?php
	session_start();
	if (isset($_SESSION['Username']) )
	{
		header('Location: search.php');
	}
?>
<html>
<head>
	<meta charset="ISO-8859-1">
	<script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.3.15/angular.min.js"></script>
	<link rel="stylesheet" href="css/bootstrap.css">
	<link rel="stylesheet" href="css/global.css">
	<title>Sign In</title>
</head>
<body data-ng-app="project" data-ng-controller="login" >
<div class="container">
	<div class="form-signin" >
		<h2 class="form-signin-heading">Sign in</h2>
		<form data-ng-submit="SendForm()" class="form-signin" >
			<label>Username:</label> <input class="form-control" type="text" data-ng-model="username" name="username" required />
			
			<label>Password:</label>  <input class="form-control" type="password" data-ng-model="password" name="pass" required />
			<br>
			<button type="submit" class="btn btn-lg btn-primary btn-block" name="submitButton" >Connect</button>
			<label data-ng-show="ShowError" style="color:red ">Please enter the username or password again!</label>	
		</form>
		<label> Not Registered? <a href="register.php">Register</a></label>
	</div>
</div>
</body>
	<script>
	var LoginModule = angular.module('project', []);
	LoginModule.controller('login',function($scope,$http)
	{
		$scope.SendForm = function()
		{
			$http.post(	"login.php",{"username":$scope.username , "pass":$scope.password} ).success(
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

