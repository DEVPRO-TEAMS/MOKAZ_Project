<header class="main-header fixed-header">
    <!-- Header Lower -->
    <div class="header-lower">
        <div class="row">
            <div class="col-lg-12">
                <div class="inner-container d-flex justify-content-between align-items-center">
                    <!-- Logo Box -->
                    <div class="logo-box">
                        <div class="logo"><a href="{{ route('welcome') }}"><img
                                    src="{{ asset('assets/images/logo/logo.jpg') }}" alt="logo" width="174"
                                    height="44"></a></div>
                    </div>
                    <div class="nav-outer">
                        <!-- Main Menu -->

                        <nav class="main-menu show navbar-expand-md">
                            <div class="navbar-collapse collapse clearfix" id="navbarSupportedContent">
                                <ul class="navigation clearfix">
                                    <li class="{{ request()->routeIs('welcome') ? 'current' : '' }}">
                                        <a href="{{ route('welcome') }}">Accueil</a>
                                    </li>
                                    <li class="{{ request()->routeIs('reservation') ? 'current' : '' }}">
                                        <a href="{{ route('reservation') }}">Réservation</a>
                                    </li>
                                    <li class="{{ request()->routeIs('apropos') ? 'current' : '' }}">
                                        <a href="{{ route('apropos') }}">À propos de nous</a>
                                    </li>
                                    <li class="{{ request()->routeIs('contact') ? 'current' : '' }}">
                                        <a href="{{ route('contact') }}">Contactez-nous</a>
                                    </li>
                                    <li class="{{ request()->routeIs('faq') ? 'current' : '' }}">
                                        <a href="{{ route('faq') }}">FAQ</a>
                                    </li>
                                </ul>
                            </div>
                        </nav>

                        <!-- Main Menu End-->
                    </div>
                    <div class="header-account">
                        <div class="register">
                            <ul class="d-flex">
                                <li><a href="#modalLogin" data-bs-toggle="modal">Connexion</a></li>
                                <li>/</li>
                                <li><a href="#modalRegister" data-bs-toggle="modal">S'inscrire</a></li>
                            </ul>
                        </div>
                        <div class="flat-bt-top">
                            <a class="tf-btn primary" href="{{ route('reservation') }}">Faire une reservation</a>
                        </div>
                    </div>

                    <div class="mobile-nav-toggler mobile-button"><span></span></div>

                </div>
            </div>
        </div>
    </div>
    <!-- End Header Lower -->

    <!-- Mobile Menu  -->
    <div class="close-btn"><span class="icon flaticon-cancel-1"></span></div>
    <div class="mobile-menu">
        <div class="menu-backdrop"></div>
        <nav class="menu-box">
            <div class="nav-logo"><a href="index.html"><img src="images/logo/logo@2x.png" alt="nav-logo" width="174"
                        height="44"></a></div>
            <div class="bottom-canvas">
                <div class="login-box flex align-items-center">
                    <a href="#modalLogin" data-bs-toggle="modal">Connexion</a>
                    <span>/</span>
                    <a href="#modalRegister" data-bs-toggle="modal">Inscription</a>
                </div>
                <div class="menu-outer"></div>
                <div class="button-mobi-sell">
                    <a class="tf-btn primary" href="{{ route('reservation') }}">Faire une reservation</a>
                </div>
                <div class="mobi-icon-box">
                    <div class="box d-flex align-items-center">
                        <span class="icon icon-phone2"></span>
                        <div>1-333-345-6868</div>
                    </div>
                    <div class="box d-flex align-items-center">
                        <span class="icon icon-mail"></span>
                        <div>info@mokaz.com</div>
                    </div>
                </div>
            </div>
        </nav>
    </div>
    <!-- End Mobile Menu -->

</header>
