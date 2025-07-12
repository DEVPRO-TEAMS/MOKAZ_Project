@extends('layouts.app')

@section('content')
<style>
    .btn-icon {
        width: 38px;
        height: 38px;
        display: inline-flex;
        justify-content: center;
        align-items: center;
        border-radius: 50%;
        padding: 0;
        transition: all 0.3s ease-in-out;
        font-size: 16px;
    }

    .btn-icon:hover {
        transform: scale(1.1);
        box-shadow: 0 0 6px rgba(0, 0, 0, 0.15);
    }

</style>
    <div class="main-content-inner">
        <div class="button-show-hide show-mb">
            <span class="body-1">Liste des Demande de partenariat</span>
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Fermer"></button>
            </div>
        @endif

        <div class="flat-counter-v2 tf-counter">
            
            <div class="counter-box">
                <div class="box-icon w-68 round">
                    <span class="icon icon-list-dashes"></span>
                </div>
                <div class="content-box">
                    <div class="title-coun">Total Demandes</div>
                    <div class="d-flex align-items-end">
                        <h6 class="numbe">{{ count($demandePartenariats) }}</h6>
                        <span class="fw-7 text-variant-2">/ Demandes</span>
                    </div>

                </div>
            </div>
            <div class="counter-box">
                <div class="box-icon w-68 round">
                    <span class="icon icon-clock-countdown"></span>
                </div>
                <div class="content-box">
                    <div class="title-count">En Attentes</div>
                    <div class="d-flex align-items-end">
                        <h6 class="number" data-speed="2000" data-to="0" data-inviewport="yes">{{ count($demandePartenariats->where('etat', 'pending')) }}</h6>
                    </div>
                </div>
            </div>
            <div class="counter-box">
                <div class="box-icon w-68 round">
                    <span class="icon icon-bookmark"></span>
                </div>
                <div class="content-box">
                    <div class="title-count">Contractés</div>
                    <div class="d-flex align-items-end">
                        <h6 class="number" data-speed="2000" data-to="1" data-inviewport="yes">{{ count($demandePartenariats->where('etat', 'actif')) }}</h6>
                    </div>
                </div>
            </div>
            <div class="counter-box">
                <div class="box-icon w-68 round">
                    <span class="icon icon-bookmark"></span>
                </div>
                <div class="content-box">
                    <div class="title-count">Rejettés</div>
                    <div class="d-flex align-items-end">
                        <h6 class="number" data-speed="2000" data-to="1" data-inviewport="yes">{{ count($demandePartenariats->where('etat', 'inactif')) }}</h6>
                    </div>
                </div>
            </div>
        </div>
        <div class="wrapper-content row">
            <div class="col-xl-12">
                <div class="widget-box-2 wd-listing">
                    <h6 class="title">Recherche</h6>
                    <div class="wd-filter">
                        <div class="ip-group">
                            <input type="text" placeholder="Recherche">
                        </div>
                        <div class="ip-group icon">
                            <input type="text" id="datepicker1" class="ip-datepicker icon" placeholder="Date de debut">
                        </div>
                        <div class="ip-group icon">
                            <input type="text" id="datepicker2" class="ip-datepicker icon" placeholder="Date de fin">
                        </div>
                        <div class="ip-group">
                            <div class="nice-select" tabindex="0"><span class="current">Satatus</span>
                                <ul class="list">
                                    <li data-value="1" class="option selected">En Attente</li>
                                    <li data-value="2" class="option">Accepté</li>
                                    <li data-value="3" class="option">Rejeté</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex gap-4"><span class="text-primary fw-7">17</span><span class="text-variant-1">Results
                            found</span></div>
                    <div class="wrap-table">
                        <div class="table-responsive">

                            <table>
                                <thead>
                                    <tr>
                                        <th>Compagny</th>
                                        <th>Télephone</th>
                                        <th>Email</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($demandePartenariats as $demandePartenariat)
                                    <tr class="file-delete">
                                        <td>
                                            <div class="listing-box">
                                                
                                                <div class="content">
                                                    <div class="title"><a href="property-details-v1.html"
                                                            class="link">{{$demandePartenariat->company ?? 'Non Défini'}}</a> </div>
                                                    <div class="text-date">
                                                        <p class="fw-5"><span class="fw-4 text-variant-1">Publié le 
                                                                :</span> {{ $demandePartenariat->created_at->format('d-M-Y') ?? 'Non Défini'}}</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="status-wrap">
                                                <span class="status">{{$demandePartenariat->phone ?? 'Non Défini'}}</span>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="status-wrap">
                                                <span class="status">{{$demandePartenariat->email ?? 'Non Défini'}}</span>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="status-wrap">
                                                <span class="status">{{$demandePartenariat->etat ?? 'Non Défini'}}</span>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="d-flex justify-content-center align-items-center gap-2">
                                                <!-- Bouton Voir -->
                                                <button type="button" class="btn btn-icon btn-outline-primary" data-bs-toggle="modal" data-bs-target="#showDemandeModal" title="Voir les détails">
                                                    <i class="fas fa-eye"></i>
                                                </button>

                                                <!-- Bouton Supprimer -->
                                                <button type="button" class="btn btn-icon btn-outline-danger" data-bs-toggle="modal" data-bs-target="#deleteModal"
                                                    data-id="{{ $demandePartenariat->id }}" title="Supprimer la demande">
                                                    <i class="fas fa-trash-alt"></i>
                                                </button>
                                            </div>
                                        </td>


                                    </tr> 
                                        @include('admins.pages.demandesPartenariat.showDemande', ['demandePartenariat' => $demandePartenariat])
                                    @endforeach
                                    
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('admins.pages.demandesPartenariat.approveDemandModal')

@endsection
