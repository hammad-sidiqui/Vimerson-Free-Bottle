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
        Free Bottle &ndash; Vimerson Health
    </title>   

    <!-- Bootstrap -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- admin stylesheet -->
    <link rel="stylesheet" type="text/css" href="{{asset('css/admin.css')}}">
    <!-- plugins stylesheet -->
    <link rel="stylesheet" type="text/css" href="{{asset('css/plugin.min.css')}}">

    <!-- select 2 -->
    <link href="{{asset('css/select2.min.css')}}" rel="stylesheet"/>

    <style type="text/css">
        @import url(https://fonts.googleapis.com/css?family=Raleway:300,400,600);

        body {
            margin: 0;
            font-size: .9rem;
            font-weight: 400;
            line-height: 1.6;
            color: #212529;
            text-align: left;
            background-color: #f5f8fa;
        }

        .navbar-laravel {
            box-shadow: 0 2px 4px rgba(0, 0, 0, .04);
            display: none;
        }

        .navbar-brand,
        .nav-link,
        .my-form,
        .login-form {
            font-family: Raleway, sans-serif;
        }

        .my-form {
            padding-top: 1.5rem;
            padding-bottom: 1.5rem;
        }

        .my-form .row {
            margin-left: 0;
            margin-right: 0;
        }

        .login-form {
            padding-top: 1.5rem;
            padding-bottom: 1.5rem;
        }

        .login-form .row {
            margin-left: 0;
            margin-right: 0;
        }
    </style>
</head>

<body>
    @include('partials.admin_master.nav')

    <div class="wrapper">
        
        @include('partials.admin_master.sidebar')

        <div class="content-page">        
            @yield('content')
        </div>
    </div>    

    @include('partials.admin_master.footer')

    @include('partials.admin_master.footer_links')

    <script>
        @yield('jsscript');
    </script>

</body>

</html>