@extends('layouts.main')
@section('content')
    <section class="container-fluid position-relative p-0 m-0" style="background: url('https://i.pinimg.com/736x/99/0f/c7/990fc7a568ad1fde0dcd8ea5a087eac8.jpg') no-repeat center center / cover; height: 300px;">
    <!-- Overlay en dégradé -->
    <div class="position-absolute top-0 start-0 w-100 h-100" 
         style="background: linear-gradient(to bottom, rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.7)); z-index: 1;">
    </div>

    <!-- Contenu centré -->
    <div class="row h-100 align-items-center justify-content-center text-center position-relative" style="z-index: 2; animation: fadeIn 1.5s ease;">
        <div class="col-11 col-md-8">
            <h2 class="text-white display-4 fw-bold mb-3">Liste des appartements</h2>
            <p class="text-white lead mb-4">Trouvez l’appartement idéal selon vos préférences et votre budget.</p>
            <a href="#liste-appartements" class="btn btn-outline-light px-4 py-2 rounded-pill shadow-sm">Voir les offres</a>
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
        <div class="row" id="liste-appartements">
            {{-- @dd($apparts) --}}
            @foreach($apparts as $item)
                <div class="col-sm-12 col-xl-4 col-lg-4 col-md-6">
                    <div class="homeya-box">
                        <div class="archive-top">
                            <a href="{{ route('property.show') }}" class="images-group">
                                <div class="images-style">
                                    @if($item->images)  
                                        <img src="{{ asset($item->image) ?? '' }}"
                                            alt="img">
                                    @endif
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
                                    <span class="flag-tag style-2">{{ $item->type->libelle ?? '' }}</span>
                                </div>
                            </a>
                            <div class="content">
                                <div class="h7 text-capitalize fw-7"><a href="{{ route('property.show') }}"
                                        class="link"> {{ $item->title ?? '' }}</a></div>
                                <div class="desc">
                                    {{-- <i class="fs-16 icon icon-mapPin"></i> --}}
                                    <p>{{ Str::limit($item->description ?? '', 30) }}</p>
                                </div>
                                <ul class="meta-list">
                                    <li class="item">
                                        <i class="icon icon-bed"></i>
                                        <span> {{ $item->nbr_room ?? 0 }} </span>
                                    </li>
                                    <li class="item">
                                        <i class="icon icon-bathtub"></i>
                                        <span> {{ $item->nbr_bathroom ?? 0 }} </span>
                                    </li>
                                    <li class="item">
                                        <i class="icon icon-money"></i>
                                        <span>600 </span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="archive-bottom d-flex justify-content-between align-items-center">
                            <div class="d-flex gap-8 align-items-center">
                                <div class="avatar avt-40 round">
                                    <img src="https://i.pinimg.com/736x/66/2b/be/662bbef42e07620cbea41e3ac63a74eb.jpg"
                                        alt="avt">
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
            @endforeach
        </div>
        <div class="row pt-5" style="height: 560px">
            <div id="map" style="height: 100%" class="top-map col-12" data-map-zoom="16" data-map-scroll="true"></div>
        </div>
    </section>
    
@endsection
