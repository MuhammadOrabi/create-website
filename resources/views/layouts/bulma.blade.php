<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- CSRF Token -->
		<meta name="csrf-token" content="{{ csrf_token() }}">

        <title>@yield('title')</title>
        <link rel="stylesheet" href="/css/bulma/app.css">
        @yield('styles')

        <script>
			window.Laravel = {!! json_encode([
				'csrfToken' => csrf_token(),
			]) !!};
		</script>
    </head>
    <body>
        <div id="app">
            @yield('nav')
            <div class="container">
                @yield('content')
            </div>
        </div>
        <script src="/js/bulma/app.js"></script>
        @yield('scripts')        
    </body>
</html>