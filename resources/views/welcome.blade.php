@extends('layouts.main')
@section('content')
    <!-- Map -->
    <section class="flat-map">
        <div id="map" class="top-map" data-map-zoom="16" data-map-scroll="true"></div>

        <div class="container">
            <div class="wrap-filter-search">
                <div class="flat-tab flat-tab-form">
                    <ul class="nav-tab-form style-3 justify-content-center" role="tablist">
                        <li class="nav-tab-item" role="presentation">
                            <a href="#forRent" class="nav-link-item active" data-bs-toggle="tab">Location </a>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane fade active show" role="tabpanel">
                            <div class="form-sl">
                                <form method="post">
                                    <div class="wd-find-select shadow-st">
                                        <div class="inner-group">
                                            <div class="form-group-1 search-form form-style">
                                                <label>Mot-clé</label>
                                                <input type="text" class="form-control"
                                                    placeholder="Rechercher par Mot-clé." value="" name="s"
                                                    title="Search for" required="">
                                            </div>
                                            <div class="form-group-2 form-style">
                                                <label>Localisation</label>
                                                <div class="group-ip">
                                                    <input type="text" class="form-control"
                                                        placeholder="Search Localisation" value="" name="s"
                                                        title="Search for" required="">
                                                    <a href="#" class="icon icon-location"></a>
                                                </div>
                                            </div>
                                            <div class="form-group-3 form-style">
                                                <label>Type</label>
                                                <div class="group-select">
                                                    <div class="nice-select" tabindex="0"><span
                                                            class="current">Tous</span>
                                                        <ul class="list">
                                                            <li data-value class="option selected">Tous</li>
                                                            <li data-value="villa" class="option">Villa</li>
                                                            <li data-value="studio" class="option">Studio</li>
                                                            <li data-value="office" class="option">Bureau</li>
                                                            <li data-value="house" class="option">Maison</li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group-4 box-filter">
                                                <a class="filter-advanced pull-right">
                                                    <span class="icon icon-faders"></span>
                                                    <span class="text-1">Avancé</span>
                                                </a>
                                            </div>
                                        </div>
                                        <button type="submit" class="tf-btn primary" href="#">Rechercher</button>
                                    </div>
                                    <div class="wd-search-form">
                                        <div class="grid-2 group-box group-price">
                                            <div class="widget-price">
                                                <div class="box-title-price">
                                                    <span class="title-price">Fourchette de prix</span>
                                                    <div class="caption-price">
                                                        <span>De</span>
                                                        <span id="slider-range-value1" class="fw-7"></span>
                                                        <span>à</span>
                                                        <span id="slider-range-value2" class="fw-7"></span>
                                                    </div>
                                                </div>
                                                <div id="slider-range"></div>
                                                <div class="slider-labels">
                                                    <div>
                                                        <input type="hidden" name="min-value" value="">
                                                        <input type="hidden" name="max-value" value="">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="widget-price">
                                                <div class="box-title-price">
                                                    <span class="title-price">Gamme de tailles</span>
                                                    <div class="caption-price">
                                                        <span>De</span>
                                                        <span id="slider-range-value01" class="fw-7"></span>
                                                        <span>à</span>
                                                        <span id="slider-range-value02" class="fw-7"></span>
                                                    </div>
                                                </div>
                                                <div id="slider-range2"></div>
                                                <div class="slider-labels">
                                                    <div>
                                                        <input type="hidden" name="min-value2" value="">
                                                        <input type="hidden" name="max-value2" value="">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="grid-2 group-box">
                                            <div class="group-select grid-2">
                                                <div class="box-select">
                                                    <label class="title-select text-variant-1">Chambres</label>
                                                    <div class="nice-select" tabindex="0"><span
                                                            class="current">2</span>
                                                        <ul class="list">
                                                            <li data-value="1" class="option">1</li>
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
                                                <div class="box-select">
                                                    <label class="title-select text-variant-1">Salles de bains</label>
                                                    <div class="nice-select" tabindex="0"><span
                                                            class="current">2</span>
                                                        <ul class="list">
                                                            <li data-value="1" class="option">1</li>
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
                                            </div>
                                            <div class="group-select grid-2">
                                                <div class="box-select">
                                                    <label class="title-select text-variant-1">Chambres à coucher</label>
                                                    <div class="nice-select" tabindex="0"><span
                                                            class="current">2</span>
                                                        <ul class="list">
                                                            <li data-value="1" class="option">1</li>
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
                                                <div class="box-select">
                                                    <label class="title-select fw-5">Type</label>
                                                    <div class="nice-select" tabindex="0"><span
                                                            class="current">2</span>
                                                        <ul class="list">
                                                            <li data-value="1" class="option">1</li>
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
                                            </div>

                                        </div>

                                        {{-- <div class="group-checkbox">
                                            <div class="text-1">Amenities:</div>
                                            <div class="group-amenities mt-8 grid-6">
                                                <div class="box-amenities">
                                                    <fieldset class="amenities-item">
                                                        <input type="checkbox" class="tf-checkbox style-1" id="cb1"
                                                            checked>
                                                        <label for="cb1" class="text-cb-amenities">Air
                                                            Condition</label>
                                                    </fieldset>
                                                    <fieldset class="amenities-item mt-12">
                                                        <input type="checkbox" class="tf-checkbox style-1"
                                                            id="cb2">
                                                        <label for="cb2" class="text-cb-amenities">Cable TV</label>
                                                    </fieldset>
                                                    <fieldset class="amenities-item mt-12">
                                                        <input type="checkbox" class="tf-checkbox style-1"
                                                            id="cb3">
                                                        <label for="cb3" class="text-cb-amenities">Ceiling
                                                            Height</label>
                                                    </fieldset>
                                                    <fieldset class="amenities-item mt-12">
                                                        <input type="checkbox" class="tf-checkbox style-1"
                                                            id="cb4">
                                                        <label for="cb4" class="text-cb-amenities">Fireplace</label>
                                                    </fieldset>
                                                </div>
                                                <div class="box-amenities">
                                                    <fieldset class="amenities-item">
                                                        <input type="checkbox" class="tf-checkbox style-1"
                                                            id="cb5">
                                                        <label for="cb5" class="text-cb-amenities">Disabled
                                                            Access</label>
                                                    </fieldset>
                                                    <fieldset class="amenities-item mt-12">
                                                        <input type="checkbox" class="tf-checkbox style-1" id="cb6"
                                                            checked>
                                                        <label for="cb6" class="text-cb-amenities">Elevator</label>
                                                    </fieldset>
                                                    <fieldset class="amenities-item mt-12">
                                                        <input type="checkbox" class="tf-checkbox style-1"
                                                            id="cb7">
                                                        <label for="cb7" class="text-cb-amenities">Fence</label>
                                                    </fieldset>
                                                    <fieldset class="amenities-item mt-12">
                                                        <input type="checkbox" class="tf-checkbox style-1"
                                                            id="cb8">
                                                        <label for="cb8" class="text-cb-amenities">Garden</label>
                                                    </fieldset>
                                                </div>
                                                <div class="box-amenities">
                                                    <fieldset class="amenities-item">
                                                        <input type="checkbox" class="tf-checkbox style-1" id="cb9"
                                                            checked>
                                                        <label for="cb9" class="text-cb-amenities">Floor</label>
                                                    </fieldset>
                                                    <fieldset class="amenities-item mt-12">
                                                        <input type="checkbox" class="tf-checkbox style-1"
                                                            id="cb10">
                                                        <label for="cb10" class="text-cb-amenities">Furnishing</label>
                                                    </fieldset>
                                                    <fieldset class="amenities-item mt-12">
                                                        <input type="checkbox" class="tf-checkbox style-1" id="cb11"
                                                            checked>
                                                        <label for="cb11" class="text-cb-amenities">Garage</label>
                                                    </fieldset>
                                                    <fieldset class="amenities-item mt-12">
                                                        <input type="checkbox" class="tf-checkbox style-1"
                                                            id="cb12">
                                                        <label for="cb12" class="text-cb-amenities">Pet
                                                            Friendly</label>
                                                    </fieldset>
                                                </div>
                                                <div class="box-amenities">
                                                    <fieldset class="amenities-item">
                                                        <input type="checkbox" class="tf-checkbox style-1"
                                                            id="cb13">
                                                        <label for="cb13" class="text-cb-amenities">Heating</label>
                                                    </fieldset>
                                                    <fieldset class="amenities-item mt-12">
                                                        <input type="checkbox" class="tf-checkbox style-1"
                                                            id="cb14">
                                                        <label for="cb14" class="text-cb-amenities">Intercom</label>
                                                    </fieldset>
                                                    <fieldset class="amenities-item mt-12">
                                                        <input type="checkbox" class="tf-checkbox style-1"
                                                            id="cb15">
                                                        <label for="cb15" class="text-cb-amenities">Parking</label>
                                                    </fieldset>
                                                    <fieldset class="amenities-item mt-12">
                                                        <input type="checkbox" class="tf-checkbox style-1"
                                                            id="cb16">
                                                        <label for="cb16" class="text-cb-amenities">WiFi</label>
                                                    </fieldset>
                                                </div>
                                                <div class="box-amenities">
                                                    <fieldset class="amenities-item">
                                                        <input type="checkbox" class="tf-checkbox style-1"
                                                            id="cb17">
                                                        <label for="cb17" class="text-cb-amenities">Renovation</label>
                                                    </fieldset>
                                                    <fieldset class="amenities-item mt-12">
                                                        <input type="checkbox" class="tf-checkbox style-1"
                                                            id="cb18">
                                                        <label for="cb18" class="text-cb-amenities">Security</label>
                                                    </fieldset>
                                                    <fieldset class="amenities-item mt-12">
                                                        <input type="checkbox" class="tf-checkbox style-1"
                                                            id="cb19">
                                                        <label for="cb19" class="text-cb-amenities">Swimming
                                                            Pool</label>
                                                    </fieldset>

                                                </div>
                                                <div class="box-amenities">
                                                    <fieldset class="amenities-item">
                                                        <input type="checkbox" class="tf-checkbox style-1"
                                                            id="cb20">
                                                        <label for="cb20" class="text-cb-amenities">Window
                                                            Type</label>
                                                    </fieldset>
                                                    <fieldset class="amenities-item mt-12">
                                                        <input type="checkbox" class="tf-checkbox style-1"
                                                            id="cb21">
                                                        <label for="cb21" class="text-cb-amenities">Search
                                                            property</label>
                                                    </fieldset>
                                                    <fieldset class="amenities-item mt-12">
                                                        <input type="checkbox" class="tf-checkbox style-1"
                                                            id="cb22">
                                                        <label for="cb22" class="text-cb-amenities">Construction
                                                            Year</label>
                                                    </fieldset>
                                                </div>

                                            </div>

                                        </div> --}}
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
                <div class="text-subtitle text-primary">Propriétés en vedette</div>
                <h4 class="mt-4">Découvrez les meilleures propriétés pour un sejour de rêve</h4>
            </div>
            <div class="row wow fadeInUpSmall" data-wow-delay=".2s" data-wow-duration="2000ms">
                <div class="col-xl-4 col-md-6">
                    <div class="homeya-box style-3">
                        <div class="images-group">
                            <div class="images-style">
                                <img src="{{ asset('assets/images/home/bedroom1.jpg') }}" alt="img">
                            </div>
                            <div class="top">
                                <ul class="d-flex gap-8">
                                    <li class="flag-tag success">En vedette</li>
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
                            <div class="content">
                                <div class="title text-1 text-capitalize"><a href="{{ route('property.show') }}"
                                        class="link text-white">Casa Lomas de Machalí Machas</a></div>
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
                                        <span>600 Fcfa/jour</span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-4 col-md-6">
                    <div class="homeya-box style-3">
                        <div class="images-group">
                            <div class="images-style">
                                <img src="{{ asset('assets/images/home/bedroom7.jpg') }}" alt="img">
                            </div>
                            <div class="top">
                                <ul class="d-flex gap-8">
                                    <li class="flag-tag success">En vedette</li>
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
                            <div class="content">
                                <div class="title text-1 text-capitalize"><a href="{{ route('property.show') }}"
                                        class="link text-white">Casa Lomas de Machalí Machas</a></div>
                               
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
                                        <span>600 Fdfa/jour</span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-4 col-md-6">
                    <div class="homeya-box style-3">
                        <div class="images-group">
                            <div class="images-style">
                                <img src="{{ asset('assets/images/home/bedroom3.jpg') }}" alt="img">
                            </div>
                            <div class="top">
                                <ul class="d-flex gap-8">
                                    <li class="flag-tag success">En vedette</li>
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
                            <div class="content">
                                <div class="title text-1 text-capitalize"><a href="{{ route('property.show') }}"
                                        class="link text-white">Casa Lomas de Machalí Machas</a></div>
                               
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
                                        <span>600 Fcfa</span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-4 col-md-6">
                    <div class="homeya-box style-3">
                        <div class="images-group">
                            <div class="images-style">
                                <img src="{{ asset('assets/images/home/bedroom5.jpg') }}" alt="img">
                            </div>
                            <div class="top">
                                <ul class="d-flex gap-8">
                                    <li class="flag-tag success">En vedette</li>
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
                            <div class="content">
                                <div class="title text-1 text-capitalize"><a href="{{ route('property.show') }}"
                                        class="link text-white">Casa Lomas de Machalí Machas</a></div>
                               
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
                                        <span>600 Fcfa</span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-4 col-md-6">
                    <div class="homeya-box style-3">
                        <div class="images-group">
                            <div class="images-style">
                                <img src="{{ asset('assets/images/home/bedroom6.jpg') }}" alt="img">
                            </div>
                            <div class="top">
                                <ul class="d-flex gap-8">
                                    <li class="flag-tag success">En vedette</li>
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
                            <div class="content">
                                <div class="title text-1 text-capitalize"><a href="{{ route('property.show') }}"
                                        class="link text-white">Casa Lomas de Machalí Machas</a></div>
                               
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
                                        <span>600 Fcfa</span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-4 col-md-6">
                    <div class="homeya-box style-3">
                        <div class="images-group">
                            <div class="images-style">
                                <img src="{{ asset('assets/images/home/bedroom2.jpg') }}" alt="img">
                            </div>
                            <div class="top">
                                <ul class="d-flex gap-8">
                                    <li class="flag-tag success">En vedette</li>
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
                            <div class="content">
                                <div class="title text-1 text-capitalize"><a href="{{ route('property.show') }}"
                                        class="link text-white">Casa Lomas de Machalí Machas</a></div>
                               
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
                                        <span>600 fcfa</span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="text-center">
                <a href="#" class="tf-btn primary size-1">Voir tous les biens</a>
            </div>
        </div>
    </section>
    <!-- End Recommended -->
    <!-- Location -->
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
                        <div class="swiper-slide">
                            <a href="#" class="box-location">
                                <div class="image">
                                    <img src="{{ asset('assets/images/location/abidjan.jpg') }}" alt="image-location">
                                </div>
                                <div class="content">
                                    <span class="sub-title">321 Propriété</span>
                                    <h6 class="title">Cote d'Ivoire , Abidjan</h6>
                                </div>
                            </a>
                        </div>
                        <div class="swiper-slide">
                            <a href="#" class="box-location">
                                <div class="image">
                                    <img src="{{ asset('assets/images/location/yakro.jpg') }}" alt="image-location">
                                </div>
                                <div class="content">
                                    <span class="sub-title">221 Propriété</span>
                                    <h6 class="title">Cote d'Ivoire , Yamoussokro</h6>
                                </div>
                            </a>
                        </div>
                        <div class="swiper-slide">
                            <a href="#" class="box-location">
                                <div class="image">
                                    <img src="{{ asset('assets/images/location/bouake.jpg') }}" alt="image-location">
                                </div>
                                <div class="content">
                                    <span class="sub-title">128 Propriété</span>
                                    <h6 class="title">cote d'ivoire , Bouake</h6>
                                </div>
                            </a>
                        </div>
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
    <section class="flat-section flat-property">
        <div class="container">
            <div class="box-title style-1 wow fadeInUpSmall" data-wow-delay=".2s" data-wow-duration="2000ms">
                <div class="box-left">
                    <div class="text-subtitle text-primary">Recommandations</div>
                    <h4 class="mt-4">Meilleure valeur immobilière</h4>
                </div>
                <a href="#" class="tf-btn primary size-1">Voir Plus</a>
            </div>
            <div class="wrap-property">
                <div class="box-left  wow fadeInLeftSmall" data-wow-delay=".2s" data-wow-duration="2000ms">
                    <div class="homeya-box lg">
                        <div class="archive-top">
                            <a href="{{ route('property.show') }}" class="images-group">
                                <div class="images-style">
                                    <img src="https://i.pinimg.com/736x/5a/28/de/5a28de8ace9993c432da0d197ba8b4a7.jpg" alt="img">
                                </div>
                                <div class="top">
                                    <ul class="d-flex gap-8">
                                        <li class="flag-tag success style-3">Location</li>
                                        {{-- <li class="flag-tag style-1 style-3">For Sale</li> --}}
                                    </ul>
                                    <ul class="d-flex gap-4">
                                        <li class="box-icon w-40">
                                            <span class="icon icon-arrLeftRight"></span>
                                        </li>
                                        <li class="box-icon w-40">
                                            <span class="icon icon-heart"></span>
                                        </li>
                                        <li class="box-icon w-40">
                                            <span class="icon icon-eye"></span>
                                        </li>
                                    </ul>
                                </div>
                                <div class="bottom">
                                    <span class="flag-tag style-2">VILLA</span>
                                </div>
                            </a>
                            <div class="content">
                                <h5 class="text-capitalize"><a href="{{ route('property.show') }}" class="link"> Lorem ipsum dolor sit amet</a></h5>
                                <div class="desc"><i class="icon icon-mapPin"></i>
                                    <p>Lorem ipsum dolor sit amet consectetur</p>
                                </div>
                                <p class="note">"Lorem ipsum dolor sit amet consectetur adipisicing elit. Ipsa molestiae dicta aperiam...</p>
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
                                    <img src="{{ asset('assets/images/avatar/avt-11.jpg')}}" alt="avt">
                                </div>
                                <span class="body-2">Floyd Miles</span>
                            </div>
                            <div class="d-flex align-items-center">
                                <h6>25 000 FCFA</h6>
                                <span class="text-variant-1">/Jour</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="box-right wow fadeInRightSmall" data-wow-delay=".2s" data-wow-duration="2000ms">
                    <div class="homeya-box list-style-1">
                        <a href="{{ route('property.show') }}" class="images-group">
                            <div class="images-style">
                                <img src="https://i.pinimg.com/736x/36/68/f1/3668f15d041645b979737d94116a1326.jpg" alt="img">
                            </div>
                            <div class="top">
                                <ul class="d-flex gap-4 flex-wrap flex-column">
                                    <li class="flag-tag success">Location</li>
                                    {{-- <li class="flag-tag style-1">For Sale</li> --}}
                                </ul>
                                <ul class="d-flex gap-4">
                                    <li class="box-icon w-28">
                                        <span class="icon icon-arrLeftRight"></span>
                                    </li>
                                    <li class="box-icon w-28">
                                        <span class="icon icon-heart"></span>
                                    </li>
                                    <li class="box-icon w-28">
                                        <span class="icon icon-eye"></span>
                                    </li>
                                </ul>
                            </div>
                            <div class="bottom">
                                <span class="flag-tag style-2">Villa</span>
                            </div>
                        </a>
                        <div class="content">
                            <div class="archive-top">
                                <div class="h7 text-capitalize fw-7"><a href="{{ route('property.show') }}"
                                        class="link">Lorem ipsum dolor sit amet consectetur</a></div>
                                <div class="desc"><i class="icon icon-mapPin"></i>
                                    <p>Lorem ipsum dolor sit amet consectetur</p>
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
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="d-flex gap-8 align-items-center">
                                    <div class="avatar avt-40 round">
                                        <img src="{{ asset('assets/images/avatar/avt-5.jpg')}}" alt="avt">
                                    </div>
                                    <span>Ralph Edwards</span>
                                </div>
                                <div class="d-flex align-items-center">
                                    <div class="h7 fw-7">5050 FCFA</div>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="homeya-box list-style-1">
                        <a href="{{ route('property.show') }}" class="images-group">
                            <div class="images-style">
                                <img src="https://i.pinimg.com/736x/a7/c6/fe/a7c6fe4e1868a144d562024de841cb6d.jpg" alt="img">
                            </div>
                            <div class="top">
                                <ul class="d-flex">
                                    <li class="flag-tag style-1">For Sale</li>
                                </ul>
                                <ul class="d-flex gap-4">
                                    <li class="box-icon w-28">
                                        <span class="icon icon-arrLeftRight"></span>
                                    </li>
                                    <li class="box-icon w-28">
                                        <span class="icon icon-heart"></span>
                                    </li>
                                    <li class="box-icon w-28">
                                        <span class="icon icon-eye"></span>
                                    </li>
                                </ul>
                            </div>
                            <div class="bottom">
                                <span class="flag-tag style-2">Villa</span>
                            </div>
                        </a>
                        <div class="content">
                            <div class="archive-top">
                                <div class="h7 text-capitalize fw-7"><a href="{{ route('property.show') }}"
                                        class="link">Lorem ipsum dolor sit amet consectetur</a></div>
                                <div class="desc"><i class="icon icon-mapPin"></i>
                                    <p>Lorem ipsum dolor sit amet consectetur</p>
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
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="d-flex gap-8 align-items-center">
                                    <div class="avatar avt-40 round">
                                        <img src="{{ asset('assets/images/avatar/avt-7.jpg')}}" alt="avt">
                                    </div>
                                    <span>Annette Black</span>
                                </div>
                                <div class="d-flex align-items-center">
                                    <div class="h7 fw-7">25 000 FCFA</div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
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
                                    <div class="h7 fw-7">Lorem, ipsum.</div>
                                    <p class="text-variant-1 mt-4">Lorem, ipsum.</p>
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
                                    <div class="h7 fw-7">Lorem, ipsum.</div>
                                    <p class="text-variant-1 mt-4">Lorem, ipsum.</p>
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
                                    <div class="h7 fw-7">Lorem, ipsum.</div>
                                    <p class="text-variant-1 mt-4">Lorem, ipsum.</p>
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
                                "I truly appreciate the professionalism and in-depth knowledge of the brokerage team. They
                                not only helped me find the perfect home but also assisted with legal and financial aspects,
                                making me feel confident and secure in my decision."
                            </p>
                            <div class="box-avt d-flex align-items-center gap-12">
                                <div class="avatar avt-60 round">
                                    <img src="{{ asset('assets/images/avatar/avt-7.jpg') }}" alt="avatar">
                                </div>
                                <div class="info">
                                    <div class="h7 fw-7">Liam Anderson</div>
                                    <p class="text-variant-1 mt-4">CEO Digital</p>
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
                    <a href="#" data-bs-toggle="modal" data-bs-target="#demandPartnariaModal" class="tf-btn primary size-1">Devenir hébergeur</a>
                </div>
                <div class="box-right">
                    <img src="{{ asset('assets/images/banner/banner.png') }}" alt="image">
                </div>
            </div>
        </div>
    </section>
    <!-- end banner -->
@endsection
