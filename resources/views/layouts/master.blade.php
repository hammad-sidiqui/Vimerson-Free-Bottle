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
        @if (trim($__env->yieldContent('template_title'))) @yield('template_title') | @endif Free Bottle &ndash; Vimerson Health
    </title>    

    @include('partials.master.head')

    <style type="text/css">
        @yield('cssscript');
    </style>

</head>

<body>

    {{-- @if(trim($__env->yieldContent('template_menu'))) 
        @include('partials.master.nav_menu')
    @else 
        @include('partials.master.nav') 
    @endif --}}

    @yield('content')

    @include('partials.master.footer_links')

    <script>        
        @yield('jsscript');

        //Set your APP_ID
        var APP_ID = 'm0xmnoxl';

        window.intercomSettings = {
            app_id: APP_ID,
        };
        
        (function(){var w=window;var ic=w.Intercom;if(typeof ic==="function"){ic('reattach_activator');ic('update',w.intercomSettings);}else{var d=document;var i=function(){i.c(arguments);};i.q=[];i.c=function(args){i.q.push(args);};w.Intercom=i;var l=function(){var s=d.createElement('script');s.type='text/javascript';s.async=true;s.src='https://widget.intercom.io/widget/' + APP_ID;var x=d.getElementsByTagName('script')[0];x.parentNode.insertBefore(s, x);};if(document.readyState==='complete'){l();}else if(w.attachEvent){w.attachEvent('onload',l);}else{w.addEventListener('load',l,false);}}})();

        // We pre-filled your app ID in the widget URL: 'https://widget.intercom.io/widget/m0xmnoxl'
        /* (function(){var w=window;var ic=w.Intercom;if(typeof ic==="function"){ic('reattach_activator');ic('update',w.intercomSettings);}else{var d=document;var i=function(){i.c(arguments);};i.q=[];i.c=function(args){i.q.push(args);};w.Intercom=i;var l=function(){var s=d.createElement('script');s.type='text/javascript';s.async=true;s.src='https://widget.intercom.io/widget/m0xmnoxl';var x=d.getElementsByTagName('script')[0];x.parentNode.insertBefore(s,x);};if(w.attachEvent){w.attachEvent('onload',l);}else{w.addEventListener('load',l,false);}}})(); */
        
    </script>

</body>

</html>
