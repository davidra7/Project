<!DOCTYPE html>
<html>
<head>
<?php 
	include 'Params.php';
	
	checkSession(); // check if the session is OK

	
?>
	<meta charset="ISO-8859-1">
	<script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.3.15/angular.min.js"></script>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
	<link rel="stylesheet" href="css/bootstrap.css">
	<link rel="stylesheet" href="css/global.css">
	<script src="js/bootstrap.js"></script>
	<script type="text/javascript" src="js/ShowUserFlows.js"></script> 

</head>
<body data-ng-app="project"  data-ng-controller="userflow">
	
	<div class="container-fluid">
		<div>
			<ul class="nav nav-tabs"  >
				<li><label>Welcome <?php echo $_SESSION['Username'] ?></label> </li>
				<li style="margin-left: 30%;"><a href="Search.php">Search</a></li>
				<li class="active"><a href="UserFlows.php">User Flows</a></li>
				<li><a href="PublicFlows.php">Public Flows</a></li>
				
				<li style="float:right">
					<form method="POST" action="search.php">
						<input type="submit" class="btn btn-default" name="submit" value="Logout" >
					</form>
				
				</li>
			</ul>
		</div>
		<!-- show the data -->
		<div style="text-align:center">
			<div class="modal-dialog panel-transparent" style="float:left;width:10%">
				<div class="modal-content panel-q-transparent" >
					<br>
					<label data-ng-click="SetFlowType('Personal')">Personal Flows</label>
					<br>
					<label data-ng-click="SetFlowType('Custom')">Custom Flows</label>
					<br>
					<label data-ng-click="SetFlowType('Wishlist')">Wishlist Flows</label>
					<br><br>
				</div>
			</div>
			<div class="modal-dialog panel-transparent" style="float:left;width:35%;" data-ng-show="(ActiveTypeNameID.length == 0)" >
				<div style="text-align:center">
					<h1> No Flows! </h1>
				</div>
			</div>
			<!--First arrow -->
			<div class="modal-dialog" style="float:left;width:8%" data-ng-show="(ActiveTypeNameID.length > 0)">
				<br>
				<img src="Pic/arrowright.jpg"></img>
			</div>
			<div class="modal-dialog panel-transparent" style="width:20%;float:left" data-ng-show="(ActiveTypeNameID.length > 0)">
				<div class="modal-content panel-q-transparent" style="text-align:left">
					<div>
						<label >Flow Name </label>
						<br>
					</div>
					<div data-ng-repeat="x in ActiveTypeNameID">
						<a data-ng-click="SetCurrentFlow(x)"><span data-ng-bind="x.Name"></span></a>
						<a data-ng-show="((ActiveTypeNameID == CustomFlowsNameID)&& !x.Public)" style="float:right" data-ng-model="Public" data-ng-click="SetAsPublic(x,1)">Set as Public</a>
						<a data-ng-show="((ActiveTypeNameID == CustomFlowsNameID) && x.Public)" style="float:right" data-ng-model="UnPublic" data-ng-click="SetAsPublic(x,0)">Set as UnPublic</a>
					</div>
				</div>
			</div>
			<!--Second Arrow --> 
			<div class="modal-dialog" style="float:left;width:8%" data-ng-show="(CurrentIndex > -1)">
				<br>
				<img src="Pic/arrowright.jpg"></img>
			</div>
			<div class="modal-dialog panel-transparent" style="width:40%;float:left" data-ng-show="(CurrentIndex > -1)">
				<div class="modal-content panel-q-transparent" style="text-align:center">
					<div>
						<label>Flow Name: <span data-ng-bind="ActiveTypeNameID[CurrentIndex].Name"></span></label>
					</div>
					<div data-ng-repeat="delivery in CurrentFlow">
						<label> <span data-ng-bind="delivery"></span></label>
						<a href="" data-ng-show="(ActiveTypeNameID == CustomFlowsNameID)" data-ng-click="MoveUp($index,delivery)"><img src="Pic\green.jpg"></a>
						<a href="" data-ng-show="(ActiveTypeNameID == CustomFlowsNameID)" data-ng-click="MoveDown($index,delivery)"><img src="Pic\red.jpg"></a>
						<a href="" data-ng-show="(ActiveTypeNameID == CustomFlowsNameID)" data-ng-click="Delete($index,delivery)"><img src="Pic\x.jpg"></a>
						<br>
					</div>
				</div>
			</div>
		</div>
	</div>
</body>
</html>