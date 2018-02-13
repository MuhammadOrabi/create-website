<!doctype html>
<html lang="{{ app()->getLocale() }}">
	<head>
		<title>Dashboard - Create Website</title>
		<!-- Required meta tags -->
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<!-- CSRF Token -->
		<meta name="csrf-token" content="{{ csrf_token() }}">
		<!-- Bootstrap CSS -->
		<link rel="stylesheet" type="text/css" href="/css/templates/websites/bizlight/app.css">
		<script>
			window.Laravel = {!! json_encode([
				'csrfToken' => csrf_token(),
			]) !!};
		</script>
	</head>
	<body>
		<div id="app">
			@include($site->theme->location.'.dashboard._includes.nav')
			<div class="container-fluid">
				<div class="row">
					@include($site->theme->location.'.dashboard._includes.side-nav')
					<main role="main" class="col-sm-9 ml-sm-auto col-md-10 pt-3">
						@yield('content')
					</main>
				</div>
			</div>
		</div>

		<!-- Optional JavaScript -->
		<!-- jQuery first, then Popper.js, then Bootstrap JS -->
		<script type="text/javascript" src="/js/templates/websites/bizlight/app.js"></script>		
	</body>
</html>