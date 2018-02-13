<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- CSRF Token -->
		<meta name="csrf-token" content="{{ csrf_token() }}">

        <title>
            @yield('title') - Create Website
        </title>
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
            @include('home-page._includes.nav.bulma-nav')
            @include($site->theme->location.'.dashboard._includes.left-sidebar')
            <div class="managment-area">
                <div class="flex-container">
                    @yield('content')
                </div>
            </div>
            @include('home-page._includes.nav.right-sidebar')
        </div>
        <script src="/js/templates/websites/bizlight/app.js"></script>
        @include('notifications.toast')
        @yield('scripts')        
    </body>
</html>