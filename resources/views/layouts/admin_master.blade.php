<!DOCTYPE html>
<html lang="en">
<head>
    
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- favicon -->
    <link rel="icon" type="image/png" sizes="16x16" href="{{asset('images/favicon.png')}}">

    <!-- title -->
    <title>
        @if (trim($__env->yieldContent('template_title'))) @yield('template_title') | @endif Free Bottle &ndash; Admin Side Vimerson Health
    </title>    

    @include('partials.admin_master.head')

    <style type="text/css">
        @yield('cssscript');
    </style>

</head>

<body>

    @yield('content')

    @include('partials.admin_master.footer_links')

    <script>        
        @yield('jsscript');
    </script>

</body>

</html>
