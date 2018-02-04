<!DOCTYPE html>
<html lang="en">
	<head>
	  	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
	  	<meta name="viewport" content="width=device-width, initial-scale=1"/>
	  	<!-- CSRF Token -->
		<meta name="csrf-token" content="{{ csrf_token() }}">
	  	<title>
	  		@yield('title')
	  	</title>

	  	<!-- CSS  -->
		<link rel="stylesheet" type="text/css" href="/css/templates/portfolios/template1/app.css">

		@yield('styles')
		<script>
			window.Laravel = {!! json_encode([
				'csrfToken' => csrf_token(),
			]) !!};
		</script>
	</head>

	<body>
		<div id="app">
			@yield('content')
		</div>
		<!--  Scripts-->
		<script type="text/javascript" src="/js/templates/portfolios/template1/site/app.js"></script>
		@yield('scripts')
	</body>
</html>
