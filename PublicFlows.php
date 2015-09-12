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
	<script type="text/javascript" src="js/PublicFlows.js"></script> 

</head>
<body data-ng-app="project"  data-ng-controller="publicflow">
	<div class="container-fluid">
		<!--  header -->
		<div>
			<ul class="nav nav-tabs"  >
				<li><label>Welcome <?php echo $_SESSION['Username'] ?></label> </li>
				<li style="margin-left: 30%;"><a href="Search.php">Search</a></li>
				<li><a href="UserFlows.php">User Flows</a></li>
				<li class="active"><a href="PublicFlows.php">Public Flows</a></li>
				<!--Logout button -->
				<li style="float:right">
					<form method="POST" action="search.php">
						<input type="submit" class="btn btn-default" name="submit" value="Logout" >
					</form>
				</li>
			</ul>
		</div>
		<div>
			<div class="modal-dialog panel-transparent" style="float:none;width:35%;" data-ng-show="(DataArray.length == 0)" >
				<div style="text-align:center">
					<h1> No Public Flows! </h1>
				</div>
			</div>
			<!-- Table -->
			<!-- Div left side - public flow name-->
			<div class="modal-dialog panel-transparent" style="float:left;width:35%;" data-ng-show="(DataArray.length > 0)" >
				<div class="modal-content panel-q-transparent" style="text-align:center">
					<table style="width: 100%">
						<tr>
							<th style="text-align: center"><label>Flow Name</label></th>
							<th style="text-align: center"><label>Flow User</label></th>
						</tr>
						<tr style="text-align:left" data-ng-repeat="x in DataArray">
							<td style="text-align: center">
								<a><span data-ng-bind="x.Name" data-ng-click="SetShowHide(x)"></span> </a>
								<div data-ng-repeat="y in x.flow" data-ng-show="x.show">
									<label><span data-ng-bind="y"></span></label>
								</div>
							</td>
							<td style="text-align: center"><span data-ng-bind="x.User_id"></span></td>
						</tr>	
					</table>
				</div>
			</div>
			<!--First arrow -->
			<div class="modal-dialog" style="width:6%;float:left;text-indent: 1em;" data-ng-show="CurrentFlowArray">
				<img src="Pic/arrowright.jpg"></img>
			</div>

			<!-- Div of the flow representation  -->
			<div class="modal-dialog panel-transparent" style="width:20%;float:left" data-ng-show="CurrentFlowArray">
				<div class="modal-content panel-q-transparent" style="text-align:center">
					<table style="width: 100%">
						<tr >
							<th style="text-align: center"><label>Flow</label></th>
							
						</tr>
						<tr style="text-align:left" data-ng-repeat="x in CurrentFlowArray">
							<td style="text-align: center"><a href="Delivery.php" data-ng-click="setDeliveryNameOnServer(x);"><span data-ng-bind="x"></a></span>
						</tr>	
					</table>
				</div>
			</div>
		</div>
	
	</div>
</body>
</html>