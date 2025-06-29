<!DOCTYPE html>

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en-US" lang="en-US">

<head>
    <meta charset="utf-8">
    <title>MOKAZ - Plateforme Immobilier</title>

    <meta name="author" content="creativeagency.web">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

    <!-- font -->
    <link rel="stylesheet" href="{{ asset('assets/fonts/fonts.css') }}">
    <!-- Icons -->
    <link rel="stylesheet" href="{{ asset('assets/fonts/font-icons.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/owl.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/swiper-bundle.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/animate.css') }}">
    <link rel="stylesheet"type="text/css" href="{{ asset('assets/css/styles.css') }}" />

    <!-- Favicon and Touch Icons  -->
    <link rel="shortcut icon" href="{{ asset('assets/images/logo/favicon.png') }}">
    <link rel="apple-touch-icon-precomposed" href="{{ asset('assets/images/logo/favicon.png') }}">

</head>

<body class="body counter-scroll">

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
        <div id="pagee" class="clearfix">



            <!-- Main Header -->
            @include('layouts.header')
            <!-- End Main Header -->

            <div class="container-fluid" style="margin-top: 5%">
                @yield('content')
            </div>
            <!-- footer -->
            @include('layouts.footer')
            <!-- end footer -->
        </div>
        <!-- /#page -->

    </div>

    @include('components.wishlist')

    {{-- Gestion du menu static inteligent  --}}

    <script>
        let lastScrollTop = 0;
        const header = document.querySelector('.fixed-header');

        window.addEventListener('scroll', function() {
            let scrollTop = window.pageYOffset || document.documentElement.scrollTop;

            if (scrollTop > lastScrollTop) {
                // Scroll vers le bas → cacher le header
                header.style.top = "-100px";
            } else {
                // Scroll vers le haut → afficher le header
                header.style.top = "0";
            }

            lastScrollTop = scrollTop <= 0 ? 0 : scrollTop; // pour éviter valeurs négatives
        });
    </script>

    
    <script>
        function toggleWishlistCart() {
            const cart = document.getElementById('wishlistCart');
            cart.classList.toggle('d-none');
        }
    </script>




    <!-- go top -->
    <div class="progress-wrap">
        <svg class="progress-circle svg-content" width="100%" height="100%" viewBox="-1 -1 102 102">
            <path d="M50,1 a49,49 0 0,1 0,98 a49,49 0 0,1 0,-98"
                style="transition: stroke-dashoffset 10ms linear 0s; stroke-dasharray: 307.919, 307.919; stroke-dashoffset: 286.138;">
            </path>
        </svg>
    </div>

    

    <div class="modal fade" id="modalLogin">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="flat-account bg-surface">
                    <h3 class="title text-center">Connexion</h3>
                    <span class="close-modal icon-close2" data-bs-dismiss="modal"></span>
                    <form method="POST" action="{{ route('login') }}">
                        @csrf
                        <fieldset class="box-fieldset">
                            <label for="email">Votre adresse email<span>*</span>:</label>
                            <input id="email" type="email" class="form-contact style-1 @error('email') is-invalid @enderror"
                                name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </fieldset>
                        <fieldset class="box-fieldset">
                            <label for="pass">Votre mot de passe<span>*</span>:</label>
                            <div class="box-password">
                                <input type="password"
                                    class="form-contact style-1 password-field @error('password') is-invalid @enderror" name="password"
                                    placeholder="Password" required autocomplete="current-password">
                                <span class="show-pass">
                                    <i class="icon-pass icon-eye"></i>
                                    <i class="icon-pass icon-eye-off"></i>
                                </span>
                            </div>
                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </fieldset>
                        <div class="d-flex justify-content-between flex-wrap gap-12">
                            <fieldset class="d-flex align-items-center gap-6">
                                <input type="checkbox" class="tf-checkbox style-2" name="remember" id="remember"
                                    {{ old('remember') ? 'checked' : '' }}>
                                <label for="remember" class="caption-1 text-variant-1">Se souvenir de moi</label>
                            </fieldset>
                            @if (Route::has('password.request'))
                                <a href="{{ route('password.request') }}" class="caption-1 text-primary">Mot de passe oublie ?</a>
                            @endif
                        </div>
                        <button type="submit" class="tf-btn primary w-100">Se connecter</button>
                    </form>
                </div>
            </div> 
        </div>
    </div>





    <!-- Javascript -->
    <script type="text/javascript" src="{{ asset('assets/js/bootstrap.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/js/jquery.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/js/owl.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/js/swiper-bundle.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/js/carousel.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/js/plugin.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/js/jquery.nice-select.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/js/rangle-slider.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/js/countto.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/js/shortcodes.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/js/animation_heading.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/js/main.js') }}"></script>


    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCFC3m2n0jBRFTMvUNZc0-6Y0Rzlcadzcw"></script>
    <script src="{{ asset('assets/js/map.js') }}"></script>
    <script src="{{ asset('assets/js/map-contact.js') }}"></script>
    <script src="{{ asset('assets/js/marker.js') }}"></script>
    <script src="{{ asset('assets/js/infobox.min.js') }}"></script>

    <script src="{{ asset('assets/js/map-single.js') }}"></script>


</body>

</html>
