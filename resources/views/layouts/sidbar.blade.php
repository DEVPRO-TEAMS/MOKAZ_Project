<!-- header -->
    <header class="main-header fixed-header header-dashboard">
        <!-- Header Lower -->
        <div class="header-lower">
            <div class="row">                      
                <div class="col-lg-12">         
                    <div class="inner-container d-flex justify-content-between align-items-center">
                        <!-- Logo Box -->
                        <div class="logo-box d-flex">
                            <div class="logo"  style="width: 6.8rem;"><a href="{{ route('welcome') }}"><img
                                src="{{ asset('assets/images/logo/logo-main.png') }}" alt="logo"  width="100%" height="100%"></a>
                            </div>
                            <div class="button-show-hide">
                                <span class="icon icon-categories"></span>
                            </div>
                        </div>
                        <div class="nav-outer">
                            <!-- Main Menu -->
                            <nav class="main-menu show navbar-expand-md">
                                <div class="navbar-collapse collapse clearfix" id="navbarSupportedContent">
                                    
                                </div>
                            </nav>
                            <!-- Main Menu End-->
                        </div>
                        <div class="header-account">
                            <a href="#" class="box-avatar dropdown-toggle" data-bs-toggle="dropdown">
                                <div class="avatar avt-40 round">
                                    <img src="{{asset('assets/images/avatar/avt-2.jpg')}}" alt="avt">
                                </div>
                                @if (Auth::check())
                                    <p class="name">{{ Auth::user()->name ?? ''}} {{ Auth::user()->lastname ?? '' }} <span class="icon icon-arr-down"></span></p>
                                @endif
                                {{-- <p class="name">{{ Auth::user()->name ?? ''}} {{ Auth::user()->lastname ?? '' }} <span class="icon icon-arr-down"></span></p> --}}
                                <div class="dropdown-menu">
                                    <a class="dropdown-item" href="my-profile.html">My Profile</a>
                                    <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">Se deconnecter</a>
                                </div>
                            </a>
                        </div>
                        
                        {{-- <div class="mobile-nav-toggler mobile-button"><span></span></div> --}}
                        <div class="mobile-nav-admin-toggler mobile-admin-button"><span></span></div>
                        
                    </div>
                </div>
            </div>
        </div>
        <!-- End Header Lower -->
        <!-- Mobile Admin Menu -->
        <div class="close-admin-btn"><span class="icon icon-close"></span></div>
        <div class="mobile-admin-menu">
            <div class="menu-backdrop"></div>
            <div class="menu-box">
                <div class="nav-logo"><a href="{{ route('welcome') }}"><img
                    src="{{ asset('assets/images/logo/logo-main.png') }}" alt="nav-logo"  width="60%"></a>
                </div>
                <nav class="admin-navigation bottom-canvas">
                    <ul class="admin-menu-list menu-outer">
                        <!-- Le contenu dynamique sera injecté ici via jQuery -->
                    </ul>
                    <div class="mobi-icon-box">
                        <div class="box d-flex align-items-center">
                            <span class="icon icon-phone2"></span>
                            <div>1-333-345-6868</div>
                        </div>
                        <div class="box d-flex align-items-center">
                            <span class="icon icon-mail"></span>
                            <div>themesflat@gmail.com</div>
                        </div>
                    </div>
                </nav>
            </div>
        </div>

    </header>
    <!-- end header -->
    <!-- sidebar dashboard -->
    <div class="sidebar-menu-dashboard">
        <ul class="box-menu-dashboard">
            <li class="nav-menu-item active"><a class="nav-menu-link" href="dashboard.html"><span class="icon icon-dashboard"></span> Dashboards</a></li>
            <li class="nav-menu-item"><a class="nav-menu-link" href="my-property.html"><span class="icon icon-list-dashes"></span>My Properties</a></li>

            <li class="nav-menu-item">
                <a class="nav-menu-link" href="{{ route('admin.demande.view') }}">
                    <span class="icon icon-list-dashes"></span>
                    Demandes de partenariat
                </a>
            </li>

            <li class="nav-menu-item">
                <a class="nav-menu-link" href="my-invoices.html"><span class="icon icon-file-text"></span> My Invoices</a>
            </li>

            <li class="nav-menu-item"><a class="nav-menu-link" href="{{ route('partner.properties.index') }}"><span class="icon icon-list-dashes"></span>Mes Propriétés</a></li>
            {{-- <li class="nav-menu-item"><a class="nav-menu-link" href="my-invoices.html"><span class="icon icon-file-text"></span> My Invoices</a></li>
            <li class="nav-menu-item"><a class="nav-menu-link" href="my-favorites.html"><span class="icon icon-heart"></span>My Favorites</a></li>
            <li class="nav-menu-item"><a class="nav-menu-link" href="reviews.html"><span class="icon icon-review"></span> Reviews</a></li>
            <li class="nav-menu-item"><a class="nav-menu-link" href="my-profile.html"><span class="icon icon-profile"></span> My Profile</a></li>
            <li class="nav-menu-item"><a class="nav-menu-link" href="add-property.html">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M19.5 3H4.5C4.10218 3 3.72064 3.15804 3.43934 3.43934C3.15804 3.72064 3 4.10218 3 4.5V19.5C3 19.8978 3.15804 20.2794 3.43934 20.5607C3.72064 20.842 4.10218 21 4.5 21H19.5C19.8978 21 20.2794 20.842 20.5607 20.5607C20.842 20.2794 21 19.8978 21 19.5V4.5C21 4.10218 20.842 3.72064 20.5607 3.43934C20.2794 3.15804 19.8978 3 19.5 3ZM19.5 19.5H4.5V4.5H19.5V19.5ZM16.5 12C16.5 12.1989 16.421 12.3897 16.2803 12.5303C16.1397 12.671 15.9489 12.75 15.75 12.75H12.75V15.75C12.75 15.9489 12.671 16.1397 12.5303 16.2803C12.3897 16.421 12.1989 16.5 12 16.5C11.8011 16.5 11.6103 16.421 11.4697 16.2803C11.329 16.1397 11.25 15.9489 11.25 15.75V12.75H8.25C8.05109 12.75 7.86032 12.671 7.71967 12.5303C7.57902 12.3897 7.5 12.1989 7.5 12C7.5 11.8011 7.57902 11.6103 7.71967 11.4697C7.86032 11.329 8.05109 11.25 8.25 11.25H11.25V8.25C11.25 8.05109 11.329 7.86032 11.4697 7.71967C11.6103 7.57902 11.8011 7.5 12 7.5C12.1989 7.5 12.3897 7.57902 12.5303 7.71967C12.671 7.86032 12.75 8.05109 12.75 8.25V11.25H15.75C15.9489 11.25 16.1397 11.329 16.2803 11.4697C16.421 11.6103 16.5 11.8011 16.5 12Z" fill="#A3ABB0"/>
                </svg>
                    Add Property</a></li> --}}
            <li class="nav-menu-item">
                <a class="nav-menu-link" href="{{ route('logout') }}" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                    <span class="icon icon-sign-out"></span> Se deconnecter</a></li>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                @csrf
            </form>
        </ul>

    </div>