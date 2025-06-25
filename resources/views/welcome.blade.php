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
                            <a href="#forRent" class="nav-link-item active" data-bs-toggle="tab">Location</a>
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
                                                <input type="text" class="form-control" placeholder="Rechercher par Mot-clé."
                                                    value="" name="s" title="Search for" required="">
                                            </div>
                                            <div class="form-group-2 form-style">
                                                <label>Localisation</label>
                                                <div class="group-ip">
                                                    <input type="text" class="form-control" placeholder="Search Localisation"
                                                        value="" name="s" title="Search for" required="">
                                                    <a href="#" class="icon icon-location"></a>
                                                </div>
                                            </div>
                                            <div class="form-group-3 form-style">
                                                <label>Type</label>
                                                <div class="group-select">
                                                    <div class="nice-select" tabindex="0"><span class="current">Tous</span>
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

                                        <div class="group-checkbox">
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

                                        </div>
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
                <h4 class="mt-4">Découvrez les meilleures propriétés de MOKAZ pour votre sejour de rêve</h4>
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
                                    <li class="flag-tag style-1">A vendre</li>
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
                                <div class="title text-1 text-capitalize"><a href="property-details-v1.html"
                                        class="link text-white">Casa Lomas de Machalí Machas</a></div>
                                <div class="d-flex align-items-center price">
                                    <div class="h7 fw-7 text-white">$7250,00</div>
                                    <span class="text-white">/SqFT</span>
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
                                    <li class="flag-tag style-1">A vendre</li>
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
                                <div class="title text-1 text-capitalize"><a href="property-details-v1.html"
                                        class="link text-white">Casa Lomas de Machalí Machas</a></div>
                                <div class="d-flex align-items-center price">
                                    <div class="h7 fw-7 text-white">$7250,00</div>
                                    <span class="text-white">/SqFT</span>
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
                                    <li class="flag-tag style-1">A vendre</li>
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
                                <div class="title text-1 text-capitalize"><a href="property-details-v1.html"
                                        class="link text-white">Casa Lomas de Machalí Machas</a></div>
                                <div class="d-flex align-items-center price">
                                    <div class="h7 fw-7 text-white">$7250,00</div>
                                    <span class="text-white">/SqFT</span>
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
                                    <li class="flag-tag style-1">A vendre</li>
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
                                <div class="title text-1 text-capitalize"><a href="property-details-v1.html"
                                        class="link text-white">Casa Lomas de Machalí Machas</a></div>
                                <div class="d-flex align-items-center price">
                                    <div class="h7 fw-7 text-white">$7250,00</div>
                                    <span class="text-white">/SqFT</span>
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
                                    <li class="flag-tag style-1">A vendre</li>
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
                                <div class="title text-1 text-capitalize"><a href="property-details-v1.html"
                                        class="link text-white">Casa Lomas de Machalí Machas</a></div>
                                <div class="d-flex align-items-center price">
                                    <div class="h7 fw-7 text-white">$7250,00</div>
                                    <span class="text-white">/SqFT</span>
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
                                    <li class="flag-tag style-1">A vendre</li>
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
                                <div class="title text-1 text-capitalize"><a href="property-details-v1.html"
                                        class="link text-white">Casa Lomas de Machalí Machas</a></div>
                                <div class="d-flex align-items-center price">
                                    <div class="h7 fw-7 text-white">$7250,00</div>
                                    <span class="text-white">/SqFT</span>
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
                    </div>
                </div>
            </div>
            <div class="text-center">
                <a href="#" class="tf-btn primary size-1">Voir tous les biens</a>
            </div>
        </div>
    </section>
    <!-- End Recommended -->
    <!-- Service -->
    <section class="flat-section flat-service-v4">
        <div class="container">
            <div class="wrap-service-v4 wow fadeInUpSmall" data-wow-delay=".2s" data-wow-duration="2000ms">
                <div class="inner-service-left">
                    <div class="img-service">
                        <img src="{{ asset('assets/images/home/house-pvt-2.jpg')}}" alt="img-service">
                        <div class="box-graphic box-avatar">
                            <div class="avatar avt-56">
                                <img src="{{ asset('assets/images/avatar/avt-13.jpg')}}" alt="avt">
                                <span class="status"></span>
                            </div>
                            <div class="content">
                                <div class="tf-counter">
                                    <h6 class="text-primary d-flex">
                                        +<span class="number" data-speed="2000" data-to="480"
                                            data-inviewport="yes">480</span>k
                                    </h6>
                                </div>
                                <span class="title">Partenaires</span>
                            </div>
                        </div>
                        <div class="box-graphic box-trader">
                            <div class="content">
                                <div class="tf-counter">
                                    <h4 class="text-primary d-flex justify-content-center">
                                        <span class="number" data-speed="2000" data-to="2.5" data-dec="1"
                                            data-inviewport="yes">2,5</span>k+
                                    </h4>
                                </div>
                                <span class="title">Propriété disponible</span>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="inner-service-right">
                    <div class="box-title">
                        <div class="text-subtitle text-primary">Ce que nous faisons</div>
                        <h4 class="mt-4">Découvrez ce qui fait la force de notre entreprise</h4>
                        <p class="desc">Chez MOKAZ, notre engagement inébranlable consiste à créer des parcours immobiliers inégalés et des expériences de vie exceptionnelles pour nos clients.</p>
                    </div>
                    <ul class="list-service">
                        <li class="box-service hover-btn-view style-4">
                            <div class="icon-box">
                                <span class="icon icon-buy-home"></span>
                            </div>
                            <div class="content">
                                <h6 class="title">Reserver un logement</h6>
                                <p class="description">Explorez diverses propriétés et bénéficiez d'un sejour agréable.</p>
                                <a href="#" class="btn-view style-1"><span class="text">En savoir plus</span> <span
                                        class="icon icon-arrow-right2"></span> </a>
                            </div>
                        </li>
                        <li class="box-service hover-btn-view style-4">
                            <div class="icon-box">
                                <span class="icon icon-rent-home"></span>
                            </div>
                            <div class="content">
                                <h6 class="title">Louer une maison</h6>
                                <p class="description">Explorez une grande variété d'offres adaptées précisément à vos besoins uniques en matière de style de vie.</p>
                                <a href="#" class="btn-view style-1"><span class="text">En savoir plus</span> <span
                                        class="icon icon-arrow-right2"></span> </a>
                            </div>
                        </li>
                        <li class="box-service hover-btn-view style-4">
                            <div class="icon-box">
                                <span class="icon icon-sale-home"></span>
                            </div>
                            <div class="content">
                                <h6 class="title">Acheter un nouveau logement</h6>
                                <p class="description">Mettre en valeur les atouts de votre bien pour une vente réussie.</p>
                                <a href="#" class="btn-view style-1"><span class="text">En savoir plus</span> <span
                                        class="icon icon-arrow-right2"></span> </a>
                            </div>
                        </li>

                    </ul>
                </div>
            </div>
        </div>
    </section>
    <!-- End Service -->
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
    <!-- Agents -->
    <section class="flat-section flat-agents">
        <div class="container">
            <div class="box-title wow fadeInUpSmall" data-wow-delay=".2s" data-wow-duration="2000ms">
                <div class="text-subtitle text-primary">Nos équipes</div>
                <h4 class="mt-4">Rencontrez nos agents</h4>
            </div>
            <div class="row wow fadeInUpSmall" data-wow-delay=".4s" data-wow-duration="2000ms">
                <div class="box col-lg-4 col-sm-6">
                    <div class="box-agent style-1 style-3 hover-img">
                        <div class="box-img img-style">
                            <img src="{{ asset('assets/images/agents/agent-lg-4.jpg')}}" alt="image-agent">
                            <ul class="agent-social">
                                <li><a href="#" class="icon icon-facebook"></a></li>
                                <li><a href="#" class="icon icon-linkedin"></a></li>
                                <li><a href="#" class="icon icon-twitter"></a></li>
                                <li><a href="#" class="icon icon-instagram"></a></li>
                            </ul>
                        </div>
                        <div class="content">
                            <h6><a href="#" class="link"></a> Jack Halow</h6>
                            <p class="mt-4 text-variant-1">CEO & Founder</p>
                            <ul class="list-info">
                                <li><span class="icon icon-phone2"></span>1-333-345-6868</li>
                                <li><span class="icon icon-mail"></span>hi.avitex@gmail.com</li>
                                <li><span class="icon icon-mapPinLine"></span>101 E 129th St, East Chicago, IN 46312, US
                                </li>
                            </ul>
                            <a href="#" class="tf-btn size-1">Contact Agent</a>
                        </div>
                    </div>
                </div>
                <div class="box col-lg-4 col-sm-6">
                    <div class="box-agent style-1 style-3 hover-img">
                        <div class="box-img img-style">
                            <img src="{{ asset('assets/images/agents/agent-lg-1.jpg')}}" alt="image-agent">
                            <ul class="agent-social">
                                <li><a href="#" class="icon icon-facebook"></a></li>
                                <li><a href="#" class="icon icon-linkedin"></a></li>
                                <li><a href="#" class="icon icon-twitter"></a></li>
                                <li><a href="#" class="icon icon-instagram"></a></li>
                            </ul>
                        </div>
                        <div class="content">
                            <h6><a href="#" class="link"></a>John Smith</h6>
                            <p class="mt-4 text-variant-1">Property Manager</p>
                            <ul class="list-info">
                                <li><span class="icon icon-phone2"></span>1-333-345-6868</li>
                                <li><span class="icon icon-mail"></span>hi.avitex@gmail.com</li>
                                <li><span class="icon icon-mapPinLine"></span>101 E 129th St, East Chicago, IN 46312, US
                                </li>
                            </ul>
                            <a href="#" class="tf-btn size-1">Contact Agent</a>
                        </div>
                    </div>
                </div>
                <div class="box col-lg-4 col-sm-6">
                    <div class="box-agent style-1 style-3 hover-img">
                        <div class="box-img img-style">
                            <img src="{{ asset('assets/images/agents/agent-lg-2.jpg')}}" alt="image-agent">
                            <ul class="agent-social">
                                <li><a href="#" class="icon icon-facebook"></a></li>
                                <li><a href="#" class="icon icon-linkedin"></a></li>
                                <li><a href="#" class="icon icon-twitter"></a></li>
                                <li><a href="#" class="icon icon-instagram"></a></li>
                            </ul>
                        </div>
                        <div class="content">
                            <h6><a href="#" class="link"></a>Chris Patt</h6>
                            <p class="mt-4 text-variant-1">Administrative Staff</p>
                            <ul class="list-info">
                                <li><span class="icon icon-phone2"></span>1-333-345-6868</li>
                                <li><span class="icon icon-mail"></span>hi.avitex@gmail.com</li>
                                <li><span class="icon icon-mapPinLine"></span>101 E 129th St, East Chicago, IN 46312, US
                                </li>
                            </ul>
                            <a href="#" class="tf-btn size-1">Contact Agent</a>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>
    <!-- End Agents -->
    <!-- Property  -->
    <section class="flat-property-v3">
        <div class="container-full">
            <div class="wrap-property-v2">
                <div class="box-inner-left img-animation wow">
                    <img src="images/banner/properties.jpg" alt="img-property">
                </div>
                <div class="box-inner-right">
                    <div class="swiper tf-sw-property">
                        <div class="swiper-wrapper">
                            <div class="swiper-slide">
                                <div class="content-property">
                                    <div class="box-title">
                                        <div class="text-subtitle text-primary">Top Properties</div>
                                        <h4 class="mt-4">Recommended for you</h4>
                                    </div>
                                    <ul class="box-tag">
                                        <li class="flag-tag success">Featured</li>
                                        <li class="flag-tag style-1">For Sale</li>
                                    </ul>
                                    <div class="box-name">
                                        <h5 class="title"><a href="#" class="link">Rancho Vista Verde, Santa
                                                Barbara</a></h5>
                                        <p class="location"><span class="icon icon-mapPin"></span>145 Brooklyn Ave,
                                            Califonia, New York</p>
                                    </div>
                                    <ul class="list-info">
                                        <li class="item">
                                            <span class="icon icon-bed"></span>
                                            4 Bed
                                        </li>
                                        <li class="item">
                                            <span class="icon icon-bathtub"></span>
                                            2 bath
                                        </li>
                                        <li class="item">
                                            <span class="icon icon-ruler"></span>
                                            6000 SqFT
                                        </li>
                                    </ul>
                                    <div class="box-avatar d-flex gap-12 align-items-center">
                                        <div class="avatar avt-60 round">
                                            <img src="images/avatar/avt-12.jpg" alt="avatar">
                                        </div>
                                        <div class="info">
                                            <p class="body-2 text-variant-1">Agent</p>
                                            <div class="mt-4 h7 fw-7">John Smith</div>
                                        </div>
                                    </div>
                                    <div class="pricing-property">
                                        <div class="d-flex align-items-center">
                                            <h5>$250,00</h5>
                                            <span class="body-2 text-variant-1">/month</span>
                                        </div>
                                        <ul class="d-flex gap-12">
                                            <li class="box-icon w-52"><span class="icon icon-heart"></span></li>
                                            <li class="box-icon w-52"><span class="icon icon-arrLeftRight"></span></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="swiper-slide">
                                <div class="content-property">
                                    <div class="box-title">
                                        <div class="text-subtitle text-primary">Top Properties</div>
                                        <h4 class="mt-4">Recommended for you</h4>
                                    </div>
                                    <ul class="box-tag">
                                        <li class="flag-tag success">Featured</li>
                                        <li class="flag-tag style-1">For Sale</li>
                                    </ul>
                                    <div class="box-name">
                                        <h5 class="title"><a href="#" class="link">Rancho Vista Verde, Santa
                                                Barbara</a></h5>
                                        <p class="location"><span class="icon icon-mapPin"></span>145 Brooklyn Ave,
                                            Califonia, New York</p>
                                    </div>
                                    <ul class="list-info">
                                        <li class="item">
                                            <span class="icon icon-bed"></span>
                                            4 Bed
                                        </li>
                                        <li class="item">
                                            <span class="icon icon-bathtub"></span>
                                            2 bath
                                        </li>
                                        <li class="item">
                                            <span class="icon icon-ruler"></span>
                                            6000 SqFT
                                        </li>
                                    </ul>
                                    <div class="box-avatar d-flex gap-12 align-items-center">
                                        <div class="avatar avt-60 round">
                                            <img src="images/avatar/avt-12.jpg" alt="avatar">
                                        </div>
                                        <div class="info">
                                            <p class="body-2 text-variant-1">Agent</p>
                                            <div class="mt-4 h7 fw-7">John Smith</div>
                                        </div>
                                    </div>
                                    <div class="pricing-property">
                                        <div class="d-flex align-items-center">
                                            <h5>$250,00</h5>
                                            <span class="body-2 text-variant-1">/month</span>
                                        </div>
                                        <ul class="d-flex gap-12">
                                            <li class="box-icon w-52"><span class="icon icon-heart"></span></li>
                                            <li class="box-icon w-52"><span class="icon icon-arrLeftRight"></span></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="sw-pagination sw-pagination-property"></div>
                </div>
            </div>
        </div>


    </section>
    <!-- End Property  -->
    <!-- Testimonial -->
    <section class="flat-section flat-testimonial-v4 wow fadeInUpSmall" data-wow-delay=".4s" data-wow-duration="2000ms">
        <div class="container">
            <div class="box-title text-center">
                <div class="text-subtitle text-primary">Our Testimonials</div>
                <h4 class="mt-4">What’s people say’s</h4>
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
                                "I truly appreciate the professionalism and in-depth knowledge of the brokerage team. They
                                not only helped me find the perfect home but also assisted with legal and financial aspects,
                                making me feel confident and secure in my decision."
                            </p>
                            <div class="box-avt d-flex align-items-center gap-12">
                                <div class="avatar avt-60 round">
                                    <img src="images/avatar/avt-7.jpg" alt="avatar">
                                </div>
                                <div class="info">
                                    <div class="h7 fw-7">Liam Anderson</div>
                                    <p class="text-variant-1 mt-4">CEO Digital</p>
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
                                "My experience with property management services has exceeded expectations. They efficiently
                                manage properties with a professional and attentive approach in every situation. I feel
                                reassured that any issue will be resolved promptly and effectively."
                            </p>
                            <div class="box-avt d-flex align-items-center gap-12">
                                <div class="avatar avt-60 round">
                                    <img src="images/avatar/avt-5.jpg" alt="avatar">
                                </div>
                                <div class="info">
                                    <div class="h7 fw-7">Adam Will</div>
                                    <p class="text-variant-1 mt-4">CEO Agency</p>
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
                                "My experience with property management services has exceeded expectations. They efficiently
                                manage properties with a professional and attentive approach in every situation. I feel
                                reassured that any issue will be resolved promptly and effectively."
                            </p>
                            <div class="box-avt d-flex align-items-center gap-12">
                                <div class="avatar avt-60 round">
                                    <img src="images/avatar/avt-5.jpg" alt="avatar">
                                </div>
                                <div class="info">
                                    <div class="h7 fw-7">Adam Will</div>
                                    <p class="text-variant-1 mt-4">CEO Agency</p>
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
                                    <img src="images/avatar/avt-7.jpg" alt="avatar">
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
    <!-- Benefit -->
    <section class="flat-benefit-v2">
        <div class="container">
            <div class="row wrap-benefit-v2">
                <div class="col-lg-4 wow fadeIn" data-wow-delay=".2s" data-wow-duration="2000ms">
                    <div class="box-left">
                        <div class="box-title">
                            <div class="text-subtitle text-primary">Our Benifit</div>
                            <h4 class="mt-4 text-white">Why Choose Homeya</h4>
                        </div>
                        <p class="description text-white body-3">Our seasoned team excels in real estate with years of
                            successful market navigation, offering informed decisions and optimal results.</p>
                        <div class="box-navigation">
                            <div class="navigation swiper-nav-next nav-next-benefit"><span class="icon icon-arr-l"></span>
                            </div>
                            <div class="navigation swiper-nav-prev nav-prev-benefit"><span class="icon icon-arr-r"></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-8 wow fadeIn" data-wow-delay=".4s" data-wow-duration="2000ms">
                    <div class="swiper tf-sw-benefit">
                        <div class="swiper-wrapper">

                            <div class="swiper-slide">
                                <div class="box-right">
                                    <div class="box-benefit style-1">
                                        <div class="icon-box">
                                            <span class="icon icon-proven"></span>
                                        </div>
                                        <div class="content">
                                            <h6 class="title"><a href="#" class="link">Proven Expertise</a></h6>
                                            <p class="description">Our seasoned team excels in real estate with years of
                                                successful market navigation.</p>
                                        </div>
                                    </div>
                                    <div class="box-benefit style-1">
                                        <div class="icon-box">
                                            <span class="icon icon-double-ruler"></span>
                                        </div>
                                        <div class="content">
                                            <h6 class="title"><a href="#" class="link">Proven Expertise</a></h6>

                                            <p class="description">Our seasoned team excels in real estate with years of
                                                successful market navigation.</p>
                                        </div>
                                    </div>
                                    <div class="box-benefit style-1">
                                        <div class="icon-box">
                                            <span class="icon icon-hand"></span>
                                        </div>
                                        <div class="content">
                                            <h6 class="title"><a href="#" class="link">Proven Expertise</a></h6>

                                            <p class="description">Our seasoned team excels in real estate with years of
                                                successful market navigation.</p>
                                        </div>
                                    </div>
                                    <div class="box-benefit style-1">
                                        <div class="icon-box">
                                            <span class="icon icon-hand"></span>
                                        </div>
                                        <div class="content">
                                            <h6 class="title"><a href="#" class="link">Proven Expertise</a></h6>

                                            <p class="description">Our seasoned team excels in real estate with years of
                                                successful market navigation.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="swiper-slide">
                                <div class="box-right">
                                    <div class="box-benefit style-1">
                                        <div class="icon-box">
                                            <span class="icon icon-proven"></span>
                                        </div>
                                        <div class="content">
                                            <h6 class="title"><a href="#" class="link">Proven Expertise</a></h6>
                                            <p class="description">Our seasoned team excels in real estate with years of
                                                successful market navigation.</p>
                                        </div>
                                    </div>
                                    <div class="box-benefit style-1">
                                        <div class="icon-box">
                                            <span class="icon icon-double-ruler"></span>
                                        </div>
                                        <div class="content">
                                            <h6 class="title"><a href="#" class="link">Proven Expertise</a>
                                            </h6>

                                            <p class="description">Our seasoned team excels in real estate with years of
                                                successful market navigation.</p>
                                        </div>
                                    </div>
                                    <div class="box-benefit style-1">
                                        <div class="icon-box">
                                            <span class="icon icon-hand"></span>
                                        </div>
                                        <div class="content">
                                            <h6 class="title"><a href="#" class="link">Proven Expertise</a>
                                            </h6>

                                            <p class="description">Our seasoned team excels in real estate with years of
                                                successful market navigation.</p>
                                        </div>
                                    </div>
                                    <div class="box-benefit style-1">
                                        <div class="icon-box">
                                            <span class="icon icon-hand"></span>
                                        </div>
                                        <div class="content">
                                            <h6 class="title"><a href="#" class="link">Proven Expertise</a>
                                            </h6>

                                            <p class="description">Our seasoned team excels in real estate with years of
                                                successful market navigation.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- End Benefit -->
    <!-- Latest New -->
    <section class="flat-section flat-latest-new">
        <div class="container">
            <div class="box-title text-center wow fadeInUpSmall" data-wow-delay=".2s" data-wow-duration="2000ms">
                <div class="text-subtitle text-primary">Latest New</div>
                <h4 class="mt-4">Helpful Homeya Guides</h4>
            </div>
            <div class="row wow fadeInUpSmall" data-wow-delay=".4s" data-wow-duration="2000ms">
                <div class="box col-lg-4 col-md-6">
                    <a href="blog-detail.html" class="flat-blog-item hover-img">
                        <div class="img-style">
                            <img src="images/blog/blog-1.jpg" alt="img-blog">
                            <span class="date-post">January 28, 2024</span>
                        </div>
                        <div class="content-box">
                            <div class="post-author">
                                <span class="fw-7">Esther</span>
                                <span>Furniture</span>
                            </div>
                            <h6 class="title">Building gains into housing stocks and how to trade the sector</h6>
                            <p class="description">The average contract interest rate for 30-year fixed-rate mortgages
                                with conforming loan balances...</p>
                        </div>

                    </a>
                </div>
                <div class="box col-lg-4 col-md-6">
                    <a href="blog-detail.html" class="flat-blog-item hover-img">
                        <div class="img-style">
                            <img src="images/blog/blog-2.jpg" alt="img-blog">
                            <span class="date-post">January 31, 2024</span>
                        </div>
                        <div class="content-box">
                            <div class="post-author">
                                <span class="fw-7">Angel</span>
                                <span>Interior</span>
                            </div>
                            <h6 class="title">92% of millennial homebuyers say inflation has impacted their plans</h6>
                            <p class="description">Mortgage applications to purchase a home, however, dropped 4% last week
                                compared...</p>
                        </div>

                    </a>
                </div>
                <div class="box col-lg-4 col-md-6">
                    <a href="blog-detail.html" class="flat-blog-item hover-img">
                        <div class="img-style">
                            <img src="images/blog/blog-3.jpg" alt="img-blog">
                            <span class="date-post">January 28, 2024</span>
                        </div>
                        <div class="content-box">
                            <div class="post-author">
                                <span class="fw-7">Colleen</span>
                                <span>Architecture</span>
                            </div>
                            <h6 class="title">We are hiring ‘moderately,’ says Compass CEO</h6>
                            <p class="description">New listings were down 20% year over year in March, according to
                                Realtor.com, and total inventory...</p>
                        </div>

                    </a>
                </div>
            </div>
        </div>
    </section>
    <!-- End Latest New -->
    <!-- banner -->
    <section class="flat-section pt-0 flat-banner wow fadeInUpSmall" data-wow-delay=".2s" data-wow-duration="2000ms">
        <div class="container">
            <div class="wrap-banner bg-surface">
                <div class="box-left">
                    <div class="box-title">
                        <div class="text-subtitle text-primary">Become Partners</div>
                        <h4 class="mt-4">List your Properties on Homeya, join Us Now!</h4>
                    </div>
                    <a href="#" class="tf-btn primary size-1">Become A Hosting</a>
                </div>
                <div class="box-right">
                    <img src="images/banner/banner.png" alt="image">
                </div>
            </div>
        </div>
    </section>
    <!-- end banner -->
@endsection
