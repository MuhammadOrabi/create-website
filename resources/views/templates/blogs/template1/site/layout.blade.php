<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>
        @yield('title')
    </title>
    <!-- CSS -->
    <link rel="stylesheet" type="text/css" href="/css/templates/blogs/template1/app.css">

    <script>
        window.Laravel = {!!json_encode([
                'csrfToken' => csrf_token(),
            ]) !!
        };
    </script>
</head>

<body>
    <div class="row">
        @include($site->theme->location . '.site._includes.nav')
        <div class="row content_row">
            @yield('content') @include($site->theme->location . '.site._includes.sidebar')
        </div>
        @include($site->theme->location . '.site._includes.footer')
    </div>
    <!-- END Container ROW-->
    <script src="/js/templates/blogs/template1/site/app.js"></script>
</body>

</html>