<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" href="css/bootstrap.css">
<link rel="stylesheet" type="text/css" href="css/myCss.css" />
<link rel="stylesheet" type="text/css" href="css/tree.css" /> <!-- use the first level tree -->
<?php 
	include 'Params.php';
	
	checkSession(); // check if the session is OK
	if ( !isset( $_SESSION['ID'] ))
	{
		$_SESSION['ID'] = null;
		header('Location: search.php');
	}

	
?>
	<script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.3.15/angular.min.js"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
	<link rel="stylesheet" href="css/global.css">
	<script src="js/bootstrap.js"></script>
	<script type="text/javascript" src="js/Delivery.js"></script> 
	<script type="text/javascript" src="js/EntityDetails.js"></script> 
	<title>Insert title here</title>
</head>
<body data-ng-app="project"  data-ng-controller="delivery" >
	<div class="container-fluid">
		<!-- header -->
		<div>
			<ul class="nav nav-tabs"  >
				<li><label>Welcome <?php echo $_SESSION['Username'] ?></label> </li>
				<li  style="margin-left: 30%;"><a href="Search.php">Search</a></li>
				<li><a href="UserFlows.php">User Flows</a></li>
				<li><a href="PublicFlows.php">Public Flows</a></li>
				<li class="active"><a href="#">Delivery</a></li>
				<!--Logout button -->
				<li style="float:right">
					<form method="POST" action="search.php">
						<input type="submit" class="btn btn-default" name="submit" value="Logout" >
					</form>
				</li>
			</ul>
		</div>
		<!-- End Header -->
	
		<!-- Primary window -->
		<div class="modal-dialog panel-transparent" style="width:80%;margin-top:0cm" ><!-- more details --> 
			<div class="modal-content panel-q-transparent">
				<div class="modal-header">
					<button class="delivery_status" data-ng-click="MarkAsWatched(entities_details.name)"> <img data-ng-src={{current_deliv_status_img}} /></button>
					<h1 class="text-center">{{ entities_details.name }} <!--, Type: <span data-ng-bind="entities_details.type" ></span> --></h1>
				</div>
				<div> <!-- upper side of the window -->
					<!-- Description -->
					<div> 
						<label class="text-center">Description : <span data-ng-bind="entities_details.description" ></span></label>
					</div>
					<!-- End Description -->
					<!-- Display of kbits needed,provided term and scope -->
					<div class="modal-body" style="width:40%;float:left;display:inline-block;" >
						<div>
							<label class="text-center">Kbits_needed:</label>
						</div>
						<div class="hoffset1" data-ng-repeat="x in entities_details.kbits_needed" >
							<!-- <button type="button" class="btn btn-danger" data-ng-bind="x" data-ng-click="ChangeKbitStatus(x,1)"></button>	-->
							<span class="kbit_style" data-ng-bind="x.name" ></span>
							<button class="btn_kbit_v_not_pressed" data-ng-click="MarkKbit('v', x.name, x.index, 'needed')" data-ng-hide="x.is_status_v">V</button>
							<button class="btn btn_kbit_v_pressed disabled" data-ng-show="x.is_status_v">V</button>
							<button class="btn_kbit_x_not_pressed" data-ng-click="MarkKbit('x', x.name, x.index, 'needed')" data-ng-hide="x.is_status_x">X</button>
							<button class="btn btn_kbit_x_pressed disabled" data-ng-show="x.is_status_x">X</button>
							<button class="btn_kbit_q_not_pressed" data-ng-click="MarkKbit('q', x.name, x.index, 'needed')" data-ng-hide="x.is_status_q">?</button>
							<button class="btn btn_kbit_q_pressed disabled" data-ng-show="x.is_status_q">?</button>
							<br><br>
						</div>
						<div>
							<label class="text-center">Kbits_provided:</label>
						</div>
						<div class="hoffset1" data-ng-repeat="x in entities_details.kbits_provided" >
							<span class="kbit_style" data-ng-bind="x.name" ></span>
							<button class="btn_kbit_v_not_pressed btn-default" data-ng-click="MarkKbit('v', x.name, x.index, 'provided')" data-ng-hide="x.is_status_v">V</button>
							<button class="btn btn_kbit_v_pressed disabled btn-default" data-ng-show="x.is_status_v">V</button>
							<button class="btn_kbit_x_not_pressed btn-default" data-ng-click="MarkKbit('x', x.name, x.index, 'provided')" data-ng-hide="x.is_status_x">X</button>
							<button class="btn btn_kbit_x_pressed disabled btn-default" data-ng-show="x.is_status_x">X</button>
							<button class="btn_kbit_q_not_pressed btn-default" data-ng-click="MarkKbit('q', x.name, x.index, 'provided')" data-ng-hide="x.is_status_q">?</button>
							<button class="btn btn_kbit_q_pressed disabled btn-default" data-ng-show="x.is_status_q">?</button>
							<br><br>
						</div>
					</div>
					<!-- End display kbit ,scope & term -->
					<!-- right side -->
					<div style="margin-left:51%;">
						<div><!-- Save Flow options -->
							<!-- Button of add to existing Flow -->
							<div style="float:left">
								<button class="btn btn-primary btn-xs" data-ng-click="ShowNameAndDelivery()">Add To Custom Flow</button>
							</div>
							<!-- end exsisting flow -->
							<!-- if the button add to existing flow button pressed we show the list of the currecnt flow of the user and the ability to add new flow  -->
							<div data-ng-show="ShowCustomFlowAddingFlag">
								<div class="form-inline">
									<label>User Flows:</label>
									<select class="form-control input-xs" style="width:100px" data-ng-options="option for option in UserFlowNames" data-ng-model="ComboBoxPersonalFlows" data-ng-change="ComboBoxPersonalFlowHandler()"  required ></select>
									<button class="btn btn-default btn-xs" data-ng-click="AddCustomFlow()">Save</button>
								</div>			      				
								<div class="form-inline" style="margin-left:125px"data-ng-show="NewFlowShowFlag">
									<label>Flow Name:</label>  <input style="width:100px" type="text" class="form-control input-xs" data-ng-model="NewFlowName"  />
								</div>
							</div>
						</div>
						<br><br>
						<!-- Show user personal comments -->
						<div>
							<label class="text-center">Personal comments: </label>
								<div>
									<textarea data-ng-model="UserComments" style="width:95%;height:90px;background-color:#D0F18F;color:#53760D;font:16px/24px cursive; resize: none;" name="comments" id="comments"></textarea>
								</div>
								<button style="float:right" class="btn btn-default " data-ng-click="setUserCommentsPerDelivery(entities_details.name, UserComments)">Submit Comment</button>
							<br><br>
						</div>
						<!-- Deliveries Related & terms & scope -->
						<div>
							<div >
								<label class="text-center">Deliveries_related: <span data-ng-bind="entities_details.deliveries_related" ></span></label>
							</div>
							<div>
								<label class="text-center">Terms: <span data-ng-bind="entities_details.terms" ></span></label>	
							</div>
							<div>
								<label class="text-center">Scope: <span data-ng-bind="entities_details.scope" ></span></label>
							</div>
						</div>
					</div>
					<!-- End Save Flow Options  -->
				</div>
				<br><br>
				
				<div class="modal-body">
					<!-- Show First Level Tree of pressed delivery -->
					<div style="float:left">
						<label class="">First Level Tree:</label><br>
					</div>
					<div class="tree" style="margin:auto;">
						<ul>
							<li>
								<a ><span data-ng-bind="entities_details.name" ></span></a>
								<ul>
									<li data-ng-repeat="x in entities_details.kbits_needed">
										<a ng-click="ShowEntityFirstLevelTree(x.name, 'kbit')" style="background-color:#FF9999" ><span data-ng-bind="x.name" ></span></a>
									</li>
									<li data-ng-repeat="x in entities_details.kbits_provided">
										<a ng-click="ShowEntityFirstLevelTree(x.name, 'kbit')" style="background-color:#66FF66"><span data-ng-bind="x.name" ></span></a>
									</li>
									<li data-ng-repeat="x in entities_details.deliveries_related">
									<div class="tooltip-wrap3">
										<a href="Delivery.php" ng-mouseover="GetDeliveryInFLTWatchedStatus(x)" data-ng-click="setDeliveryNameOnServer(x)" style="background-color:#00CCFF"><span data-ng-bind="x"></span></a>
										<div class="tooltip-content3">
												<img class="eye_size" data-ng-src={{FLT_deliv_status_img}}>
											</div>
										</div> 
									</li>
									<li data-ng-repeat="x in entities_details.terms">
										<a ng-click="ShowEntityFirstLevelTree(x, 'term')" style="background-color:#FFCC00"><span data-ng-bind="x" ></span></a>
									</li>
									<li data-ng-repeat="x in entities_details.scope">
										<a ng-click="ShowEntityFirstLevelTree(x, 'scope')" style="background-color:#CC99CC"><span data-ng-bind="x" ></span></a>
									</li>
								</ul>
							</li>
						</ul>
					</div>
					<br><br>
					<div style="margin:auto; margin-top: 2cm;margin-bottom: 2cm;">
						<div style="float:left">
							<label data-ng-show="ShowFirstLevelTree">Entity First Level Tree: </label>
						</div>
						<!-- Show First Level Tree of pressed entity (kbit/term/scope) -->
						<div class="tree" data-ng-show="ShowFirstLevelTree">
							<ul>
								<li>
									<a ><span data-ng-bind="entity_to_view_flt.name" ></span></a>
									<ul>
										<li data-ng-repeat="x in entity_to_view_flt.kbits_related">
										<div class="tooltip-wrap">
											<a ng-mouseover="GetKbitStatus(x.name)" style="background-color:#FF9999"><span data-ng-bind="x.name"></span></a>
											<div class="tooltip-content">
												<button class="btn_kbit_v_not_pressed" data-ng-click="MarkKbit('v', x.name)" data-ng-hide="x.is_status_v">V</button>
												<button class="btn btn_kbit_v_pressed disabled" data-ng-show="x.is_status_v">V</button>
												<button class="btn_kbit_x_not_pressed" data-ng-click="MarkKbit('x', x.name)" data-ng-hide="x.is_status_x">X</button>
												<button class="btn btn_kbit_x_pressed disabled" data-ng-show="x.is_status_x">X</button>
												<button class="btn_kbit_q_not_pressed" data-ng-click="MarkKbit('q', x.name)" data-ng-hide="x.is_status_q">?</button>
												<button class="btn btn_kbit_q_pressed disabled" data-ng-show="x.is_status_q">?</button>
											</div>
										</div>
										</li>
										<li data-ng-repeat="x in entity_to_view_flt.deliveries_related">
										<div class="tooltip-wrap3">
											<a href="Delivery.php" ng-mouseover="GetDeliveryInFLTWatchedStatus(x)" style="background-color:#00CCFF"><span data-ng-bind="x" data-ng-click="setDeliveryNameOnServer(x)"></span></a>
											<div class="tooltip-content3">
												<img class="eye_size" data-ng-src={{FLT_deliv_status_img}}>
											</div>
										</div> 
										</li>
										<li data-ng-repeat="x in entity_to_view_flt.terms">
											<a style="background-color:#FFCC00"><span data-ng-bind="x" ></span></a>
										</li>
										<li data-ng-repeat="x in entity_to_view_flt.scope">
											<a style="background-color:#CC99CC"><span data-ng-bind="x" ></span></a>
										</li>
									</ul>
								</li>
							</ul>
						</div>
					</div>
				</div>
				<br><br><br>
				<div style="text-align:center">
					<iframe style="width:70%;height:500px;" data-ng-src="{{ entities_details.url }}"></iframe>
					
				</div>
				
			</div>
		</div>

	</div>	
</body>


</html>


