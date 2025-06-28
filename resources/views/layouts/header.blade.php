<header class="main-header fixed-header">
    <!-- Header Lower -->
    <div class="header-lower">
        <div class="row">
            <div class="col-lg-12">
                <div class="inner-container d-flex justify-content-between align-items-center">
                    <!-- Logo Box -->
                    <div class="logo-box " style="width: 6.5rem; margin-top: 0">
                        <div class="logo"><a href="{{ route('welcome') }}"><img
                            src="{{ asset('assets/images/logo/logo-main.png') }}" alt="logo" width="100%"
                                    height="33"></a>
                            </div>
                    </div>
                    <center class="d-none d-lg-block">
                        <div class="flat-bt-top">
                            <a class="tf-btn primary" href="{{ route('reservation') }}">Faire une reservation</a>
                        </div>
                    </center>

                    
                    <div class="header-account">

                        <ul class="icon-box">
                            <li title="Mes Souhaits">
                                <a href="javascript:void(0);" class="item" onclick="toggleWishlistCart()">
                                    <span class="fs-4 icon icon-heart"></span>
                                </a>
                            </li>
                        </ul>

                        <div class="register">
                            <ul class="d-flex">
                                <li><a href="#modalLogin" data-bs-toggle="modal">Connexion</a></li>
                            </ul>
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
            <div class="nav-logo"><a href="index.html"><img src="{{ asset('assets/images/logo/logo@2x.png')}}" alt="nav-logo" width="174"
                        height="44"></a></div>
            <div class="bottom-canvas">
                <div class="login-box flex align-items-center">
                    <a href="#modalLogin" data-bs-toggle="modal">Connexion</a>
                </div>
                <div class="menu-outer"></div>
                <div class="button-mobi-sell">
                    <a class="tf-btn primary" href="{{ route('reservation') }}">Faire une reservation</a>
                </div>
                

                <div class="mobi-icon-box">
                    <div class="box d-flex align-items-center">
                        <span class="icon icon-phone2"></span>
                        <div>1-333-345-68688</div>
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
