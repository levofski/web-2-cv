<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>CV</title>
    <!-- bower:css -->
    <link rel='stylesheet' href='vendor/angular-xeditable/dist/css/xeditable.css' />
    <!-- endbower -->
    <link rel='stylesheet' href='css/main.css' />
	<!-- Fonts -->
	<link href='//fonts.googleapis.com/css?family=Roboto:400,300' rel='stylesheet' type='text/css'>
</head>
<body>
	<nav class="navbar navbar-default">
		<div class="container-fluid">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
					<span class="sr-only">Toggle Navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<a class="navbar-brand" href="#">CV</a>
			</div>

			<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
				<ul class="nav navbar-nav">
					<li><a href="/">Home</a></li>
				</ul>

				<ul class="nav navbar-nav navbar-right">
					@if (Auth::guest())
						<li><a href="/auth/login">Login</a></li>
						<li><a href="/auth/register">Register</a></li>
					@else
						<li class="dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">{{ Auth::user()->name }} <span class="caret"></span></a>
							<ul class="dropdown-menu" role="menu">
								<li><a href="/auth/logout">Logout</a></li>
							</ul>
						</li>
					@endif
				</ul>
			</div>
		</div>
	</nav>
	@yield('content')
    <!-- bower:js -->
    <script src="vendor/jquery/dist/jquery.js"></script>
    <script src="vendor/angular/angular.js"></script>
    <script src="vendor/bootstrap/dist/js/bootstrap.js"></script>
    <script src="vendor/angular-route/angular-route.js"></script>
    <script src="vendor/angular-ui-router/release/angular-ui-router.js"></script>
    <script src="vendor/angular-xeditable/dist/js/xeditable.js"></script>
    <script src="vendor/ace-builds/src-min-noconflict/ace.js"></script>
    <script src="vendor/ace-builds/src-min-noconflict/mode-json.js"></script>
    <script src="vendor/ace-builds/src-min-noconflict/worker-json.js"></script>
    <script src="vendor/ace-builds/src-min-noconflict/mode-html.js"></script>
    <script src="vendor/ace-builds/src-min-noconflict/worker-html.js"></script>
    <script src="vendor/angular-ui-ace/ui-ace.js"></script>
    <script src="vendor/angular-ui-bootstrap/src/modal/modal.js"></script>
    <!-- endbower -->
    <script src="js/main.js"></script>
</body>
</html>
