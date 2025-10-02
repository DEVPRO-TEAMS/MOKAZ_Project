@extends('layouts.main')
@section('content')
    <section class="container-fluid position-relative p-0 m-0"
        style="background: url('https://i.pinimg.com/736x/99/0f/c7/990fc7a568ad1fde0dcd8ea5a087eac8.jpg') no-repeat center center / cover; height: 300px;">
        <!-- Overlay en dégradé -->
        <div class="position-absolute top-0 start-0 w-100 h-100"
            style="background: linear-gradient(to bottom, rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.7)); z-index: 1;">
        </div>

        <!-- Contenu centré -->
        <div class="row pt-5  h-100 align-items-center justify-content-center text-center position-relative"
            style="z-index: 2; animation: fadeIn 1.5s ease;">
            <div class="col-11 col-md-8">
                <h2 class="text-white display-4 fw-bold mb-3">Liste des hébergements</h2>
                <p class="text-white lead mb-4">Trouvez l’hébergement idéal selon vos préférences et votre budget.</p>
                <a href="#liste-appartements" class="btn btn-outline-light px-4 py-2 rounded-pill shadow-sm">Voir les
                    offres</a>
            </div>
        </div>
    </section>

    <!-- Animation fade-in -->
    <style>
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(30px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>


    <section class="pt-5">

        {{-- 🔎 Formulaire de recherche --}}
        <form action="{{ route('appart.by.property', $uuid) }}" method="get">
            <div class="wd-find-select shadow-st mb-4 border">
                <div class="inner-group">
                    <div class="form-group-1 search-form form-style">
                        <label>Mot-clé</label>
                        <input type="text" class="form-control" placeholder="Rechercher par Mot-clé." name="search"
                            value="{{ request('search') }}">
                    </div>

                    <div class="form-group-2 form-style">
                        <label>Localisation</label>
                        <div class="group-ip">
                            <input type="text" class="form-control" placeholder="Rechercher par Localisation"
                                name="location" value="{{ request('location') }}">
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

                <button type="submit" class="tf-btn primary">Rechercher</button>
            </div>
        </form>

        {{-- 📦 Liste des appartements --}}
        <div class="row" id="liste-appartements">
            @forelse($apparts->where('nbr_available', '>', 0) as $item)
                @php
                    $tarifHeure = $item->tarifications->where('sejour', 'Heure')->sortBy('price')->first();
                    $tarifJour = $item->tarifications->where('sejour', 'Jour')->sortBy('price')->first();
                @endphp
                <div class="col-sm-12 col-xl-4 col-lg-4 col-md-6 mb-4">
                    <div class="homeya-box">
                        <div class="archive-top">
                            <a href="{{ route('appart.detail.show', $item->uuid) }}" class="images-group">
                                <div class="images-style">
                                    @if ($item->images)
                                        <img src="{{ asset($item->image) ?? '' }}" alt="img">
                                    @endif
                                </div>
                                <div class="top">
                                    <ul class="d-flex gap-8">
                                        {{-- <li class="flag-tag success">en vedette</li> --}}
                                    </ul>
                                    <ul class="d-flex gap-4">
                                        <li class="box-icon w-32"><span class="icon icon-heart"></span></li>
                                        <li class="box-icon w-32"><span class="icon icon-eye"></span></li>
                                    </ul>
                                </div>
                                <div class="bottom">
                                    <span class="flag-tag style-2">{{ $item->type->libelle ?? '' }}</span>
                                </div>
                            </a>
                            <div class="content">
                                <div class="h7 text-capitalize fw-7">
                                    <a href="{{ route('appart.detail.show', $item->uuid) }}"
                                        class="link">{{ $item->title ?? '' }}</a>
                                </div>
                                <div class="desc">
                                    <p>{!! Str::words($item->description ?? '', 8, '...') !!}</p>
                                </div>
                                <ul class="meta-list d-flex align-items-center justify-content-between">
                                    <li class="item"><i class="icon icon-bed"></i> <span> {{ $item->nbr_room ?? 0 }}
                                            Chambre </span></li>
                                    <li class="item"><i class="icon icon-bathtub"></i> <span>
                                            {{ $item->nbr_bathroom ?? 0 }} Salle de bain </span></li>
                                    <li class="item"></li>
                                </ul>
                            </div>
                        </div>
                        <div class="archive-bottom d-flex justify-content-between align-items-center">
                            <div class="d-flex gap-8 align-items-center">
                                <span class="body-1 text-variant-1">À partir de :</span>
                            </div>
                            <div class="box-price d-flex align-items-center flex-column">
                                <div style="display: flex; align-items: center; width: 100%;">
                                    <h6>
                                        @if ($tarifHeure)
                                            {{ number_format($tarifHeure->price, 0, ',', ' ') }} FCFA&nbsp;
                                        @endif
                                    </h6>
                                    <span class="body-1 text-variant-1">
                                        @if ($tarifHeure)
                                            /{{ $tarifHeure->nbr_of_sejour ?? '' }}{{ $tarifHeure->nbr_of_sejour <= 1 ? 'hre' : 'hres' }}
                                        @endif
                                    </span>
                                </div>
                                <div style="display: flex; align-items: center; width: 100%;">
                                    <h6>
                                        @if ($tarifJour)
                                            {{ number_format($tarifJour->price, 0, ',', ' ') }} FCFA&nbsp;
                                        @endif
                                    </h6>
                                    <span class="body-1 text-variant-1">
                                        @if ($tarifJour)
                                            /{{ $tarifJour->nbr_of_sejour ?? '' }}jr
                                        @endif
                                    </span>
                                </div>
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
                        <a href="{{ route('appart.by.property', $uuid) }}" class="btn btn-sm btn-outline-danger mt-2">
                            <i class="fas fa-sync-alt me-1"></i> Réinitialiser les filtres
                        </a>
                    </div>
                @else
                    <div class="d-flex flex-column align-items-center">
                        <i class="fas fa-home fa-3x text-muted pb-3 opacity-50"></i>
                        <h5 class="fw-semibold text-center">Aucun hébergement pour le moment</h5>
                    </div>
                @endif
            @endforelse
        </div>

        <div class="nav-pagination pt-4">
            {{ $apparts->withQueryString()->links('pagination::bootstrap-5') }}
        </div>

        <div class="row pt-5" style="height: 560px">
            <div id="map" style="height: 100%" class="top-map col-12" data-map-zoom="16" data-map-scroll="true"></div>
        </div>
    </section>
@endsection
