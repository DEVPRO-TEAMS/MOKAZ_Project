@extends('layouts.main')
@section('content')
    <style>
        .more-content.collapse:not(.show) {
            display: block !important;
            height: 0;
            overflow: hidden;
            position: relative;
        }

        .read-more-toggle {
            color: var(--primary-color);
            cursor: pointer;
            font-weight: 500;
            display: inline-flex;
            align-items: center;
            gap: 4px;
        }

        .read-more-toggle:hover {
            opacity: 0.8;
        }

        .read-more-toggle i {
            transition: transform 0.2s ease;
        }

        [aria-expanded="true"] .read-more-toggle i {
            transform: rotate(180deg);
        }

        .rating {
            direction: rtl;
            /* Permet de remplir les étoiles de droite à gauche */
            unicode-bidi: bidi-override;
            display: inline-flex;
        }

        .rating input {
            display: none;
        }

        .rating label {
            font-size: 3rem;
            color: #ddd;
            cursor: pointer;
            transition: color 0.2s;
        }

        .rating input:checked~label,
        .rating label:hover,
        .rating label:hover~label {
            color: #ffc107;
            /* Jaune bootstrap */
        }

        .list-star-note {
            display: flex;
        }

        .list-star-note .icon-star {
            color: #ddd;
            font-size: 16px;
        }

        .pagination .page-item .page-link {
            color: #dc3545;
            /* Rouge Bootstrap */
            border-radius: 8px;
            margin: 0 4px;
            border: 1px solid #dc3545;
            transition: all 0.3s ease;
        }

        .pagination .page-item .page-link:hover {
            background-color: #dc3545;
            color: #fff;
        }

        .pagination .page-item.active .page-link {
            background-color: #dc3545;
            border-color: #dc3545;
            color: #fff;
            font-weight: bold;
        }
    </style>


    <section class="flat-location flat-slider-detail-v1">
        <div class="swiper tf-sw-location" data-preview-lg="2.03" data-preview-md="2" data-preview-sm="2" data-space="20"
            data-centered="true" data-loop="true">
            <div class="swiper-wrapper">
                @foreach ($appart->images as $image)
                    <div class="swiper-slide" style="height: 70vh; width: 100%;">
                        <a href="{{ asset($image->doc_url) }}" target="_blank" data-fancybox="gallery"
                            class="box-imgage-detail d-block">
                            <center>
                                <img src="{{ asset($image->doc_url) }}" class="img-fluid"
                                    style="max-height: 70vh; max-width: 100%; object-fit: cover;" alt="img-appart">
                            </center>
                        </a>
                    </div>
                @endforeach
            </div>
            <div class="box-navigation">
                <div class="navigation swiper-nav-next nav-next-location"><span class="icon icon-arr-l"></span></div>
                <div class="navigation swiper-nav-prev nav-prev-location"><span class="icon icon-arr-r"></span></div>
            </div>
        </div>
    </section>

    <section class="flat-section pt-0 flat-property-detail">
        @php
            // Récupérer la tarification à l'heure la moins chère
$tarifHeure = $appart->tarifications->where('sejour', 'Heure')->sortBy('price')->first();

// Récupérer la tarification à la journée la moins chère
$tarifJour = $appart->tarifications->where('sejour', 'Jour')->sortBy('price')->first();
        @endphp
        <div class="container border rounded shadow p-4">
            <div class="header-property-detail">
                <div class="content-top d-flex justify-content-between align-items-center">
                    <div class="box-name">
                        {{-- <a href="#" class="flag-tag primary">En </a> --}}
                        <h4 class="title link">{{ $appart->title }}</h4>
                    </div>
                    <span class="body-1 text-variant-1">À partir de :</span>
                    <div class="box-price d-flex align-items-center flex-column">
                        <div style="display: flex; align-items: center; width: 100%;">
                            <h5>
                                @if ($tarifHeure)
                                    {{ number_format($tarifHeure->price, 0, ',', ' ') }} FCFA &nbsp;
                                @endif
                            </h5>
                            <span class="body-1 text-variant-1">
                                @if ($tarifHeure)
                                    /
                                    {{ $tarifHeure->nbr_of_sejour ?? '' }}{{ $tarifHeure->nbr_of_sejour <= 1 ? 'hre' : 'hres' }}
                                @endif
                            </span>
                        </div>
                        <div style="display: flex; align-items: center; width: 100%;">
                            <h5>
                                @if ($tarifJour)
                                    {{ number_format($tarifJour->price, 0, ',', ' ') }} FCFA &nbsp;
                                @endif
                            </h5>
                            <span class="body-1 text-variant-1">
                                @if ($tarifJour)
                                    / {{ $tarifJour->nbr_of_sejour ?? '' }}jr
                                @endif
                            </span>
                        </div>
                    </div>
                </div>
                <div class="content-bottom">
                    <div class="info-box">
                        <div class="label text-uppercase">caractéristiques:</div>
                        <ul class="meta">
                            <li class="meta-item"><span class="icon icon-bed"></span> {{ $appart->nbr_room ?? '0' }}
                                Chambres à couché</li>
                            <li class="meta-item"><span class="icon icon-bathtub"></span>
                                {{ $appart->nbr_bathroom ?? '0' }} Salle de bain</li>
                        </ul>
                    </div>
                    <div class="info-box">
                        <div class="label">LOCALISATION:</div>
                        <p class="meta-item"><span
                                class="icon icon-mapPin"></span>{{ $appart->property->ville->label ?? '' }},
                            {{ $appart->property->pays->label ?? '' }}</p>
                    </div>
                    <ul class="icon-box">
                        <li><a href="#" class="item"><span class="icon icon-heart"></span></a></li>
                    </ul>

                </div>
            </div>
            <div class="row">
                <div class="col-lg-8">
                    @php
                        $fullDescription = $appart->description;
                        $wordLimit = 100;

                        // Nettoyage initial et normalisation des espaces
                        $normalizedContent = preg_replace('/\s+/', ' ', $fullDescription);
                        $textOnly = strip_tags($normalizedContent);

                        // Découpage des mots en gérant les espaces particuliers
                        $words = preg_split('/\s+/', trim($textOnly));
                        $wordCount = count($words);

                        if ($wordCount > $wordLimit) {
                            // On prend les premiers mots (sans HTML)
                            $limitedText = implode(' ', array_slice($words, 0, $wordLimit));

                            // On trouve la position approximative dans le HTML original
                            $pos = 0;
                            $currentWordCount = 0;
                            $pattern = '/(?:<[^>]+>)|(?:\s*\S+\s*)/';
                            preg_match_all($pattern, $fullDescription, $matches, PREG_OFFSET_CAPTURE);

                            foreach ($matches[0] as $match) {
                                if (!preg_match('/^<[^>]+>$/', $match[0])) {
                                    // Si ce n'est pas une balise HTML
            $currentWordCount++;
            if ($currentWordCount >= $wordLimit) {
                $pos = $match[1];
                break;
            }
        }
    }

    if ($pos > 0) {
        $limitedHtml = substr($fullDescription, 0, $pos);
        $remainingHtml = substr($fullDescription, $pos);
    } else {
        // Fallback si la méthode échoue
        $limitedHtml = Str::words($fullDescription, $wordLimit, '');
        $remainingHtml = Str::after($fullDescription, $limitedHtml);
    }
} else {
    $limitedHtml = $fullDescription;
    $remainingHtml = '';
}

