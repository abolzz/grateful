<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>

        <!-- Global site tag (gtag.js) - Google Analytics -->
        <script async src="https://www.googletagmanager.com/gtag/js?id=UA-138741693-1"></script>
        <script>
          window.dataLayer = window.dataLayer || [];
          function gtag(){dataLayer.push(arguments);}
          gtag('js', new Date());

          gtag('config', 'UA-138741693-1');
        </script>

        <!-- Raygun <--></-->
        <script type="text/javascript">
          !function(a,b,c,d,e,f,g,h){a.RaygunObject=e,a[e]=a[e]||function(){
          (a[e].o=a[e].o||[]).push(arguments)},f=b.createElement(c),g=b.getElementsByTagName(c)[0],
          f.async=1,f.src=d,g.parentNode.insertBefore(f,g),h=a.onerror,a.onerror=function(b,c,d,f,g){
          h&&h(b,c,d,f,g),g||(g=new Error(b)),a[e].q=a[e].q||[],a[e].q.push({
          e:g})}}(window,document,"script","//cdn.raygun.io/raygun4js/raygun.min.js","rg4js");
        </script>
        
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

        <meta property="og:locale" content="en_GB" />
        <meta property="og:type" content="website" />
        <meta property="og:title" content="Page Title Here" />
        <meta property="og:description" content="Page Description" />
        <meta property="og:url" content="http://www.example.com/" />
        <meta property="og:site_name" content="Example" />
        <meta property="og:image" content="http://www.example.com/image-here.jpg" />
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

                    <div class="d-none" id="cookie-banner">
                        <div>
                             <span>
                                    Šī vietne izmanto sīkdatnes (cookies). Lietojot to, Jūs piekrītat to izmantošanai.
                             </span>
                             <span id="consent-cookies">
                                    Aizvērt
                             </span>
                        </div>
                    </div>

                @yield('content')
                @yield('scripts')

            <script type="text/javascript">
                $(document).ready(function(){

                  $(".loader-bg").fadeOut("slow");

                    function getCookie(cname) {
                        const name = cname + "=";
                        const decodedCookie = decodeURIComponent(document.cookie);
                        const ca = decodedCookie.split(';');

                        for(let i = 0; i < ca.length; i++) {
                            let c = ca[i];
                            while (c.charAt(0) === ' ') {
                                c = c.substring(1);
                            }
                            if (c.indexOf(name) === 0) {
                                return c.substring(name.length, c.length);
                            }
                        }

                        return "";
                    }

                    function setCookie(cname, cvalue, exdays) {
                        const d = new Date();

                        d.setTime(d.getTime() + (exdays*24*60*60*1000));

                        const expires = "expires="+ d.toUTCString();

                        document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
                    }

                    const cookieBanner = document.querySelector('#cookie-banner');
                    const hasCookieConsent = getCookie('cookies-consent');

                    if (!hasCookieConsent) {
                        cookieBanner.classList.remove('d-none');
                    }

                    const consentCta = cookieBanner.querySelector('#consent-cookies');

                    consentCta.addEventListener('click', () => {
                        cookieBanner.classList.add('d-none');
                        setCookie('cookies-consent', 1, 365);
                    });

                });
            </script>

        </main>
        @include('includes.footer')


        <script type="text/javascript">
          rg4js('apiKey', 'X9udvzO6wA4Jo8IKeEiiZg');
          rg4js('enablePulse', true);
        </script>
    </body>
</html>