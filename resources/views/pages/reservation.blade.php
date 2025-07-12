@extends('layouts.main')
@section('content')
    <div class="">


        <section class="flat-filter-search-v2">
            <div class="flat-tab flat-tab-form">

                <div class="tab-content">
                    <div class="tab-pane fade active show" role="tabpanel">
                        <div class="form-sl">
                            <form method="post">
                                <div class="wd-find-select">
                                    <div class="inner-group">
                                        <div class="form-group-1 search-form form-style">
                                            <label>Mot clé</label>
                                            <input type="text" class="form-control" placeholder="Mot clé."
                                                value="" name="s" title="Rechercher par .." required="">
                                        </div>
                                        <div class="form-group-2 form-style">
                                            <label>Localisation</label>
                                            <div class="group-ip">
                                                <input type="text" class="form-control" placeholder="Localisation"
                                                    value="" name="s" title="Rechercher par ." required="">
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
                                    <button type="submit" class="tf-btn primary">Trouver des propriétés</button>
                                </div>
                                <div class="wd-search-form">
                                    <div class="grid-2 group-box group-price">
                                        <div class="widget-price">
                                            <div class="box-title-price">
                                                <span class="title-price">Fourchette de prix</span>
                                                <div class="caption-price">
                                                    <span>de</span>
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
                                                    <span>from</span>
                                                    <span id="slider-range-value01" class="fw-7"></span>
                                                    <span>to</span>
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
                                                <div class="nice-select" tabindex="0"><span class="current">2</span>
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
                                                <div class="nice-select" tabindex="0"><span class="current">2</span>
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
                                                <div class="nice-select" tabindex="0"><span class="current">2</span>
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
                                                <div class="nice-select" tabindex="0"><span class="current">2</span>
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
                                </div>
                            </form>
                            <!-- End Job  Search Form-->
                        </div>
                    </div>

                </div>
            </div>
        </section>



        <section class="wrapper-layout layout-2">
            <div class="wrap-left">
                <div class="box-title-listing style-1">
                    <h5>Liste des biens</h5>
                    <div class="box-filter-tab">
                        <ul class="nav-tab-filter" role="tablist">
                            <li class="nav-tab-item" role="presentation">
                                <a href="#gridLayout" class="nav-link-item active" data-bs-toggle="tab"><i
                                        class="icon icon-grid"></i></a>
                            </li>
                            <li class="nav-tab-item" role="presentation">
                                <a href="#listLayout" class="nav-link-item" data-bs-toggle="tab"><i
                                        class="icon icon-list"></i></a>
                            </li>
                        </ul>
                        <div class="nice-select list-sort" tabindex="0"><span class="current">Trier par (par défaut)</span>
                            <ul class="list">
                                <li data-value="default" class="option selected">Trier par (par défaut)</li>
                                <li data-value="new" class="option">Le plus récent</li>
                                <li data-value="old" class="option">Le plus ancien</li>
                            </ul>
                        </div>
                    </div>
                    
                </div>
                <div class="tab-content">
                    <div class="tab-pane fade active show" id="gridLayout" role="tabpanel">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="homeya-box">
                                    <div class="archive-top">
                                        <a href="{{ route('property.show') }}" class="images-group">
                                            <div class="images-style">
                                                <img src="https://i.pinimg.com/736x/99/0f/c7/990fc7a568ad1fde0dcd8ea5a087eac8.jpg" alt="img">
                                            </div>
                                            <div class="top">
                                                <ul class="d-flex gap-8">
                                                    <li class="flag-tag success">en vedette</li>
                                                    <li class="flag-tag style-1">à vendre</li>
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
                                                <span class="flag-tag style-2">Studio</span>
                                            </div>
                                        </a>
                                        <div class="content">
                                            <div class="h7 text-capitalize fw-7"><a href="{{ route('property.show') }}"
                                                    class="link"> Villa moderne avec piscine</a></div>
                                            <div class="desc"><i class="fs-16 icon icon-mapPin"></i>
                                                <p>33 rue commerce, Abidjan, Cote d'ivoire</p>
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
                                                <img src="https://i.pinimg.com/736x/66/2b/be/662bbef42e07620cbea41e3ac63a74eb.jpg" alt="avt">
                                            </div>
                                            <span>Arlene McCoy</span>
                                        </div>
                                        <div class="d-flex align-items-center">
                                            <h6>7250,00 Fcfa</h6>
                                            <span class="text-variant-1">/SqFT</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="homeya-box">
                                    <div class="archive-top">
                                        <a href="{{ route('property.show') }}" class="images-group">
                                            <div class="images-style">
                                                <img src="https://i.pinimg.com/736x/9d/26/96/9d26968c849f6d53a7a4605791bef6ed.jpg" alt="img">
                                            </div>
                                            <div class="top">
                                                <ul class="d-flex gap-8">
                                                    <li class="flag-tag success">En vedette</li>
                                                    <li class="flag-tag style-1">En Vente</li>
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
                                                <span class="flag-tag style-2">Apartment</span>
                                            </div>
                                        </a>
                                        <div class="content">
                                            <div class="h7 text-capitalize fw-7"><a href="{{ route('property.show') }}"
                                                    class="link">Villa del Mar Retreat, Malibu</a></div>
                                            <div class="desc"><i class="fs-16 icon icon-mapPin"></i>
                                                <p>72 avenue Noguess, Abidjan, Plateau</p>
                                            </div>
                                            <ul class="meta-list">
                                                <li class="item">
                                                    <i class="icon icon-bed"></i>
                                                    <span>2</span>
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
                                                <img src="https://i.pinimg.com/736x/33/70/7c/33707cd80ed6702a5d86ab2d66413f36.jpg" alt="avt">
                                            </div>
                                            <span>Annette Black</span>
                                        </div>
                                        <div class="d-flex align-items-center">
                                            <h6>250,00 Fcfa</h6>
                                            <span class="text-variant-1">/month</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="homeya-box">
                                    <div class="archive-top">
                                        <a href="{{ route('property.show') }}" class="images-group">
                                            <div class="images-style">
                                                <img src="https://i.pinimg.com/736x/ba/6a/3a/ba6a3a8b779509bdd667f19adbb659e0.jpg" alt="img">
                                            </div>
                                            <div class="top">
                                                <ul class="d-flex gap-8">
                                                    <li class="flag-tag success">en vedette</li>
                                                    <li class="flag-tag style-1">en vente</li>
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
                                            <div class="h7 text-capitalize fw-7"><a href="{{ route('property.show') }}"
                                                    class="link">Rancho Villa Barbara, Santa Barbara</a></div>
                                            <div class="desc"><i class="fs-16 icon icon-mapPin"></i>
                                                <p>33 Maple Street, Rue du jardin ,Plateau</p>
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
                                                <img src="https://i.pinimg.com/736x/33/70/7c/33707cd80ed6702a5d86ab2d66413f36.jpg" alt="avt">
                                            </div>
                                            <span>Ralph Edwards</span>
                                        </div>
                                        <div class="d-flex align-items-center">
                                            <h6>5050,00 Fcfa</h6>
                                            <span class="text-variant-1">/Jour</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="listLayout" role="tabpanel">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="homeya-box list-style-1 list-style-2">
                                    <a href="{{ route('property.show') }}" class="images-group">
                                        <div class="images-style">
                                            <img src="images/home/house-9.jpg" alt="img">
                                        </div>
                                        <div class="top">
                                            <ul class="d-flex gap-4 flex-wrap">
                                                <li class="flag-tag style-1">For Sale</li>
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
                                        <div class="archive-top">
                                            <div class="h7 text-capitalize fw-7"><a href="{{ route('property.show') }}"
                                                    class="link">Casa Lomas de Machalí Machas</a></div>
                                            <div class="desc"><i class="icon icon-mapPin"></i>
                                                <p>145 Brooklyn Ave, Califonia, New York</p>
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
                                                    <img src="images/avatar/avt-8.jpg" alt="avt">
                                                </div>
                                                <span>Jacob Jones</span>
                                            </div>
                                            <div class="d-flex align-items-center">
                                                <div class="h7 fw-7">$5050,00</div>
                                                <span class="text-variant-1">/SqFT</span>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="homeya-box list-style-1 list-style-2">
                                    <a href="{{ route('property.show') }}" class="images-group">
                                        <div class="images-style">
                                            <img src="images/home/house-10.jpg" alt="img">
                                        </div>
                                        <div class="top">
                                            <ul class="d-flex">
                                                <li class="flag-tag style-1">For Rent</li>
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
                                            <span class="flag-tag style-2">House</span>
                                        </div>
                                    </a>
                                    <div class="content">
                                        <div class="archive-top">
                                            <div class="h7 text-capitalize fw-7"><a href="{{ route('property.show') }}"
                                                    class="link">Lakeview Haven, Lake Tahoe </a></div>
                                            <div class="desc"><i class="icon icon-mapPin"></i>
                                                <p>145 Brooklyn Ave, Califonia, New York</p>
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
                                                    <img src="images/avatar/avt-10.jpg" alt="avt">
                                                </div>
                                                <span>Floyd Miles</span>
                                            </div>
                                            <div class="d-flex align-items-center">
                                                <div class="h7 fw-7">$250,00</div>
                                                <span class="text-variant-1">/month</span>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="homeya-box list-style-1 list-style-2">
                                    <a href="{{ route('property.show') }}" class="images-group">
                                        <div class="images-style">
                                            <img src="images/home/house-6.jpg" alt="img">
                                        </div>
                                        <div class="top">
                                            <ul class="d-flex">

                                                <li class="flag-tag style-1">For Sale</li>
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
                                            <span class="flag-tag style-2">House</span>
                                        </div>
                                    </a>
                                    <div class="content">
                                        <div class="archive-top">
                                            <div class="h7 text-capitalize fw-7"><a href="{{ route('property.show') }}"
                                                    class="link">Sunset Heights Estate, Beverly Hills</a></div>
                                            <div class="desc"><i class="icon icon-mapPin"></i>
                                                <p>145 Brooklyn Ave, Califonia, New York</p>
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
                                                    <img src="images/avatar/avt-5.jpg" alt="avt">
                                                </div>
                                                <span>Ralph Edwards</span>
                                            </div>
                                            <div class="d-flex align-items-center">
                                                <div class="h7 fw-7">$5050,00</div>
                                                <span class="text-variant-1">/SqFT</span>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="homeya-box list-style-1 list-style-2">
                                    <a href="{{ route('property.show') }}" class="images-group">
                                        <div class="images-style">
                                            <img src="images/home/house-5.jpg" alt="img">
                                        </div>
                                        <div class="top">
                                            <ul class="d-flex">
                                                <li class="flag-tag style-1">For Rent</li>
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
                                            <span class="flag-tag style-2">apartment</span>
                                        </div>
                                    </a>
                                    <div class="content">
                                        <div class="archive-top">
                                            <div class="h7 text-capitalize fw-7"><a href="{{ route('property.show') }}"
                                                    class="link">Lakeview Haven, Lake Tahoe</a></div>
                                            <div class="desc"><i class="icon icon-mapPin"></i>
                                                <p>145 Brooklyn Ave, Califonia, New York</p>
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
                                                    <img src="images/avatar/avt-9.jpg" alt="avt">
                                                </div>
                                                <span>Annette Black</span>
                                            </div>
                                            <div class="d-flex align-items-center">
                                                <div class="h7 fw-7">$250,00</div>
                                                <span class="text-variant-1">/month</span>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>



            </div>
            <div class="wrap-right">
                <div id="map" class="top-map" data-map-zoom="16" data-map-scroll="true"></div>
            </div>
        </section>

    </div>
@endsection