$hasMoreContent = trim(strip_tags($remainingHtml)) !== '';
                    @endphp

                    <div class="single-property-element single-property-desc">
                        <div class="h7 title fw-7">Description</div>

                        <div class="body-2 text-variant-1">
                            {!! $limitedHtml !!}

                            @if ($hasMoreContent)
                                <span class="more-content collapse" id="collapseDescription">
                                    {!! $remainingHtml !!}
                                </span>

                                <a class="read-more-toggle mt-2 d-inline-block" data-bs-toggle="collapse"
                                    href="#collapseDescription" role="button" aria-expanded="false"
                                    aria-controls="collapseDescription">
                                    <span class="read-more-text">Voir plus</span>
                                    <span class="read-less-text d-none">Voir moins</span>
                                </a>
                            @endif
                        </div>
                    </div>
                    <div class="single-property-element single-property-overview">
                        <div class="h7 title fw-7">Aperçu</div>
                        <ul class="info-box row">
                            <li class="item col-lg-4 col-md-6">
                                <a href="#" class="box-icon w-52"><i class="icon icon-house-line"></i></a>
                                <div class="content">
                                    <span class="label">ID:</span>
                                    <span>{{ $appart->id ?? '' }}</span>
                                </div>
                            </li>
                            <li class="item col-lg-4 col-md-6">
                                <a href="#" class="box-icon w-52"><i class="icon icon-arrLeftRight"></i></a>
                                <div class="content">
                                    <span class="label">Type:</span>
                                    <span>{{ $appart->type->libelle ?? '' }}</span>
                                </div>
                            </li>
                            <li class="item col-lg-4 col-md-6">
                                <a href="#" class="box-icon w-52"><i class="icon icon-bed"></i></a>
                                <div class="content">
                                    <span class="label">Chambre à couché:</span>
                                    <span>{{ $appart->nbr_room ?? '0' }} Chambres</span>
                                </div>
                            </li>
                            <li class="item col-lg-4 col-md-6">
                                <a href="#" class="box-icon w-52"><i class="icon icon-bathtub"></i></a>
                                <div class="content">
                                    <span class="label">Salle de bain:</span>
                                    <span>{{ $appart->nbr_bathroom ?? '0' }} salles</span>
                                </div>
                            </li>
                        </ul>
                    </div>
                    @php

                        if (!function_exists('generateEmbedUrl')) {
                            function generateEmbedUrl($url)
                            {
                                if (!$url) {
                                    return null;
                                }

                                $pattern =
                                    '%(?:youtube(?:-nocookie)?\.com/(?:shorts/|watch\?v=|embed/|v/)|youtu\.be/)([^"&?/ ]{11})%i';

                                preg_match($pattern, $url, $matches);

                                return isset($matches[1]) ? 'https://www.youtube.com/embed/' . $matches[1] : null;
                            }
                        }

                        $videoUrl = generateEmbedUrl($appart->video_url);
                        $commodities = explode(',', $appart->commodities);
                    @endphp
                    <div class="single-property-element single-property-video">
                        <div class="h7 title fw-7">Video</div>
                        <div class="img-video">
                            <img src="{{ asset($appart->image) }}" alt="img-video">
                            <a href="{{ $videoUrl }}" target="_blank" data-fancybox="gallery2" class="btn-video">
                                <span class="icon icon-play"></span></a>
                        </div>
                    </div>
                    <div class="single-property-element single-property-info">
                        <div class="h7 title fw-7">Détails de l'hébergement</div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="inner-box">
                                    <span class="label">Code:</span>
                                    <div class="content fw-7">{{ $appart->code ?? '' }}</div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="inner-box">
                                    <span class="label">Chambre:</span>
                                    <div class="content fw-7">{{ $appart->nbr_room ?? '0' }}</div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="inner-box">
                                    <span class="label">Prix:</span>
                                    <div class="content fw-7">
                                        <span class="caption-1 fw-4 text-variant-1">À partir de &nbsp;</span>
                                        @if ($tarifHeure)
                                            {{ number_format($tarifHeure->price, 0, ',', ' ') }} FCFA
                                        @elseif ($tarifJour)
                                            {{ number_format($tarifJour->price, 0, ',', ' ') }} FCFA
                                        @else
                                            Prix non disponible
                                        @endif
                                        <span class="caption-1 fw-4 text-variant-1">
                                            @if ($tarifHeure)
                                                /{{ $tarifHeure->nbr_of_sejour ?? '' }}{{ $tarifHeure->nbr_of_sejour <= 1 ? 'heure' : 'heures' }}
                                            @elseif ($tarifJour)
                                                /{{ $tarifJour->nbr_of_sejour ?? '' }}{{ $tarifJour->nbr_of_sejour <= 1 ? 'jour' : 'jours' }}
                                            @else
                                                Prix non disponible
                                            @endif
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="inner-box">
                                    <span class="label">Salle de bain:</span>
                                    <div class="content fw-7">{{ $appart->nbr_bathroom ?? '0' }}</div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="inner-box">
                                    <span class="label">Type:</span>
                                    <div class="content fw-7">{{ $appart->type->libelle ?? '' }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @if (!empty($commodities))
                        <div class="single-property-element single-property-feature">
                            <div class="h7 title fw-7">Commodités et caractéristiques</div>
                            <div class="wrap-feature">
                                <div class="box-feature">
                                    <ul class="row">
                                        @foreach ($commodities as $item)
                                            <li class="feature-item col-md-4">
                                                <i class="bi bi-star"></i> {{ trim($item) }}
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                    @endif
                    <div class="single-property-element single-property-map">
                        <div class="h7 title fw-7">Map</div>
                        <div id="map-location-property" class="map-single" data-map-zoom="16" data-map-scroll="true">
                        </div>
                        {{-- <ul class="info-map">
                            <li>
                                <div class="fw-7">Address</div>
                                <span class="mt-4 text-variant-1">8 Broadway, Brooklyn, New York</span>
                            </li>
                            <li>
                                <div class="fw-7">Downtown</div>
                                <span class="mt-4 text-variant-1">5 min</span>

                            </li>
                            <li>
                                <div class="fw-7">FLL</div>
                                <span class="mt-4 text-variant-1">15 min</span>
                            </li>
                        </ul> --}}
                    </div>
                    {{-- <div class="single-property-element single-property-nearby">
                        <div class="h7 title fw-7">Qu'y a-t-il à proximité ?</div>
                        <p class="body-2">Lorem ipsum dolor sit amet consectetur adipisicing elit. Esse aliquid, quod
                            quisquam debitis exercitationem minima. Ipsam, provident nihil. Dolores a corrupti ipsam nam
                            tempore mollitia quis odio accusantium recusandae sit </p>
                        <div class="grid-2 box-nearby">
                            <ul class="box-left">
                                <li class="item-nearby">
                                    <span class="label">School:</span>
                                    <span class="fw-7">0.7 km</span>
                                </li>
                                <li class="item-nearby">
                                    <span class="label">University:</span>
                                    <span class="fw-7">1.3 km</span>
                                </li>
                                <li class="item-nearby">
                                    <span class="label">Grocery center:</span>
                                    <span class="fw-7">0.6 km</span>
                                </li>
                                <li class="item-nearby">
                                    <span class="label">Market:</span>
                                    <span class="fw-7">1.1 km</span>
                                </li>
                            </ul>
                            <ul class="box-right">
                                <li class="item-nearby">
                                    <span class="label">Hospital:</span>
                                    <span class="fw-7">0.4 km</span>
                                </li>
                                <li class="item-nearby">
                                    <span class="label">Metro station:</span>
                                    <span class="fw-7">1.8 km</span>
                                </li>
                                <li class="item-nearby">
                                    <span class="label">Gym, wellness:</span>
                                    <span class="fw-7">1.3 km</span>
                                </li>
                                <li class="item-nearby">
                                    <span class="label">River:</span>
                                    <span class="fw-7">2.1 km</span>
                                </li>
                            </ul>
                        </div>

                    </div> --}}
                    <div class="single-property-element single-wrapper-review">
                        <div class="box-title-review d-flex justify-content-between align-items-center flex-wrap gap-20">
                            <div class="h7 fw-7">Avis des clients</div>
                            {{-- <a href="#" class="tf-btn">Voir tous les avis</a> --}}
                        </div>
                        <div class="wrap-review">
                            <ul class="box-review">

                            </ul>
                        </div>
                        <div class="wrap-form-comment">
                            <div class="h7">Laisser un commentaire</div>
                            <div id="comments" class="comments">
                                <div class="respond-comment">
                                    <form class="comment-form form-submit" id="comment-form">

                                        <div class="form-wg group-ip">
                                            <fieldset>
                                                <label class="sub-ip">Nom</label>
                                                <input type="text" class="form-control" name="name"
                                                    placeholder="Votre nom et prénom(s)" required>

                                                <input type="hidden" class="form-control" id="appart_uuid"
                                                    name="appart_uuid" value="{{ $appart->uuid }}">

                                                <input type="hidden" class="form-control" name="property_uuid"
                                                    value="{{ $appart->property_uuid ?? '' }}">

                                                <input type="hidden" class="form-control" name="partner_uuid"
                                                    value="{{ $appart->property->partner_uuid ?? '' }}">
                                            </fieldset>
                                            <fieldset>
                                                <label class="sub-ip">Email</label>
                                                <input type="email" class="form-control" name="email"
                                                    placeholder="Votre adresse email" required>
                                            </fieldset>
                                        </div>
                                        <!-- ⭐ Ajout des étoiles -->
                                        <fieldset class="form-wg">
                                            <label class="sub-ip d-block">Votre note</label>
                                            <div class="rating">
                                                <input type="radio" id="star5" name="rating" value="5"
                                                    required />
                                                <label for="star5" title="5 étoiles">★</label>
                                                <input type="radio" id="star4" name="rating" value="4" />
                                                <label for="star4" title="4 étoiles">★</label>
                                                <input type="radio" id="star3" name="rating" value="3" />
                                                <label for="star3" title="3 étoiles">★</label>
                                                <input type="radio" id="star2" name="rating" value="2" />
                                                <label for="star2" title="2 étoiles">★</label>
                                                <input type="radio" id="star1" name="rating" value="1" />
                                                <label for="star1" title="1 étoile">★</label>
                                            </div>
                                        </fieldset>
                                        <fieldset class="form-wg">
                                            <label class="sub-ip">Commentaire</label>
                                            <textarea id="comment-message" name="comment" rows="4" tabindex="4" placeholder="Votre commentaire"
                                                aria-required="true"></textarea>
                                        </fieldset>
                                        <button class="form-wg tf-btn primary" type="submit">
                                            <span>Envoyer</span>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 px-1">
                    <div class="widget-sidebar fixed-sidebar wrapper-sidebar-right p-0">
                        <div class="hero-section my-4 card">
                            {{-- <div class="card-header text-center">
                                <h6><i class="fas fa-hotel text-danger"></i></h6>
                            </div> --}}

                            <div class="card-body">
                                <p>Découvrez le confort et l'élégance dans notre établissement de prestige</p>
                            </div>

                            <div class="card-footer">
                                <button class="btn btn-outline-danger btn-lg w-100" data-bs-toggle="modal"
                                    data-bs-target="#reservationModal">
                                    <i class="fas fa-calendar-plus"></i> Reserver maintenant
                                </button>
                            </div>
                        </div>
                        {{-- <div class="flat-tab flat-tab-form widget-filter-search widget-box bg-surface">
                            <div class="h7 title fw-7">Recherche d'autres hebergements</div>
                            <div class="tab-content">
                                <div class="tab-pane fade active show" role="tabpanel">
                                    <div class="form-sl">
                                        <form method="post">
                                            <div class="wd-filter-select">
                                                <div class="inner-group inner-filter">
                                                    <div class="form-style">
                                                        <label class="title-select">Mot-clé</label>
                                                        <input type="text" class="form-control"
                                                            placeholder="Search Keyword." value="" name="s"
                                                            title="Search for" required="">
                                                    </div>
                                                    <div class="form-style">
                                                        <label class="title-select">Emplacement</label>
                                                        <div class="group-ip ip-icon">
                                                            <input type="text" class="form-control"
                                                                placeholder="Search Location" value=""
                                                                name="s" title="Search for" required="">
                                                            <a href="#" class="icon-right icon-location"></a>
                                                        </div>
                                                    </div>
                                                    <div class="form-style">
                                                        <label class="title-select">Type</label>
                                                        <div class="group-select">
                                                            <div class="nice-select" tabindex="0"><span
                                                                    class="current">Tous</span>
                                                                <ul class="list">
                                                                    <li data-value class="option selected">Tous</li>
                                                                    <li data-value="villa" class="option">Villa</li>
                                                                    <li data-value="studio" class="option">Studio</li>
                                                                    <li data-value="office" class="option">Office</li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-style box-select">
                                                        <label class="title-select">Chambres</label>
                                                        <div class="nice-select" tabindex="0"><span
                                                                class="current">2</span>
                                                            <ul class="list">
                                                                <li data-value="2" class="option">1</li>
                                                                <li data-value="2" class="option selected">2</li>
                                                                <li data-value="3" class="option">3</li>
                                                                <li data-value="4" class="option">4</li>
                                                                <li data-value="5" class="option">5</li>
                                                                <li data-value="6" class="option">6</li>
                                                                <li data-value="7" class="option">7</li>
                                                                <li data-value="8" class="option">8</li>
                                                                <li data-value="9" class="option">9</li>
                                                                <li data-value="10" class="option">10</li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                    <div class="form-style box-select">
                                                        <label class="title-select">Salles de bains</label>
                                                        <div class="nice-select" tabindex="0"><span
                                                                class="current">4</span>
                                                            <ul class="list">
                                                                <li data-value="all" class="option">All</li>
                                                                <li data-value="1" class="option">1</li>
                                                                <li data-value="2" class="option">2</li>
                                                                <li data-value="3" class="option">3</li>
                                                                <li data-value="4" class="option selected">4</li>
                                                                <li data-value="5" class="option">5</li>
                                                                <li data-value="6" class="option">6</li>
                                                                <li data-value="7" class="option">7</li>
                                                                <li data-value="8" class="option">8</li>
                                                                <li data-value="9" class="option">9</li>
                                                                <li data-value="10" class="option">10</li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                    <div class="form-style box-select">
                                                        <label class="title-select">Chambres à coucher</label>
                                                        <div class="nice-select" tabindex="0"><span
                                                                class="current">4</span>
                                                            <ul class="list">
                                                                <li data-value="1" class="option">All</li>
                                                                <li data-value="1" class="option">1</li>
                                                                <li data-value="2" class="option">2</li>
                                                                <li data-value="3" class="option">3</li>
                                                                <li data-value="4" class="option selected">4</li>
                                                                <li data-value="5" class="option">5</li>
                                                                <li data-value="6" class="option">6</li>
                                                                <li data-value="7" class="option">7</li>
                                                                <li data-value="8" class="option">8</li>
                                                                <li data-value="9" class="option">9</li>
                                                                <li data-value="10" class="option">10</li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                    <div class="form-style widget-price">
                                                        <div class="box-title-price">
                                                            <span class="title-price">Gamme de prix </span>
                                                            <div class="caption-price">
                                                                <span>de</span>
                                                                <span id="slider-range-value1" class="fw-7"></span>
                                                                <span>à</span>
                                                                <span id="slider-range-value2" class="fw-7"></span>
                                                            </div>
                                                        </div>
                                                        <div id="slider-range"></div>
                                                        <div class="slider-labels">
                                                            <input type="hidden" name="min-value" value="">
                                                            <input type="hidden" name="max-value" value="">
                                                        </div>
                                                    </div>
                                                    <div class="form-style widget-price wd-price-2">
                                                        <div class="box-title-price">
                                                            <span class="title-price">Gamme de tailles </span>
                                                            <div class="caption-price">
                                                                <span>de</span>
                                                                <span id="slider-range-value01" class="fw-7"></span>
                                                                <span>à</span>
                                                                <span id="slider-range-value02" class="fw-7"></span>
                                                            </div>
                                                        </div>
                                                        <div id="slider-range2"></div>
                                                        <div class="slider-labels">
                                                            <input type="hidden" name="min-value2" value="">
                                                            <input type="hidden" name="max-value2" value="">
                                                        </div>
                                                    </div>
                                                    <div class="form-style btn-show-advanced">
                                                        <a class="filter-advanced pull-right">
                                                            <span class="icon icon-faders"></span>
                                                            <span class="text-advanced">Afficher avancé</span>
                                                        </a>
                                                    </div>
                                                    <div class="form-style wd-amenities">
                                                        <div class="group-checkbox">
                                                            <div class="text-1">Amenities:</div>
                                                            <div class="group-amenities">
                                                                <fieldset class="amenities-item">
                                                                    <input type="checkbox" class="tf-checkbox style-1"
                                                                        id="cb1" checked>
                                                                    <label for="cb1" class="text-cb-amenities">Air
                                                                        Condition</label>
                                                                </fieldset>
                                                                <fieldset class="amenities-item">
                                                                    <input type="checkbox" class="tf-checkbox style-1"
                                                                        id="cb2">
                                                                    <label for="cb2"
                                                                        class="text-cb-amenities">Disabled Access</label>
                                                                </fieldset>
                                                                <fieldset class="amenities-item">
                                                                    <input type="checkbox" class="tf-checkbox style-1"
                                                                        id="cb3">
                                                                    <label for="cb3"
                                                                        class="text-cb-amenities">Ceiling Height</label>
                                                                </fieldset>
                                                                <fieldset class="amenities-item">
                                                                    <input type="checkbox" class="tf-checkbox style-1"
                                                                        id="cb4" checked>
                                                                    <label for="cb4"
                                                                        class="text-cb-amenities">Floor</label>
                                                                </fieldset>
                                                                <fieldset class="amenities-item">
                                                                    <input type="checkbox" class="tf-checkbox style-1"
                                                                        id="cb5">
                                                                    <label for="cb5"
                                                                        class="text-cb-amenities">Heating</label>
                                                                </fieldset>
                                                                <fieldset class="amenities-item">
                                                                    <input type="checkbox" class="tf-checkbox style-1"
                                                                        id="cb6">
                                                                    <label for="cb6"
                                                                        class="text-cb-amenities">Renovation</label>
                                                                </fieldset>
                                                                <fieldset class="amenities-item">
                                                                    <input type="checkbox" class="tf-checkbox style-1"
                                                                        id="cb7">
                                                                    <label for="cb7" class="text-cb-amenities">Window
                                                                        Type</label>
                                                                </fieldset>
                                                                <fieldset class="amenities-item">
                                                                    <input type="checkbox" class="tf-checkbox style-1"
                                                                        id="cb8">
                                                                    <label for="cb8" class="text-cb-amenities">Cable
                                                                        TV</label>
                                                                </fieldset>
                                                                <fieldset class="amenities-item">
                                                                    <input type="checkbox" class="tf-checkbox style-1"
                                                                        id="cb9" checked>
                                                                    <label for="cb9"
                                                                        class="text-cb-amenities">Elevator</label>
                                                                </fieldset>
                                                                <fieldset class="amenities-item">
                                                                    <input type="checkbox" class="tf-checkbox style-1"
                                                                        id="cb10">
                                                                    <label for="cb10"
                                                                        class="text-cb-amenities">Furnishing</label>
                                                                </fieldset>
                                                                <fieldset class="amenities-item">
                                                                    <input type="checkbox" class="tf-checkbox style-1"
                                                                        id="cb11">
                                                                    <label for="cb11"
                                                                        class="text-cb-amenities">Intercom</label>
                                                                </fieldset>
                                                                <fieldset class="amenities-item">
                                                                    <input type="checkbox" class="tf-checkbox style-1"
                                                                        id="cb12">
                                                                    <label for="cb12"
                                                                        class="text-cb-amenities">Security</label>
                                                                </fieldset>
                                                                <fieldset class="amenities-item">
                                                                    <input type="checkbox" class="tf-checkbox style-1"
                                                                        id="cb13">
                                                                    <label for="cb13" class="text-cb-amenities">Search
                                                                        property</label>
                                                                </fieldset>
                                                                <fieldset class="amenities-item">
                                                                    <input type="checkbox" class="tf-checkbox style-1"
                                                                        id="cb14">
                                                                    <label for="cb14"
                                                                        class="text-cb-amenities">Ceiling Height</label>
                                                                </fieldset>
                                                                <fieldset class="amenities-item">
                                                                    <input type="checkbox" class="tf-checkbox style-1"
                                                                        id="cb15">
                                                                    <label for="cb15"
                                                                        class="text-cb-amenities">Fence</label>
                                                                </fieldset>
                                                                <fieldset class="amenities-item">
                                                                    <input type="checkbox" class="tf-checkbox style-1"
                                                                        id="cb16">
                                                                    <label for="cb16"
                                                                        class="text-cb-amenities">Fence</label>
                                                                </fieldset>
                                                                <fieldset class="amenities-item">
                                                                    <input type="checkbox" class="tf-checkbox style-1"
                                                                        id="cb17" checked>
                                                                    <label for="cb17"
                                                                        class="text-cb-amenities">Garage</label>
                                                                </fieldset>
                                                                <fieldset class="amenities-item">
                                                                    <input type="checkbox" class="tf-checkbox style-1"
                                                                        id="cb18">
                                                                    <label for="cb18"
                                                                        class="text-cb-amenities">Parking</label>
                                                                </fieldset>
                                                                <fieldset class="amenities-item">
                                                                    <input type="checkbox" class="tf-checkbox style-1"
                                                                        id="cb19">
                                                                    <label for="cb19"
                                                                        class="text-cb-amenities">Swimming Pool</label>
                                                                </fieldset>
                                                                <fieldset class="amenities-item">
                                                                    <input type="checkbox" class="tf-checkbox style-1"
                                                                        id="cb20">
                                                                    <label for="cb20"
                                                                        class="text-cb-amenities">Construction Year</label>
                                                                </fieldset>
                                                                <fieldset class="amenities-item">
                                                                    <input type="checkbox" class="tf-checkbox style-1"
                                                                        id="cb21">
                                                                    <label for="cb21"
                                                                        class="text-cb-amenities">Fireplace</label>
                                                                </fieldset>
                                                                <fieldset class="amenities-item">
                                                                    <input type="checkbox" class="tf-checkbox style-1"
                                                                        id="cb22">
                                                                    <label for="cb22"
                                                                        class="text-cb-amenities">Garden</label>
                                                                </fieldset>
                                                                <fieldset class="amenities-item">
                                                                    <input type="checkbox" class="tf-checkbox style-1"
                                                                        id="cb23">
                                                                    <label for="cb23" class="text-cb-amenities">Pet
                                                                        Friendly</label>
                                                                </fieldset>
                                                                <fieldset class="amenities-item">
                                                                    <input type="checkbox" class="tf-checkbox style-1"
                                                                        id="cb24">
                                                                    <label for="cb24"
                                                                        class="text-cb-amenities">WiFi</label>
                                                                </fieldset>
                                                            </div>

                                                        </div>
                                                    </div>
                                                    <div class="form-style btn-hide-advanced">
                                                        <a class="filter-advanced pull-right">
                                                            <span class="icon icon-faders"></span>
                                                            <span class="text-advanced">Masquer avancé</span>
                                                        </a>
                                                    </div>
                                                    <div class="form-style">
                                                        <button type="submit" class="tf-btn primary"
                                                            href="#">Trouver des propriétés</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>

                            </div>
                        </div> --}}
                        <div class="widget-box single-property-whychoose bg-surface">
                            <div class="h7 title fw-7">Pourquoi nous choisir ?</div>
                            <ul class="box-whychoose">
                                <li class="item-why">
                                    <i class="icon icon-secure"></i>
                                    Réservation sécurisée
                                </li>
                                <li class="item-why">
                                    <i class="icon icon-guarantee"></i>
                                    Garantie du meilleur prix
                                </li>
                                <li class="item-why">
                                    <i class="icon icon-booking"></i>
                                    Processus de réservation facile
                                </li>
                                <li class="item-why">
                                    <i class="icon icon-support"></i>
                                    Assistance disponible 24h/24 et 7j/7
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </section>
    {{-- <section class="flat-section pt-0 flat-latest-property">
        <div class="container">
            <div class="box-title">
                <div class="text-subtitle text-primary">Propriétés en vedette</div>
                <h4 class="mt-4">La succession la plus récente</h4>
            </div>
            <div class="swiper tf-latest-property" data-preview-lg="3" data-preview-md="2" data-preview-sm="2"
                data-space="30" data-loop="true">
                <div class="swiper-wrapper">
                    <div class="swiper-slide">
                        <div class="homeya-box style-2">
                            <div class="archive-top">
                                <a href="#" class="images-group">
                                    <div class="images-style">
                                        <img src="https://i.pinimg.com/736x/1e/d4/b7/1ed4b7b8112f91e889cfe4ce9802eb8e.jpg"
                                            alt="img">
                                    </div>
                                    <div class="top">
                                        <ul class="d-flex gap-8">
                                            <li class="flag-tag success">en vedette</li>
                                        </ul>
                                        <ul class="d-flex gap-4">
                                            <li class="box-icon w-32">
                                                <span class="icon icon-arrLeftRight"></span>
                                            </li>
                                            <li class="box-icon w-32">
                                                <span class="icon icon-heart"></span>
                                            </li>
                                            <li class="box-icon w-32">
                                                <span class="icon icon-eye"></span>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="bottom">
                                        <span class="flag-tag style-2">Villa</span>
                                    </div>
                                </a>
                                <div class="content">
                                    <div class="h7 text-capitalize fw-7"><a href="#" class="link"> Sunset Heights
                                            Estate, Beverly Hills</a></div>
                                    <div class="desc"><i class="fs-16 icon icon-mapPin"></i>
                                        <p>1040 Ocean, Santa Monica, California</p>
                                    </div>
                                    <ul class="meta-list">
                                        <li class="item">
                                            <i class="icon icon-bed"></i>
                                            <span>3</span>
                                        </li>
                                        <li class="item">
                                            <i class="icon icon-bathtub"></i>
                                            <span>2</span>
                                        </li>
                                        <li class="item">
                                            <i class="icon icon-ruler"></i>
                                            <span>600 SqFT</span>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="archive-bottom d-flex justify-content-between align-items-center">
                                <div class="d-flex gap-8 align-items-center">
                                    <div class="avatar avt-40 round">
                                        <img src="{{ asset('assets/images/avatar/avt-8.jpg') }}" alt="avt">
                                    </div>
                                    <span>Jacob Jones</span>
                                </div>
                                <div class="d-flex align-items-center">
                                    <h6>250,00 Fcfa</h6>
                                    <span class="text-variant-1">/Jour</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="homeya-box style-2">
                            <div class="archive-top">
                                <a href="#" class="images-group">
                                    <div class="images-style">
                                        <img src="https://i.pinimg.com/736x/a7/3d/28/a73d28c212b6b76b448dccdc8bf34604.jpg"
                                            alt="img">
                                    </div>
                                    <div class="top">
                                        <ul class="d-flex gap-8">
                                            <li class="flag-tag success">Location</li>
                                        </ul>
                                        <ul class="d-flex gap-4">
                                            <li class="box-icon w-32">
                                                <span class="icon icon-arrLeftRight"></span>
                                            </li>
                                            <li class="box-icon w-32">
                                                <span class="icon icon-heart"></span>
                                            </li>
                                            <li class="box-icon w-32">
                                                <span class="icon icon-eye"></span>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="bottom">
                                        <span class="flag-tag style-2">Bureau</span>
                                    </div>
                                </a>
                                <div class="content">
                                    <div class="h7 text-capitalize fw-7"><a href="#" class="link">Coastal
                                            Serenity Cottage</a></div>
                                    <div class="desc"><i class="fs-16 icon icon-mapPin"></i>
                                        <p>21 Hillside Drive, Beverly Hills, California</p>
                                    </div>
                                    <ul class="meta-list">
                                        <li class="item">
                                            <i class="icon icon-bed"></i>
                                            <span>4</span>
                                        </li>
                                        <li class="item">
                                            <i class="icon icon-bathtub"></i>
                                            <span>2</span>
                                        </li>
                                        <li class="item">
                                            <i class="icon icon-ruler"></i>
                                            <span>600 SqFT</span>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="archive-bottom d-flex justify-content-between align-items-center">
                                <div class="d-flex gap-8 align-items-center">
                                    <div class="avatar avt-40 round">
                                        <img src="{{ asset('assets/images/avatar/avt-6.jpg') }}" alt="avt">
                                    </div>
                                    <span>Kathryn Murphy</span>
                                </div>
                                <div class="d-flex align-items-center">
                                    <h6>$2050,00</h6>
                                    <span class="text-variant-1">/SqFT</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section> --}}

    @include('reservations.reservationModal')

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const toggle = document.querySelector('.read-more-toggle');
            if (toggle) {
                toggle.addEventListener('click', function() {
                    const isExpanded = this.getAttribute('aria-expanded') === 'true';
                    this.querySelector('.read-more-text').classList.toggle('d-none', isExpanded);
                    this.querySelector('.read-less-text').classList.toggle('d-none', !isExpanded);
                });
            }
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Récupération des coordonnées depuis les variables Blade (Laravel)
            const latitude = @json($appart->property->latitude);
            const longitude = @json($appart->property->longitude);


            // Initialisation de la carte
            const map = L.map('map-location-property').setView([latitude, longitude], 16);

            // Chargement des tuiles OpenStreetMap
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a>',
            }).addTo(map);

            // Ajout d’un marqueur à l’emplacement
            L.marker([latitude, longitude]).addTo(map)
                .bindPopup("Emplacement de la propriété")
                .openPopup();
        });
    </script>


    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('comment-form');
            const appartUuid = document.getElementById('appart_uuid').value;
            const commentsList = document.querySelector('.box-review');
            const commentsWrapper = document.querySelector('.wrap-review');
            let currentPage = 1;
            const perPage = 2;

            // Charger les commentaires au démarrage
            loadComments(currentPage);

            // ✅ Soumission du formulaire
            form.addEventListener('submit', async function(e) {
                e.preventDefault();

                const formData = new FormData(form);

                try {
                    const response = await fetch("/api/add-comments", {
                        method: "POST",
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                .content
                        },
                        body: formData
                    });

                    const data = await response.json();

                    if (data.success) {
                        form.reset();
                        loadComments(1);
                        Swal.fire({
                            icon: 'success',
                            title: data.message,
                            showConfirmButton: false,
                            timer: 1500
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: data.message,
                            showConfirmButton: true,
                            confirmButtonText: 'OK'
                        });
                    }
                } catch (err) {
                    console.error("Erreur Fetch:", err);
                }
            });

            function timeAgo(dateString) {
                const now = new Date();
                const commentDate = new Date(dateString);
                const diff = Math.floor((now - commentDate) / 1000); // différence en secondes

                if (diff < 60) return `il y a ${diff} seconde${diff > 1 ? 's' : ''}`;
                if (diff < 3600) {
                    const minutes = Math.floor(diff / 60);
                    return `il y a ${minutes} minute${minutes > 1 ? 's' : ''}`;
                }
                if (diff < 86400) {
                    const hours = Math.floor(diff / 3600);
                    return `il y a ${hours} heure${hours > 1 ? 's' : ''}`;
                }
                const days = Math.floor(diff / 86400);
                return `il y a ${days} jour${days > 1 ? 's' : ''}`;
            }
            // ✅ Charger les commentaires avec pagination
            function loadComments(page = 1) {
                fetch(`/api/get-comments?page=${page}&perPage=${perPage}&appart_uuid=${appartUuid}`)
                    .then(res => res.json())
                    .then(data => {
                        commentsList.innerHTML = "";

                        if (data.data.length === 0) {
                            commentsList.innerHTML = "<li>Aucun commentaire pour le moment.</li>";
                            return;
                        }

                        data.data.forEach(comment => {
                            let rating = parseInt(comment.rating) ||
                                0; // on s'assure que c'est un nombre
                            let stars = "";

                            for (let i = 0; i < 5; i++) {
                                stars +=
                                    `<li class="icon-star ${i < rating ? 'text-warning' : ''}"></li>`;
                            }
                            
                            commentsList.innerHTML += `
                            <li class="list-review-item">
                                <div class="avatar avt-60 round">
                                    <img src="/assets/images/avatar/user-profile.webp" alt="avatar">
                                </div>
                                <div class="content">
                                    <div class="name h7 fw-7 text-black">${comment.name}</div>
                                    <span class="mt-4 d-inline-block date body-3 text-variant-2">
                                        ${timeAgo(comment.created_at)}
                                    </span>
                                    <ul class="mt-8 list-star-note">${stars}</ul>
                                    <p class="mt-12 body-2 text-black">${comment.comment}</p>
                                </div>
                            </li>
                        `;
                        });

                        renderPagination(data.meta);
                    })
                    .catch(err => console.error(err));
            }

            // function renderPagination(meta) {
            //     let paginationHTML = "";
            //     const totalPages = meta.last_page;

            //     if (totalPages > 1) {
            //         paginationHTML += `
        //         <nav class="mt-4">
        //             <ul class="pagination justify-content-center">`;

            //                     for (let i = 1; i <= totalPages; i++) {
            //                         paginationHTML += `
        //             <li class="page-item ${i === meta.current_page ? 'active' : ''}">
        //                 <a class="page-link" href="#" data-page="${i}">${i}</a>
        //             </li>`;
            //                     }

            //                     paginationHTML += `
        //             </ul>
        //         </nav>`;
            //     }

            //     commentsWrapper.querySelector(".pagination")?.remove(); // Supprime ancienne pagination
            //     commentsWrapper.insertAdjacentHTML("beforeend", paginationHTML);

            //     // Gestion des clics
            //     document.querySelectorAll('.page-link').forEach(link => {
            //         link.addEventListener('click', function(e) {
            //             e.preventDefault();
            //             currentPage = parseInt(this.dataset.page);
            //             loadComments(currentPage);
            //         });
            //     });
            // }
            function renderPagination(meta) {
                const totalPages = meta.last_page;
                const currentPage = meta.current_page;
                let paginationHTML = "";

                if (totalPages > 1) {
                    paginationHTML += `
        <nav class="pt-4">
            <ul class="pagination justify-content-center">`;

                    // Bouton "Précédent"
                    paginationHTML += `
            <li class="page-item ${currentPage === 1 ? 'disabled' : ''}">
                <a class="page-link" href="#" data-page="${currentPage - 1}">Précédent</a>
            </li>`;

                    // Pages
                    for (let i = 1; i <= totalPages; i++) {
                        // Afficher toujours la première et dernière page
                        if (i === 1 || i === totalPages || (i >= currentPage - 1 && i <= currentPage + 1)) {
                            paginationHTML += `
                <li class="page-item ${i === currentPage ? 'active' : ''}">
                    <a class="page-link" href="#" data-page="${i}">${i}</a>
                </li>`;
                        } else if (i === 2 && currentPage > 3) {
                            paginationHTML +=
                                `<li class="page-item disabled"><span class="page-link">...</span></li>`;
                        } else if (i === totalPages - 1 && currentPage < totalPages - 2) {
                            paginationHTML +=
                                `<li class="page-item disabled"><span class="page-link">...</span></li>`;
                        }
                    }

                    // Bouton "Suivant"
                    paginationHTML += `
            <li class="page-item ${currentPage === totalPages ? 'disabled' : ''}">
                <a class="page-link" href="#" data-page="${currentPage + 1}">Suivant</a>
            </li>`;

                    paginationHTML += `
            </ul>
        </nav>`;
                }

                // Supprime l'ancienne pagination et ajoute la nouvelle
                commentsWrapper.querySelector(".pagination")?.remove();
                commentsWrapper.insertAdjacentHTML("beforeend", paginationHTML);

                // Gestion des clics
                document.querySelectorAll('.page-link').forEach(link => {
                    link.addEventListener('click', function(e) {
                        e.preventDefault();
                        const page = parseInt(this.dataset.page);
                        if (!isNaN(page) && page >= 1 && page <= totalPages) {
                            loadComments(page);
                        }
                    });
                });
            }

        });
    </script>




@endsection
