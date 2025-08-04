<!-- header -->
    <header class="main-header fixed-header header-dashboard">
        <!-- Header Lower -->
        @php
            $reservations = App\Models\Reservation::all();
        @endphp
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
                                <div class="avatar avt-40 mr-2 round">
                                    <img src="{{asset('assets/images/avatar/user-profile.webp')}}" alt="avt">
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
        

        <!-- Bouton pour fermer -->
        <div class="close-admin-btn"><span class="icon icon-close"></span></div>

        <!-- Menu Mobile Admin -->
        <div class="mobile-admin-menu">
            <div class="menu-backdrop"></div>
            <div class="menu-box">
                <div class="nav-logo">
                    <a href="{{ route('welcome') }}">
                        <img src="{{ asset('assets/images/logo/logo-main.png') }}" alt="nav-logo" width="60%">
                    </a>
                </div>
                <nav class="admin-navigation bottom-canvas">
                    <ul class="admin-menu-list menu-outer">
                        <!-- Le menu sera injecté ici -->
                    </ul>
                    <div class="mobi-icon-box mt-3">
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
    

    <div class="sidebar-menu-dashboard bg-white border-end">
        <div class="d-flex flex-column" style="height: 90vh">
            <nav class="flex-grow-1 px-2 box-menu-dashboard">
                <ul class="nav nav-pills flex-column">
                    
                    <!-- Tableau de Bord -->
                    <li class="nav-item mb-1">
                        @if (Auth::user()->user_type == 'admin')
                            <a class="nav-link active d-flex align-items-center py-2 px-3 rounded bg-danger bg-opacity-10 text-danger" 
                            href="{{ route('admin.index') }}">
                                <i class="bi bi-house-door me-3 fs-5"></i>
                                <span>Tableau de Bord</span>
                            </a>
                        @else
                            <a class="nav-link d-flex align-items-center py-2 px-3 rounded text-dark" 
                            href="{{ route('partner.index') }}">
                                <i class="bi bi-house-door me-3 fs-5"></i>
                                <span>Tableau de Bord</span>
                            </a>
                        @endif
                    </li>

                    @if (Auth::user()->user_type == 'partner')
                    <!-- Réservations -->
                    <li class="nav-item mb-1">
                        <a class="nav-link d-flex align-items-center py-2 px-3 rounded text-dark" 
                        href="{{ route('partner.reservation.index') }}">
                            <i class="bi bi-calendar-check me-3 fs-5"></i>
                            <span>Réservations</span>
                            <span class="badge bg-danger ms-auto">{{ $reservations->where('partner_uuid', Auth::user()->partner_uuid)->count() ?? 0 }}</span>
                        </a>
                    </li>
                    @else
                     <li class="nav-item mb-1">
                        <a class="nav-link d-flex align-items-center py-2 px-3 rounded text-dark" 
                        href="{{ route('admin.reservation.index') }}">
                            <i class="bi bi-calendar-check me-3 fs-5"></i>
                            <span>Réservations</span>
                            <span class="badge bg-danger ms-auto">{{ $reservations->count() }}</span>
                        </a>
                    </li>
                    @endif

                    @php
                        $demandes = App\Models\PartnershipRequest::all();
                    @endphp

                    <!-- Demandes de partenariat (Admin seulement) -->
                    @if (Auth::user()->user_type == 'admin')
                    <li class="nav-item mb-1">
                        <a class="nav-link d-flex align-items-center py-2 px-3 rounded text-dark" 
                        href="{{ route('admin.demande.view') }}">
                            <i class="bi bi-handshake me-3 fs-5"></i>
                            <span>Demandes de partenariat</span>
                            <span class="badge bg-warning text-dark ms-auto">
                                {{ $demandes->where('etat', 'pending')->count() }}
                            </span>
                        </a>
                    </li>
                    @endif

                    <!-- Propriétés -->
                    <li class="nav-item mb-1">
                        @if (Auth::user()->user_type == 'admin')
                            <a class="nav-link d-flex align-items-center py-2 px-3 rounded text-dark" 
                            href="{{ route('admin.proprety.view') }}">
                                <i class="bi bi-building me-3 fs-5"></i>
                                <span>Propriétés</span>
                            </a>
                        @else
                            <a class="nav-link d-flex align-items-center py-2 px-3 rounded text-dark" 
                            href="{{ route('partner.properties.index') }}">
                                <i class="bi bi-house-heart me-3 fs-5"></i>
                                <span>Mes Propriétés</span>
                            </a>
                        @endif
                    </li>

                    <!-- Partenaires (Admin seulement) -->
                    @if (Auth::user()->user_type == 'admin')
                    <li class="nav-item mb-1">
                        <a class="nav-link d-flex align-items-center py-2 px-3 rounded text-dark" 
                        href="{{ route('admin.partner.index') }}">
                            <i class="bi bi-people me-3 fs-5"></i>
                            <span>Partenaires</span>
                        </a>
                    </li>
                    @endif

                    <!-- Menu déroulant Dashboard -->
                    <li class="nav-item mb-1">
                        <a class="nav-link d-flex align-items-center py-2 px-3 rounded text-dark collapsed" 
                        data-bs-toggle="collapse" 
                        href="#dashboardSubmenu" 
                        role="button" 
                        aria-expanded="false" 
                        aria-controls="dashboardSubmenu">
                            <i class="bi bi-grid-3x3-gap me-3 fs-5"></i>
                            <span>Paramettres</span>
                            <i class="bi bi-chevron-down ms-auto transition-all"></i>
                        </a>
                        <div class="collapse" id="dashboardSubmenu">
                            <ul class="nav nav-pills flex-column ms-3 mt-2">
                                <li class="nav-item">
                                    <a href="{{ route('setting.indexProperty') }}" class="nav-link d-flex align-items-center py-2 px-3 rounded text-muted">
                                        <i class="bi bi-circle me-2"></i>
                                        <span>Type de proprieté</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('setting.indexAppart') }}" class="nav-link d-flex align-items-center py-2 px-3 rounded text-muted">
                                        <i class="bi bi-circle me-2"></i>
                                        <span>Type de appartement</span>
                                    </a>
                                </li>
                                {{-- <li class="nav-item">
                                    <a href="{{ route('setting.indexCommodity') }}" class="nav-link d-flex align-items-center py-2 px-3 rounded text-muted">
                                        <i class="bi bi-circle me-2"></i>
                                        <span>Commodités</span>
                                    </a>
                                </li> --}}
                            </ul>
                        </div>
                    </li>

                    <!-- Séparateur -->
                    <hr class="my-3">

                    <!-- Profil utilisateur -->
                    <li class="nav-item mb-1">
                        <a class="nav-link d-flex align-items-center py-2 px-3 rounded text-dark" 
                        href="#profile">
                            <i class="bi bi-person-circle me-3 fs-5"></i>
                            <span>Mon Profil</span>
                        </a>
                    </li>

                    <!-- Paramètres -->
                    <li class="nav-item mb-1">
                        <a class="nav-link d-flex align-items-center py-2 px-3 rounded text-dark" 
                        href="#settings">
                            <i class="bi bi-gear me-3 fs-5"></i>
                            <span>Paramètres</span>
                        </a>
                    </li>
                    
                    <li class="nav-item mb-1">
                        <!-- Footer du menu -->
                        <div class="sidebar-footer pt-4 border-top">
                            <!-- Informations utilisateur -->
                            <div class="d-flex align-items-center mb-3">
                                <div class="avatar-sm bg-danger rounded-circle d-flex align-items-center justify-content-center me-2 text-white">
                                    <i class="bi bi-person"></i>
                                </div>
                                <div class="flex-grow-1">
                                    <h6 class="mb-0 text-truncate">{{ Auth::user()->name ?? 'Utilisateur' }}</h6>
                                    <small class="text-muted">
                                        {{ Auth::user()->user_type == 'admin' ? 'Administrateur' : 'Partenaire' }}
                                    </small>
                                </div>
                            </div>
            
                            <!-- Bouton de déconnexion -->
                            <a class="btn btn-outline-danger w-100 d-flex align-items-center justify-content-center" 
                            href="{{ route('logout') }}" 
                            onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                <i class="bi bi-box-arrow-right me-2"></i>
                                Se déconnecter
                            </a>
                            
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </div>
                    </li>

                </ul>
                
            </nav>
        </div>
    </div>

    <!-- CSS minimal nécessaire -->
    <style>
        .sidebar-menu-dashboard {
            min-height: 100vh;
            box-shadow: 2px 0 10px rgba(0,0,0,0.1);
        }

        .nav-link {
            transition: all 0.3s ease;
        }

        .nav-link:hover {
            background-color: rgba(220, 53, 69, 0.1) !important;
            color: var(--bs-danger) !important;
        }

        .nav-link.active {
            background-color: rgba(220, 53, 69, 0.1) !important;
            color: var(--bs-danger) !important;
        }

        .avatar-sm {
            width: 35px;
            height: 35px;
        }

        /* Animation pour les flèches des menus déroulants */
        .nav-link[aria-expanded="true"] .bi-chevron-down {
            transform: rotate(180deg);
        }

        .transition-all {
            transition: all 0.3s ease;
        }

        /* Effet de survol pour les sous-menus */
        .collapse .nav-link:hover {
            background-color: rgba(0, 0, 0, 0.05) !important;
        }
    </style>