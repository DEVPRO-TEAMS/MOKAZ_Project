{{-- <!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ config('app.name', 'Laravel') }}
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav me-auto">

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ms-auto">
                        <!-- Authentication Links -->
                        @guest
                            @if (Route::has('login'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                                </li>
                            @endif

                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }}
                                </a>

                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>


                            <div>
                                <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                            </div>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        

        <main class="py-4">
            @yield('content')
        </main>
    </div>
</body>
</html> --}}

<!DOCTYPE html>

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en-US" lang="en-US">

    <head>
        <meta charset="utf-8">
        <title>MOKAZ - Plateforme Immobilier</title>

        <meta name="author" content="themesflat.com">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
        <!-- font -->
        <link rel="stylesheet" href="{{ asset('assets/fonts/fonts.css') }}">
        <!-- Icons -->
        <link rel="stylesheet" href="{{ asset('assets/fonts/font-icons.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/css/apexcharts.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/css/swiper-bundle.min.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/css/animate.css') }}">
        <link rel="stylesheet"type="text/css" href="{{ asset('assets/css/styles.css') }}" />
        <link rel="stylesheet"type="text/css" href="{{ asset('assets/css/custom.css') }}" />
        <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
        <link rel="stylesheet" href="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.css" />
        <!-- Favicon and Touch Icons  -->
        <link rel="shortcut icon" href="{{ asset('assets/images/logo/favicon.png') }}">
        <link rel="apple-touch-icon-precomposed" href="{{ asset('assets/images/logo/favicon.png') }}">

    </head>

    <body class="body bg-surface counter-scroll">

        <div class="preload preload-container">
            <div class="boxes ">
                <div class="box">
                    <div></div>
                    <div></div>
                    <div></div>
                    <div></div>
                </div>
                <div class="box">
                    <div></div>
                    <div></div>
                    <div></div>
                    <div></div>
                </div>
                <div class="box">
                    <div></div>
                    <div></div>
                    <div></div>
                    <div></div>
                </div>
                <div class="box">
                    <div></div>
                    <div></div>
                    <div></div>
                    <div></div>
                </div>
            </div>
        </div>

        <!-- /preload -->

        <div id="wrapper">
            <div id="page" class="clearfix">
                <div class="layout-wrap">
                    <!-- sidebar dashboard -->
                    @include('layouts.sidbar')
                    <!-- end sidebar dashboard -->
                    <div class="container-fluid" style="margin-top: 6%">
                        <div class="main-content">
                            @yield('content')
                        </div>
                        <div class="footer-dashboard">
                            <p class="text-variant-2">©2025 MOKAZ. Tous droits réservés.</p>
                        </div>
                    </div>
                    <div class="overlay-dashboard"></div>
                </div>
            </div>
        </div>

        <!-- /#page -->
        
        <!-- go top -->
        <div class="progress-wrap">
            <svg class="progress-circle svg-content" width="100%" height="100%" viewBox="-1 -1 102 102">
                <path d="M50,1 a49,49 0 0,1 0,98 a49,49 0 0,1 0,-98"
                    style="transition: stroke-dashoffset 10ms linear 0s; stroke-dasharray: 307.919, 307.919; stroke-dashoffset: 286.138;">
                </path>
            </svg>
        </div>

        <!-- Javascript -->

        <script src="https://kit.fontawesome.com/2b6a213e82.js" crossorigin="anonymous"></script>

        <script type="text/javascript" src="{{ asset('assets/js/bootstrap.min.js') }}"></script>
        <script type="text/javascript" src="{{ asset('assets/js/jquery.min.js') }}"></script>
        <script type="text/javascript" src="{{ asset('assets/js/swiper-bundle.min.js') }}"></script>
        <script type="text/javascript" src="{{ asset('assets/js/carousel.js') }}"></script>
        <script type="text/javascript" src="{{ asset('assets/js/plugin.js') }}"></script>
        <script type="text/javascript" src="{{ asset('assets/js/chart.js') }}"></script>
        <script type="text/javascript" src="{{ asset('assets/js/chart-init.js') }}"></script>
        <script type="text/javascript" src="{{ asset('assets/js/jquery.nice-select.min.js') }}"></script>
        <script type="text/javascript" src="{{ asset('assets/js/rangle-slider.js') }}"></script>
        <script type="text/javascript" src="{{ asset('assets/js/countto.js') }}"></script>
        <script type="text/javascript" src="{{ asset('assets/js/tinymce/tinymce.min.js')}}"></script>
        <script type="text/javascript" src="{{ asset('assets/js/tinymce/tinymce-custom.js')}}"></script>
        <script type="text/javascript" src="{{ asset('assets/js/shortcodes.js') }}"></script>
        <script type="text/javascript" src="{{ asset('assets/js/jqueryui.min.js') }}"></script>
        <script type="text/javascript" src="{{ asset('assets/js/animation_heading.js') }}"></script>
        <script type="text/javascript" src="{{ asset('assets/js/main.js') }}"></script>

        <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
        <script src="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.js"></script>

        <script type="text/javascript" src="{{ asset('assets/js/owl.js') }}"></script>
        <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCFC3m2n0jBRFTMvUNZc0-6Y0Rzlcadzcw"></script>
        <script src="{{ asset('assets/js/map-single.js')}}"></script>
        <script src="{{ asset('assets/js/map.js') }}"></script>
        <script src="{{ asset('assets/js/map-contact.js') }}"></script>
        <script src="{{ asset('assets/js/marker.js') }}"></script>
        <script src="{{ asset('assets/js/infobox.min.js') }}"></script>

    </body>

</html>
