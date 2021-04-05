<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>{{ config('app.name', 'Grateful') }}</title>
        <!-- Scripts -->
        <script src="{{ asset('js/app.js') }}" defer></script>
        <script type="application/javascript" src="/js/jQuery.min.js"></script>
        <script type="application/javascript" src="/js/lazyload.min.js"></script>
        <script src="{{ asset('js/matchHeight.js') }}" defer></script>
        <!-- Fonts -->
        <link rel="dns-prefetch" href="//fonts.gstatic.com">
        <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
        <!-- Styles -->
        {{-- <link href="{{ asset('css/app.css') }}" rel="stylesheet"> server --}}
        <link href="/css/app.css" rel="stylesheet">
    </head>
    <body>
        <main>
            @include('includes.navbar')
            @include('includes.messages')
            @yield('jumbotron')
            <div class="container">

                    <!-- Loader -->
                    <div class="loader-bg">
                      <div class="lds-ripple"><div></div><div></div></div>
                    </div>

                @yield('content')
                @yield('scripts')

            <script type="text/javascript">
                $(document).ready(function(){

                  $(".loader-bg").fadeOut("slow");

                });
            </script>
            
        </main>
        @include('includes.footer')
    </body>
</html>