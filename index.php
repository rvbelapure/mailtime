<!DOCTYPE html>
<html lang="en">
  
  <head>
    <meta charset="utf-8">
    <title>
    </title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <!-- Le styles -->
    <link href="assets/css/bootstrap.css" rel="stylesheet">
    <link href="assets/css/bootstrap-responsive.css" rel="stylesheet">
    <link href="assets/css/custom.css" rel="stylesheet">
	<link href='http://fonts.googleapis.com/css?family=Convergence' rel='stylesheet' type='text/css'>
	<style>
      body { padding-top: 60px; /* 60px to make the container go all the way
      to the bottom of the topbar */ }
    </style>
    <!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js">
      </script>
    <![endif]-->
    <!-- Le fav and touch icons -->
    <link rel="shortcut icon" href="assets/ico/favicon.ico">
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="assets/ico/apple-touch-icon-144-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="assets/ico/apple-touch-icon-114-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="assets/ico/apple-touch-icon-72-precomposed.png">
    <link rel="apple-touch-icon-precomposed" href="assets/ico/apple-touch-icon-57-precomposed.png">
    <style>
    </style>
  </head>
  
  <body>
<div id="login-container">
	<div class="navbar navbar-fixed-top">
		<div class="navbar-inner" id="login-navbar">
			<div class="container">
			<div class="row">
				<div class="span7">
					<h1 class="style-font" style="margin-top:55px;">Welcome to <span style="color:#D90000;">MailTi.me</span></h1>
					<p class="style-font">Waste too much time checking emails? Mail Time is an uber-smart tool which analyses your email trends, and tells you exactly when you should check your email.<br/><br/> 
					<span style="color:#D90000;">Go Ahead. Give it a try!</span></p>
					<form action="login_action.php" method="post">
						Username : <input type="text" name="uname" id="username"/> <br>
						Password :&nbsp; <input type="password" name="passwd" id="password"/> <br>
						<button class="btn btn-danger" style="width:297px;" type="button" onclick="loginUser()">Analyze my email</button>
					</form>
				</div>
				<div class="span5">
					<img src="assets/img/mailtime.png" style="margin-top:75px;"/>
				</div>
			</div>
			</div>
		</div>
	</div>
</div>
<div id="user-container" style="display:none;">
	<div class="navbar navbar-fixed-top">
				<div class="navbar-inner">
					<div class="container">
						<a class="brand" href="javascript:changePage()"><b><img src="assets/img/mailtime.png" width="35px"/>MailTi.me
							</b></a>
						<div class="nav-collapse">
							<ul class="nav">
							</ul>
							<ul class="nav pull-right">
								<li class="dropdown" id="menu2">
									<a class="dropdown-toggle profile-link" data-toggle="dropdown" href="#menu2" id="user-profile">Welcome User<b class="caret"></b></a>
								</li>
							</ul>
						</div>
						<!--/.nav-collapse -->
					</div>
				</div>
			</div>

		<div class="container">
			<div class="btn-group month-buttons" style="float:right; z-index: 10; margin-top:13px;">
			  <button class="btn active" onclick="changeTimespan(this,1)">1 month</button>
			  <button class="btn" onclick="changeTimespan(this,3)">3 months</button>
			  <button class="btn" onclick="changeTimespan(this,6)">6 months</button>
			</div>
			<div id="container" style="height: 400px; margin: 0 auto"></div>
				<br/><br/>
			<div class="row">
				<div class="span5">
				<form>
					<label><strong>How many times would you like to check your email?:</strong></label>
					<div class="well">
					<select onchange="addMarker(this)">
					  <option value="1" selected="selected">1</option>
					  <option value="2">2</option>
					  <option value="3">3</option>
					  <option value="4">4</option>
					  <option value="5">5</option>
					</select>
					</div>
				</div>
				</form>
					<div class="span7" style="float:right">
					<label><strong>Your top contacts:</strong></label>
						<table class="table table-bordered">
						  <tbody>
							<tr>
							  <td>supervipul@hotmail.com</td>
							  <td>15 mails</td>
							</tr>
							<tr>
							  <td>aliuy8@gmail.com</td>
							  <td>12 mails</td>
							</tr>
							<tr>
							  <td>rvbelapure@gmail.com</td>
							  <td>9 mails</td>
							</tr>
							<tr>
							  <td>gilbert@cc.gatech.edu</td>
							  <td>6 mails</td>
							</tr>
							<tr>
							  <td>dfgdg@hotmail.com</td>
							  <td>2 mails</td>
							</tr>
						  </tbody>
						</table>
			</div>
		</div>
	</div>
</div>
<div class="modal hide" id="hourModal" tabindex="-1" role="dialog" aria-labelledby="hourModalLabel" aria-hidden="true">
	<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal" aria-hidden="true">X</button>
	<h3 id="hourModalLabel">Hourly Emails</h3>
	</div>
	<div class="modal-body" id="hourModalBody">
	
	</div>
	<div class="modal-footer">
	<button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
	</div>
</div>
	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
	<script src="http://code.highcharts.com/highcharts.js"></script>
	<script src="assets/js/mailtime.js"></script>
    <script src="assets/js/bootstrap.min.js">
    </script>
  </body>

</html>