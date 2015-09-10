<!DOCTYPE html>
<html >
<?php 
	include 'Params.php';
	checkSession();
	// if the logout button was pressed - move to index.php
	if(isset($_POST['submit'] ))
	{
		$_SESSION['Username'] = null;
		header('Location: index.php');
	}
	
?>
<head>
<meta charset="ISO-8859-1">
<script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.3.15/angular.min.js"></script>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<link rel="stylesheet" href="css/bootstrap.css">
<link rel="stylesheet" href="css/global.css">
<script src="js/bootstrap.js"></script>
<script type="text/javascript" src="js/Search.js"></script> 
<title>Search</title>
</head>
<body data-ng-app="project" data-ng-controller="search">
	<div class="container-fluid">
		<!-- header -->
		<div>
			<ul class="nav nav-tabs"  >
				<li><label>Welcome <?php echo $_SESSION['Username'] ?></label> </li>
				<li class="active" style="margin-left: 30%;"><a href="#">Search</a></li>
				<li><a href="UserFlows.php">User Flows</a></li>
				<li><a href="PublicFlows.php">Public Flows</a></li>
				<!--Logout button -->
				<li style="float:right">
					<form method="POST" action="search.php">
						<input type="submit" class="btn btn-default" name="submit" value="Logout" >
					</form>
				</li>
			</ul>
		</div>
		<!-- Search -->
		<div class="modal-dialog panel-transparent" ><!-- more details --> 
			<div class="modal-content panel-q-transparent">
				<br>
				<form data-ng-submit="Search()" >
					<input type="text" data-ng-model="Searchfield" class="form-control" style="width:70%;margin:auto;" placeholder="Search" required />
					<br>
					<label>Elements:</label>
					<div class="btn-group" data-toggle="buttons">
						<label class="btn btn-primary" data-ng-click="CheckBoxPressButton('delivery');"><input type="checkbox" data-ng-model="delivery" >Delivery </label>
						<label class="btn btn-primary" data-ng-click="CheckBoxPressButton('d2k');"><input type="checkbox" data-ng-model="d2k" >D2K</label>
						<label class="btn btn-primary" data-ng-click="CheckBoxPressButton('term');"><input type="checkbox" data-ng-model="term" >Term</label>
						<label class="btn btn-primary" data-ng-click="CheckBoxPressButton('scope');"><input type="checkbox" data-ng-model="scope" >Scope</label>
					</div>
					
					<label>Search In:</label>
					<div class="btn-group" data-toggle="buttons">
						<label class="btn btn-primary" data-ng-click="CheckBoxPressButton('title');"><input type="checkbox" data-ng-model="title" >Title</label>
						<label class="btn btn-primary" data-ng-click="CheckBoxPressButton('description');"><input type="checkbox" data-ng-model="description" >Description</label>
					</div>
					<br><br>
					<div style="width:70%;margin:auto;">
						<input type="submit" class="btn btn-primary" style="width:100%;"  value="Search" >
					</div>
				</form>	
				<br>
			</div>
		</div>
		<!-- End of search -->
		<!-- Show Type In the Left side 
		<div style="text-align:center" data-ng-show="SearchDone">
			<div class="modal-dialog panel-transparent" style="float:left;width:10%">
				<div class="modal-content panel-q-transparent" >
					<div>
						<label >Found In:</label>
					</div>
					
					<div data-ng-show="((resultDeliveries.length == 0) && (resultD2k.length == 0) && (resultTerm.length == 0) && (resultScope.length == 0))">
						<label>Not Found!</label>
					</div>
					<div>
						<label data-ng-show="(delivery && SearchDone )&& (resultDeliveries.length > 0)" data-ng-click="ShowFlag('DELIVERY');">Delivery</label>
					</div>
					<div>
						<label data-ng-show="(d2k && SearchDone && (resultD2k.length > 0))" data-ng-click="ShowFlag('D2K');">D2K</label>
					</div>
					<div>
						<label data-ng-show="(term && SearchDone && (resultTerm.length > 0))" data-ng-click="ShowFlag('TERM');" >Term</label>
					</div>
					<div>
						<label data-ng-show="(scope && SearchDone && (resultScope.length > 0))" data-ng-click="ShowFlag('SCOPE');">Scope</label>
					</div>
				</div>
			</div>
		</div>
		<!-- Show results DELIVERIES -->
		<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true" style="width:60%;margin:auto">
			<div data-ng-repeat="ob in resultDeliveries" >
				<div class="panel panel-default">
					<div class="panel-heading" role="tab">
					  <h4 class="panel-title">
						<a role="button" data-toggle="collapse" data-parent="#accordion" href="#{{$index}}" aria-expanded="false" aria-controls="{{$index}}">
							<label>{{ob.TITLE}}<label>
						</a>
					  </h4>
					</div>
					<div id="{{$index}}" class="panel-collapse collapse" role="tabpanel">
						<div class="panel-body">
							<label>{{ob.DESCRIPTION}} </label>
							<br><br>
							<div style="text-align:center">
									<input class="btn btn-primary" style="width:70%;" value="Get Flow" data-ng-click="SaveFlowIDInSession(ob.UID)">
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>		<!-- End of show results -->
	</div><!--End container-fluid -->
	
</body>
</html>
