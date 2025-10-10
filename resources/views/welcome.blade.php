@extends('layouts.main')
@section('content')
    <style>
        @media (max-width: 768px) {

            /* Moyens écrans et plus */
            .flat-map.my-content {
                margin-top: 80px;
            }
        }
    </style>
    <!-- Map -->
    <section class="flat-map my-content">

        <div id="map" class="top-map" data-map-zoom="16" data-map-scroll="true"></div>

        <div class="container">
            <div class="wrap-filter-search">
                <div class="flat-tab flat-tab-form">
                    <ul class="nav-tab-form style-3 justify-content-center" role="tablist">
                        <li class="nav-tab-item" role="presentation">
                            <a href="#forRent" class="nav-link-item active" data-bs-toggle="tab">Localisation </a>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane fade active show" role="tabpanel">
                            <div class="form-sl pt-5">
                                {{-- <form  id="searchAppartsForm" action="{{ route('welcome') }}" method="get">
                                    <div class="wd-find-select shadow-st">
                                        <div class="inner-group">
                                            <div class="form-group-1 search-form form-style">
                                                <label>Mot-clé</label>
                                                <input type="text" class="form-control"
                                                    placeholder="Rechercher par Mot-clé." name="search"
                                                    value="{{ request('search') }}">
                                            </div>
                                            <div class="form-group-2 form-style">
                                                <label>Localisation</label>
                                                <div class="group-ip">
                                                    <input type="text" class="form-control"
                                                        placeholder="rechercher par Localisation"
                                                        value="{{ request('location') }}" name="location">
                                                </div>
                                            </div>
                                            <div class="form-group-3 form-style">
                                                <label id="type">Type</label>
                                                <div class="group-select">
                                                    <select name="type" id="type" class="nice-select form-select">
                                                        <option value="">Tous</option>
                                                        @foreach ($typeAppart as $type)
                                                            <option value="{{ $type->uuid }}"
                                                                {{ request('type') == $type->uuid ? 'selected' : '' }}>
                                                                {{ $type->libelle }}</option>
                                                        @endforeach
                                                    </select>

                                                </div>
                                            </div>

                                        </div>
                                        <button type="submit" class="tf-btn primary">Rechercher</button>
                                    </div>
                                </form> --}}

                                <form id="searchAppartsForm" action="{{ route('welcome') }}" method="get">
                                    <div class="wd-find-select shadow-st">
                                        <div class="inner-group">
                                            <div class="form-group-1 search-form form-style">
                                                <label>Mot-clé</label>
                                                <input type="text" class="form-control"
                                                    placeholder="Rechercher par Mot-clé." name="search"
                                                    value="{{ request('search') }}">
                                            </div>

                                            <div class="form-group-2 form-style">
                                                <label>Localisation</label>
                                                <div class="group-ip">
                                                    <input type="text" class="form-control"
                                                        placeholder="rechercher par Localisation" name="location"
                                                        value="{{ request('location') }}">
                                                </div>
                                            </div>

                                            <div class="form-group-3 form-style">
                                                <label>Type</label>
                                                <div class="group-select">
                                                    <select name="type" id="type" class="nice-select form-select">
                                                        <option value="">Tous</option>
                                                        @foreach ($typeAppart as $type)
                                                            <option value="{{ $type->uuid }}"
                                                                {{ request('type') == $type->uuid ? 'selected' : '' }}>
                                                                {{ $type->libelle }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                        <input type="hidden" name="lat" id="user_lat" value="{{ request('lat') }}">
                                        <input type="hidden" name="lng" id="user_lng" value="{{ request('lng') }}">

                                        <button type="submit" class="tf-btn primary">Rechercher</button>
                                    </div>
                                </form>
                                </div>
                        </div>

                    </div>
                </div>
            </div>

        </div>
    </section>
    <!-- Map -->
    <!-- Recommended -->
    <section class="flat-section-v5 bg-surface flat-recommended flat-recommended-v2">
        <div class="container">
            <div class="box-title style-2 text-center wow fadeInUpSmall" data-wow-delay=".2s" data-wow-duration="2000ms">
                {{-- <div class="text-subtitle text-primary">Propriétés en vedette</div> --}}
                <h5 class="mt-4">Découvrez les meilleures propriétés pour un sejour de rêve</h5>
            </div>
            <div class="row wow fadeInUpSmall" data-wow-delay=".2s" data-wow-duration="2000ms">
                @forelse ($apparts->where('nbr_available', '>', 0) as $item)
                    @php
                        // Récupérer la tarification à l'heure la moins chère
                        $tarifHeure = $item->tarifications->where('sejour', 'Heure')->sortBy('price')->first();

                        // Récupérer la tarification à la journée la moins chère
                        $tarifJour = $item->tarifications->where('sejour', 'Jour')->sortBy('price')->first();
                    @endphp
                    <div class="col-xl-4 col-md-6">
                        <div class="homeya-box style-3">
                            <div class="images-group">
                                <div class="images-style">
                                    <img src="{{ asset($item->image) }}" alt="img">
                                </div>
                                <div class="top">
                                    <ul class="d-flex gap-8">
                                        {{-- <li class="flag-tag     success">En vedette</li> --}}
                                    </ul>
                                    <ul class="d-flex gap-4">
                                        {{-- <li class="box-icon w-32">
                                            <span class="icon icon-arrLeftRight"></span>
                                        </li> --}}
                                        <li class="box-icon w-32">
                                            <span class="icon icon-heart"></span>
                                        </li>
                                        <li class="box-icon w-32">
                                            <a href="{{ route('appart.detail.show', $item->uuid) }}">
                                                <span class="icon icon-eye"></span>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                                <div class="content">
                                    <div class="title text-1 text-capitalize"><a
                                            href="{{ route('appart.detail.show', $item->uuid) }}"
                                            class="link text-white">{{ $item->title ?? '' }}</a></div>
                                    <ul class="meta-list">
                                        <li class="item">
                                            <i class="icon icon-bed"></i>
                                            <span>{{ $item->nbr_room ?? 0 }}</span>
                                        </li>
                                        <li class="item">
                                            <i class="icon icon-bathtub"></i>
                                            <span>{{ $item->nbr_bathroom ?? 0 }}</span>
                                        </li>
                                        <li class="item">
                                            <i class="icon icon-money"></i>
                                            <span>
                                                @if ($tarifHeure)
                                                    À partir de {{ number_format($tarifHeure->price, 0, ',', ' ') }}
                                                    FCFA/{{ $tarifHeure->nbr_of_sejour ?? '' }}{{ $tarifHeure->nbr_of_sejour <= 1 ? 'hre' : 'hres' }}
                                                @elseif ($tarifJour)
                                                    À partir de {{ number_format($tarifJour->price, 0, ',', ' ') }}
                                                    FCFA/{{ $tarifJour->nbr_of_sejour ?? '' }}{{ $tarifJour->nbr_of_sejour <= 1 ? 'jr' : 'jrs' }}
                                                @else
                                                    Prix non disponible
                                                @endif
                                            </span>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    {{-- verifier si il y a une recherche effectuée --}}
                    @if (request()->has('search') || request()->has('type') || request()->has('location'))
                        <div class="d-flex flex-column align-items-center">
                            <i class="fas fa-home fa-3x text-muted pb-3 opacity-50"></i>
                            <h5 class="fw-semibold">Aucun hébergement trouvée</h5>
                            <p class="text-muted">Aucun hébergement ne correspond à vos critères
                                de recherche</p>
                            <a href="{{ route('welcome') }}" class="btn btn-sm btn-outline-danger mt-2">
                                <i class="fas fa-sync-alt me-1"></i> Réinitialiser les filtres
                            </a>
                        </div>
                    @else
                        <div class="d-flex flex-column align-items-center">
                            <i class="fas fa-home fa-3x text-muted pb-3 opacity-50"></i>
                            <h5 class="fw-semibold">Aucun hébergement pour le moment</h5>
                        </div>
                    @endif
                @endforelse

            </div>

            <div class="nav-pagination pt-4">
                {{ $apparts->withQueryString()->links('pagination::bootstrap-5') }}
            </div>

            @if ($apparts->count() > 0)
                <div class="text-center pt-4">
                    <a href="{{ route('appart.all') }}" class="tf-btn primary size-1">Voir tous les biens</a>
                </div>
            @endif
        </div>
    </section>
    <!-- End Recommended -->

    <section class="flat-section-v3 flat-location bg-surface">
        <div class="container-full">
            <div class="box-title text-center wow fadeInUpSmall" data-wow-delay=".2s" data-wow-duration="2000ms">
                <div class="text-subtitle text-primary">Explorer les villes</div>
                <h4 class="mt-4">Notre emplacement pour vous</h4>
            </div>

            <div class="wow fadeInUpSmall" data-wow-delay=".4s" data-wow-duration="2000ms">
                <div class="swiper tf-sw-location overlay" data-preview-lg="4.1" data-preview-md="3" data-preview-sm="2"
                    data-space="30" data-centered="true" data-loop="true">

                    <div class="swiper-wrapper">
                        @foreach ($locations as $location => $properties)
                            @php
                                $firstProperty = $properties->first();
                                $city = $firstProperty->ville?->label ?? 'Ville inconnue';
                                $country = $firstProperty->pays?->label ?? 'Pays inconnu';
                                $count = $properties->count();
                                $image =
                                    $firstProperty->ville?->locationImage?->image ??
                                    'assets/images/location/abidjan.jpg';
                            @endphp
                            @if ($firstProperty->ville?->locationImage)
                                <div class="swiper-slide">
                                    <a href="javascript:void(0)" class="box-location">
                                        <div class="image">
                                            <img src="{{ asset($image) }}" alt="image-location">
                                        </div>
                                        <div class="content">
                                            <span class="sub-title">{{ $count }} Propriété(s)</span>
                                            <h6 class="title">{{ $country }}, {{ $city }}</h6>
                                        </div>
                                    </a>
                                </div>
                            @endif
                        @endforeach
                    </div>

                    <div class="box-navigation">
                        <div class="navigation swiper-nav-next nav-next-location"><span class="icon icon-arr-l"></span>
                        </div>
                        <div class="navigation swiper-nav-prev nav-prev-location"><span class="icon icon-arr-r"></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- End Location -->
    <!-- Property  -->
    <!-- Property  -->
    @if ($bestApparts->count() > 0)
        <section class="flat-section flat-property">
            <div class="container">
                <div class="box-title style-1 wow fadeInUpSmall" data-wow-delay=".2s" data-wow-duration="2000ms">
                    <div class="box-left">
                        <div class="text-subtitle text-primary">Recommandations</div>
                        <h4 class="mt-4">Meilleure valeur immobilière</h4>
                    </div>
                    <a href="{{ route('appart.all') }}" class="tf-btn primary size-1">Voir Plus</a>
                </div>
                <div class="wrap-property">
                    <div class="box-left  wow fadeInLeftSmall" data-wow-delay=".2s" data-wow-duration="2000ms">
                        @php
                            $firstAppart = $bestApparts->first();
                            $tarifHeure = $firstAppart->tarifications
                                ->where('sejour', 'Heure')
                                ->sortBy('price')
                                ->first();
                            $tarifJour = $firstAppart->tarifications->where('sejour', 'Jour')->sortBy('price')->first();
                        @endphp

                        <div class="homeya-box lg">
                            <div class="archive-top">
                                {{-- Exemple d’image --}}
                                <a href="{{ route('appart.detail.show', $firstAppart->uuid) }}" class="images-group">
                                    <div class="images-style">
                                        <img src="{{ $firstAppart->image ?? '' }}" alt="img">
                                    </div>
                                    <div class="top">
                                        <ul class="d-flex gap-8">
                                            {{-- <li class="flag-tag success style-3">En vedette</li> --}}
                                        </ul>
                                        <ul class="d-flex gap-4">
                                            {{-- <li class="box-icon w-40"><span class="icon icon-arrLeftRight"></span></li> --}}
                                            <li class="box-icon w-40"><span class="icon icon-heart"></span></li>
                                            <li class="box-icon w-40"><span class="icon icon-eye"></span></li>
                                        </ul>
                                    </div>
                                    <div class="bottom"><span
                                            class="flag-tag style-2">{{ $firstAppart->type->libelle }}</span></div>
                                </a>
                                <div class="content">
                                    <h5 class="text-capitalize"><a
                                            href="{{ route('appart.detail.show', $firstAppart->uuid) }}"
                                            class="link">{{ $firstAppart->title }}</a></h5>
                                    <div class="desc"><i class="icon icon-mapPin"></i>
                                        <p>{{ $firstAppart->property->adresse ?? 'Adresse non définie' }}</p>
                                    </div>
                                    <p class="note">{!! Str::limit($firstAppart->description, 100) !!}</p>
                                    <ul class="meta-list">
                                        <li class="item"><i
                                                class="icon icon-bed"></i><span>{{ $firstAppart->nbr_room }}</span></li>
                                        <li class="item"><i
                                                class="icon icon-bathtub"></i><span>{{ $firstAppart->nbr_bathroom }}</span>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="archive-bottom d-flex justify-content-between align-items-center">
                                <div class="avatar avt-40 round">
                                    <img src="{{ asset('assets/images/avatar/user-profile.webp') }}" alt="avt">
                                </div>
                                <div class="d-flex align-items-center">
                                    <h6>
                                        @if ($tarifHeure)
                                            À partir de {{ number_format($tarifHeure->price, 0, ',', ' ') }} FCFA
                                        @elseif ($tarifJour)
                                            À partir de {{ number_format($tarifJour->price, 0, ',', ' ') }} FCFA
                                        @else
                                            Prix non disponible
                                        @endif
                                    </h6>
                                    <span class="text-variant-1">
                                        @if ($tarifHeure)
                                            /{{ $tarifHeure->nbr_of_sejour ?? '' }}{{ $tarifHeure->nbr_of_sejour <= 1 ? 'heure' : 'heures' }}
                                        @elseif ($tarifJour)
                                            /{{ $tarifJour->nbr_of_sejour ?? '' }}{{ $tarifJour->nbr_of_sejour <= 1 ? 'jour' : 'jours' }}
                                        @else
                                        @endif
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="box-right wow fadeInRightSmall" data-wow-delay=".2s" data-wow-duration="2000ms">
                        @foreach ($bestApparts->slice(1) as $item)
                            @php
                                $tarifHeure = $item->tarifications->where('sejour', 'Heure')->sortBy('price')->first();
                                $tarifJour = $item->tarifications->where('sejour', 'Jour')->sortBy('price')->first();
                            @endphp

                            <div class="homeya-box list-style-1">
                                <a href="{{ route('appart.detail.show', $item->uuid) }}" class="images-group">
                                    <div class="images-style">
                                        <img src="{{ $item->image ?? '' }}" alt="img">
                                    </div>
                                    <div class="top">
                                        <ul class="d-flex gap-4 flex-wrap flex-column">
                                            {{-- <li class="flag-tag success">En vedette</li> --}}
                                        </ul>
                                        <ul class="d-flex gap-4">
                                            {{-- <li class="box-icon w-28"><span class="icon icon-arrLeftRight"></span></li> --}}
                                            <li class="box-icon w-28"><span class="icon icon-heart"></span></li>
                                            <li class="box-icon w-28"><span class="icon icon-eye"></span></li>
                                        </ul>
                                    </div>
                                    <div class="bottom"><span class="flag-tag style-2">{{ $item->type->libelle }}</span>
                                    </div>
                                </a>
                                <div class="content">
                                    <div class="archive-top">
                                        <div class="h7 text-capitalize fw-7"><a
                                                href="{{ route('appart.detail.show', $item->uuid) }}"
                                                class="link">{{ $item->title }}</a></div>
                                        <div class="desc"><i class="icon icon-mapPin"></i>
                                            <p>{{ $item->property->adresse ?? '' }}</p>
                                        </div>
                                        <ul class="meta-list">
                                            <li class="item"><i
                                                    class="icon icon-bed"></i><span>{{ $item->nbr_room }}</span></li>
                                            <li class="item"><i
                                                    class="icon icon-bathtub"></i><span>{{ $item->nbr_bathroom }}</span>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div class="d-flex align-items-center">
                                            <div class="avatar avt-40 round">
                                                <img src="{{ asset('assets/images/avatar/user-profile.webp') }}"
                                                    alt="avt">
                                            </div>
                                            <div class="h7 fw-7">
                                                @if ($tarifHeure)
                                                    À partir de {{ number_format($tarifHeure->price, 0, ',', ' ') }} FCFA /
                                                    {{ $tarifHeure->nbr_of_sejour ?? '' }}{{ $tarifHeure->nbr_of_sejour <= 1 ? 'hr' : 'hrs' }}
                                                @elseif ($tarifJour)
                                                    À partir de {{ number_format($tarifJour->price, 0, ',', ' ') }} FCFA /
                                                    {{ $tarifJour->nbr_of_sejour ?? '' }}{{ $tarifJour->nbr_of_sejour <= 1 ? 'jr' : 'jrs' }}
                                                @else
                                                    Prix non disponible
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </section>
    @endif
    <!-- End Property  -->
    <!-- Testimonial -->
    <section class="flat-section flat-testimonial-v4 wow fadeInUpSmall" data-wow-delay=".4s" data-wow-duration="2000ms">
        <div class="container">
            <div class="box-titl text-center mb-5">
                <div class="text-subtitle text-primary">Témoignages</div>
                <h4 class="mt-4">Ce que disent les gens</h4>
            </div>
            <div class="swiper tf-sw-testimonial" data-preview-lg="2" data-preview-md="2" data-preview-sm="2"
                data-space="30">
                <div class="swiper-wrapper">
                    <div class="swiper-slide">
                        <div class="box-tes-item style-2">
                            <ul class="list-star">
                                <li class="icon icon-star"></li>
                                <li class="icon icon-star"></li>
                                <li class="icon icon-star"></li>
                                <li class="icon icon-star"></li>
                                <li class="icon icon-star"></li>
                            </ul>
                            <p class="note body-1">
                                "J'ai vraiment apprécié le professionnalisme et les connaissances approfondies de l'équipe
                                de courtage. Ils
                                m'ont non seulement aidé à trouver la maison idéale, mais ils m'ont également assisté pour
                                les aspects juridiques et financiers,
                                , ce qui m'a permis de me sentir confiant et sûr de ma décision."
                            </p>
                            <div class="box-avt d-flex align-items-center gap-12">
                                <div class="avatar avt-60 round">
                                    <img src="{{ asset('assets/images/avatar/avt-7.jpg') }}" alt="avatar">
                                </div>
                                <div class="info">
                                    {{-- <div class="h7 fw-7">Lorem, ipsum.</div>
                                    <p class="text-variant-1 mt-4">Lorem, ipsum.</p> --}}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="box-tes-item style-2">
                            <ul class="list-star">
                                <li class="icon icon-star"></li>
                                <li class="icon icon-star"></li>
                                <li class="icon icon-star"></li>
                                <li class="icon icon-star"></li>
                                <li class="icon icon-star"></li>
                            </ul>
                            <p class="note body-1">
                                "Mon expérience avec les services de gestion immobilière a dépassé mes attentes. Ils gèrent
                                efficacement
                                les propriétés avec une approche professionnelle et attentive dans chaque situation. Je me
                                sens
                                rassuré sur le fait que tout problème sera résolu rapidement et efficacement."
                            </p>
                            <div class="box-avt d-flex align-items-center gap-12">
                                <div class="avatar avt-60 round">
                                    <img src="{{ asset('assets/images/avatar/avt-5.jpg') }}" alt="avatar">
                                </div>
                                <div class="info">
                                    {{-- <div class="h7 fw-7">Lorem, ipsum.</div>
                                    <p class="text-variant-1 mt-4">Lorem, ipsum.</p> --}}
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="sw-pagination sw-pagination-testimonial"></div>

            </div>
        </div>
    </section>
    <!-- End Testimonial -->
    <!-- banner -->
    <section class="flat-section pt-0 flat-banner wow fadeInUpSmall" data-wow-delay=".2s" data-wow-duration="2000ms">
        <div class="container">
            <div class="wrap-banner bg-surface">
                <div class="box-left">
                    <div class="box-title">
                        <div class="text-subtitle text-primary">Devenir partenaire</div>
                        <h4 class="mt-4">Inscrivez vos propriétés sur Mokaz, rejoignez-nous maintenant !</h4>
                    </div>
                    <a href="#" data-bs-toggle="modal" data-bs-target="#demandPartnariaModal"
                        class="tf-btn primary size-1">Devenir hébergeur</a>
                </div>
                <div class="box-right">
                    <img src="{{ asset('assets/images/banner/banner.png') }}" alt="image">
                </div>
            </div>
        </div>
    </section>


    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Vérifier si les coordonnées sont déjà présentes
            const latInput = document.getElementById('user_lat');
            const lngInput = document.getElementById('user_lng');

            if (!latInput.value || !lngInput.value) {
                // Récupérer automatiquement la position
                if (navigator.geolocation) {
                    navigator.geolocation.getCurrentPosition(function(position) {
                        latInput.value = position.coords.latitude;
                        lngInput.value = position.coords.longitude;

                        // Soumettre automatiquement le formulaire
                        document.getElementById('searchAppartsForm').submit();
                    }, function(error) {
                        console.warn("Impossible de récupérer la position :", error.message);
                        // On peut charger les appartements sans géolocalisation si refusé
                    });
                } else {
                    console.warn("Géolocalisation non supportée par le navigateur.");
                }
            }
        });
    </script>
    <!-- end banner -->
@endsection
