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

    <!-- popup login -->
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
                            <input id="email" type="email" class="form-contact style-1 @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </fieldset>
                        <fieldset class="box-fieldset">
                            <label for="pass">Votre mot de passe<span>*</span>:</label>
                            <div class="box-password">
                                <input type="password" class="form-contact style-1 password-field @error('password') is-invalid @enderror" name="password" placeholder="Password" required autocomplete="current-password">
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
                                <input type="checkbox" class="tf-checkbox style-2" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                                <label for="remember" class="caption-1 text-variant-1">Se souvenir de moi</label>
                            </fieldset>
                            @if (Route::has('password.request'))
                                <a href="{{ route('password.request') }}" class="caption-1 text-primary">Mot de passe oublie ?</a>
                            @endif
                        </div>
                        <div class="text-variant-1 auth-line d-none">or sign up with</div>
                        <div class="login-social d-none">
                            <a href="#" class="btn-login-social">
                                <img src="images/logo/fb.jpg" alt="img">
                                Continue with Facebook
                            </a>
                            <a href="#" class="btn-login-social">
                                <img src="images/logo/google.jpg" alt="img">
                                Continue with Google
                            </a>
                            <a href="#" class="btn-login-social">
                                <img src="images/logo/tw.jpg" alt="img">
                                Continue with Twitter
                            </a>
                        </div>
                        <button type="submit" class="tf-btn primary w-100">Se connecter</button>
                        <div class="mt-12 text-variant-1 text-center noti d-none">Not registered yet?<a href="#modalRegister" data-bs-toggle="modal" class="text-black fw-5">Sign Up</a> </div>
                    </form>
                </div>
            </div> 
        </div>
    </div>

</header>


