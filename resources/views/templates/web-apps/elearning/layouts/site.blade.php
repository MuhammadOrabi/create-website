<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- CSRF Token -->
		<meta name="csrf-token" content="{{ csrf_token() }}">

        <title>@yield('title') {{ $site->name }}</title>
        <link rel="stylesheet" href="/css/bulma/app.css">
        @yield('styles')
        <script>
			window.Laravel = {!! json_encode([
				'csrfToken' => csrf_token(),
			]) !!};
		</script>
    </head>
    <body>
        <div id="app" style="display: none;" >
            @include($site->theme->location.'.site._includes.nav')
            <app slug="{{ $slug }}" address="{{ $site->address }}">
                <div slot="content" class="m-b-100">
                    @yield('content')
                </div>
            </app>
            <site-footer address="{{ $site->address }}" id="{{ $site->constants->where('type', 'footer')->first()->id }}"></site-footer>
            @include($site->theme->location.'.site._includes.right-sidebar')    
        </div>
        <script src="/js/templates/web-apps/elearning/app.js"></script>
        @include('notifications.toast')
        @yield('scripts')
        <script type="text/javascript">
			window.onload = function () {
				var app = document.getElementById('app');
				app.style.display = '';
			}
		</script>
    </body>
</html>