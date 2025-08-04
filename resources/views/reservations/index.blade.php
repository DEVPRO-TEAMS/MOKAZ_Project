@extends('layouts.app')

@section('content')
    {{-- <div class="main-content-inner wrap-dashboard-content">
        <div class="button-show-hid show-m">
            <span class="body-1">Affichage des réservations</span>
        </div>
        <div class="row">
            
        </div>
        <div class="widget-box-2 wd-listing">
            <div class="row align-items-start justify-content-start">
                <div class="flat-bt-top col-md-12">
                    <h6 class="title">{{ count($reservations) }} Reservations</h6>
                </div>
            </div>
             
            <div class="wrap-table">
                <div class="table-responsive">
                    <table>
                        <thead>
                            <tr>
                                <th>Client</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Bien reserve</th>
                                <th>Crée le</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($reservations as $reservation)
                                <tr class="file-delete">
                                    <td>
                                        <span>{{ $reservation->nom ?? '' }} {{ $reservation->prenoms ?? '' }}</span>
                                    </td>
                                    <td>
                                        <span>{{ $reservation->email ?? '' }}</span>
                                    </td>
                                    <td>
                                        <span>{{ $reservation->phone ?? '' }}</span>
                                    </td>
                                    <td>
                                        <span>{{ $reservation->room_id ?? '' }}</span>
                                    </td>
                                    <td>
                                        <span>{{ $reservation->created_at->format('d/M/Y') ?? '' }}</span>
                                    </td>
                                    <td>
                                        <ul class="list-action d-flex align-items-center justify-content-center">
                                            <li class="border rounded me-2" data-bs-target="#showReservationModal{{ $reservation->id }}" data-bs-toggle="modal">
                                                <a class="item p-2" href="javascript:void(0);"><i class="icon icon-eye"></i></a>
                                            </li>
                                            <li class="border rounded me-2"><a class="item p-2"><i class="icon icon-trash"></i></a></li>
                                        </ul>
                                    </td>
                                </tr>

                                @include('reservations.showModal' , ['reservation' => $reservation])

                            @endforeach
                        </tbody>
                    </table>
                </div>

                <ul class="wd-navigation">
                    <li><a href="#" class="nav-item active">1</a></li>
                    <li><a href="#" class="nav-item">2</a></li>
                    <li><a href="#" class="nav-item">3</a></li>
                    <li><a href="#" class="nav-item"><i class="icon icon-arr-r"></i></a></li>
                </ul>
            </div>
        </div>
    </div> --}}

    <div class="main-content-inner wrap-dashboard-content">
        <div class="button-show-hid show-m">
            <span class="body-1">Affichage des réservations</span>
        </div>
        
        <div class="row">
            <div class="col-md-12">
                <!-- Filtres et recherche -->
                <div class="widget-box-2 mb-4">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Rechercher</label>
                                <input type="text" class="form-control" placeholder="Nom, email, téléphone...">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Statut</label>
                                <select class="form-control">
                                    <option value="">Tous</option>
                                    <option value="confirmed">Confirmé</option>
                                    <option value="pending">En attente</option>
                                    <option value="cancelled">Annulé</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Type de séjour</label>
                                <select class="form-control">
                                    <option value="">Tous</option>
                                    <option value="Jour">Jour</option>
                                    <option value="Heure">Heure</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label>&nbsp;</label>
                                <button class="btn btn-primary w-100">Filtrer</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="widget-box-2 wd-listing">
            <div class="row align-items-start justify-content-between">
                <div class="flat-bt-top col-md-6">
                    <h6 class="title">{{ count($reservations) }} Réservations</h6>
                </div>
                <div class="col-md-6 text-end">
                    {{-- <a href="" class="btn btn-primary">
                        <i class="icon icon-plus"></i> Nouvelle réservation
                    </a> --}}
                </div>
            </div>
             
            <div class="wrap-table">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Code</th>
                                <th>Client</th>
                                <th>Contact</th>
                                <th>Bien réservé</th>
                                <th>Séjour</th>
                                <th>Dates</th>
                                <th>Montant</th>
                                <th>Statut</th>
                                <th>Créé le</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($reservations as $reservation)
                                <tr class="file-delete">
                                    <td>
                                        <span class="fw-bold text-primary">{{ $reservation->code }}</span>
                                    </td>
                                    <td>
                                        <div>
                                            <span class="fw-bold">{{ $reservation->nom }} {{ $reservation->prenoms }}</span>
                                        </div>
                                    </td>
                                    <td>
                                        <div>
                                            <small class="d-block">{{ $reservation->email }}</small>
                                            <small class="text-muted">{{ $reservation->phone }}</small>
                                        </div>
                                    </td>
                                    <td>
                                        <span>{{ $reservation->property->title ?? 'N/A' }}</span>
                                        <br>
                                        <small class="text-muted">{{ $reservation->appartement->title ?? 'N/A' }}</small>
                                    </td>
                                    <td>
                                        <span class="badge bg-info">{{ $reservation->sejour }}</span>
                                        <br>
                                        <small>{{ $reservation->nbr_of_sejour }} {{ $reservation->sejour == 'Heure' ? 'heure(s)' : 'jour(s)' }}</small>
                                    </td>
                                    <td>
                                        <div>
                                            @if($reservation->sejour == 'Heure')
                                            <small class="d-block">Du: {{ \Carbon\Carbon::parse($reservation->start_time)->format('d/m/Y à H:i') }}</small>
                                            <small class="text-muted">Au: {{ \Carbon\Carbon::parse($reservation->end_time)->format('d/m/Y à H:i') }}</small>
                                            @else
                                                <small class="d-block">Du: {{ $reservation->start_time->format('d/m/Y') }}</small>
                                                <small class="text-muted">Au: {{ $reservation->end_time->format('d/m/Y') }}</small>
                                            @endif
                                        </div>
                                    </td>
                                    <td>
                                        <div>
                                            <span class="fw-bold">{{ number_format($reservation->total_price, 0, ',', ' ') }} FCFA</span>
                                            @if($reservation->still_to_pay > 0)
                                                <br><small class="text-danger">Reste: {{ number_format($reservation->still_to_pay, 0, ',', ' ') }} FCFA</small>
                                            @endif
                                        </div>
                                    </td>
                                    <td>
                                        @switch($reservation->status)
                                            @case('confirmed')
                                                <span class="badge bg-success">Confirmé</span>
                                                @break
                                            @case('pending')
                                                <span class="badge bg-warning">En attente</span>
                                                @break
                                            @case('cancelled')
                                                <span class="badge bg-danger">Annulé</span>
                                                @break
                                            @default
                                                <span class="badge bg-secondary">{{ $reservation->status }}</span>
                                        @endswitch
                                        <br>
                                        @switch($reservation->statut_paiement)
                                            @case('paid')
                                                <small class="badge bg-success">Payé</small>
                                                @break
                                            @case('partial')
                                                <small class="badge bg-warning">Partiel</small>
                                                @break
                                            @case('unpaid')
                                                <small class="badge bg-danger">Non payé</small>
                                                @break
                                            @default
                                                <small class="badge bg-secondary">{{ $reservation->statut_paiement }}</small>
                                        @endswitch
                                    </td>
                                    <td>
                                        <span>{{ $reservation->created_at->format('d/m/Y') }}</span>
                                        <br>
                                        <small class="text-muted">{{ $reservation->created_at->format('H:i') }}</small>
                                    </td>
                                    <td>
                                        <ul class="list-action d-flex align-items-center justify-content-center">
                                            <li class="border rounded me-2" title="Voir détails">
                                                <a class="item p-2" href="{{ route('partner.reservation.show', $reservation->uuid) }}">
                                                    <i class="icon icon-eye"></i>
                                                </a>
                                            </li>
                                        </ul>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="10" class="text-center py-4">
                                        <div class="text-muted">
                                            <i class="icon icon-calendar mb-2" style="font-size: 48px;"></i>
                                            <p>Aucune réservation trouvée</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
