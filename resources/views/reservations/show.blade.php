@extends('layouts.app')

@section('content')
    <div class="main-content-inner wrap-dashboard-content">
        <!-- En-tête avec breadcrumb -->
        <div class="row mb-4">
            <div class="col-md-12">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
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
                        <li class="breadcrumb-item"><a href="{{ route('partner.reservation.index') }}">Réservations</a></li>
                        <li class="breadcrumb-item active">{{ $reservation->code }}</li>
                    </ol>
                </nav>
            </div>
        </div>

        <!-- Actions principales -->
        <div class="row mb-4">
            <div class="col-md-12">
                <div class="d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">Réservation {{ $reservation->code }}</h4>
                    <div>
                        
                        <button class="btn btn-success" onclick="sendConfirmation()">
                            <i class="icon icon-mail"></i> Envoyer confirmation
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <!-- Informations client -->
            <div class="col-md-6">
                <div class="widget-box-2 mb-4">
                    <div class="flat-bt-top">
                        <h6 class="title"><i class="icon icon-user me-2"></i>Informations Client</h6>
                    </div>
                    <div class="wrap-content">
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="fw-bold">Nom complet :</label>
                                    <p class="mb-2">{{ $reservation->nom }} {{ $reservation->prenoms }}</p>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="fw-bold">Email :</label>
                                    <p class="mb-2">
                                        <a href="mailto:{{ $reservation->email }}">{{ $reservation->email }}</a>
                                    </p>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="fw-bold">Téléphone :</label>
                                    <p class="mb-2">
                                        <a href="tel:{{ $reservation->phone }}">{{ $reservation->phone }}</a>
                                    </p>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="fw-bold">Date de création :</label>
                                    <p class="mb-2">{{ $reservation->created_at->format('d/m/Y à H:i') }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Informations réservation -->
            <div class="col-md-6">
                <div class="widget-box-2 mb-4">
                    <div class="flat-bt-top">
                        <h6 class="title"><i class="icon icon-calendar me-2"></i>Détails de la Réservation</h6>
                    </div>
                    <div class="wrap-content">
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="fw-bold">Code :</label>
                                    <p class="mb-2 text-primary fw-bold">{{ $reservation->code }}</p>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="fw-bold">Type de séjour :</label>
                                    <p class="mb-2">
                                        <span class="badge bg-info">{{ $reservation->sejour }}</span>
                                    </p>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="fw-bold">Durée :</label>
                                    <p class="mb-2">{{ $reservation->nbr_of_sejour }} {{ $reservation->sejour == 'Heure' ? 'heure(s)' : 'jour(s)' }}</p>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="fw-bold">Statut :</label>
                                    <p class="mb-2">
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
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <!-- Dates et horaires -->
            <div class="col-md-6">
                <div class="widget-box-2 mb-4">
                    <div class="flat-bt-top">
                        <h6 class="title"><i class="icon icon-clock me-2"></i>Dates et Horaires</h6>
                    </div>
                    <div class="wrap-content">
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <label class="fw-bold">Date et heure d'arrivée :</label>
                                    <p class="mb-3 text-success">
                                        <i class="icon icon-calendar me-1"></i>

                                        {{ $reservation->start_time->format('l d F Y à H:i') ??  'Non renseigné' }}
                                    </p>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label class="fw-bold">Date et heure de départ :</label>
                                    <p class="mb-3 text-danger">
                                        <i class="icon icon-calendar me-1"></i>

                                        {{ $reservation->end_time->format('l d F Y à H:i') ??  'Non renseigné' }}
                                    </p>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label class="fw-bold">Durée totale :</label>
                                    <p class="mb-2">
                                        {{-- @php
                                            $start_time = $reservation->start_time->format('Y-m-d H:i');
                                            $end_time = $reservation->end_time->format('Y-m-d H:i');
                                            $duration = $start_time->diff($end_time);
                                            if ($reservation->sejour === 'Heure') {
                                                echo $duration->h . 'h ' . $duration->i . 'min';
                                            } else {
                                                echo $duration->days . ' jour(s)';
                                            }
                                        @endphp --}}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Informations sur le bien -->
            <div class="col-md-6">
                <div class="widget-box-2 mb-4">
                    <div class="flat-bt-top">
                        <h6 class="title"><i class="icon icon-home me-2"></i>Bien Réservé</h6>
                    </div>
                    <div class="wrap-content">
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <label class="fw-bold">Propriété :</label>
                                    <p class="mb-2">{{ $reservation->property->title ?? 'N/A' }}</p>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label class="fw-bold">Appartement/Chambre :</label>
                                    <p class="mb-2">{{ $reservation->appartement->title ?? 'N/A' }}</p>
                                </div>
                            </div>
                            @if($reservation->partner_uuid)
                                <div class="col-12">
                                    <div class="form-group">
                                        <label class="fw-bold">Partenaire :</label>
                                        <p class="mb-2">{{ $reservation->partner->raison_sociale ?? 'N/A' }}</p>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <!-- Informations financières -->
            <div class="col-md-6">
                <div class="widget-box-2 mb-4">
                    <div class="flat-bt-top">
                        <h6 class="title"><i class="icon icon-credit-card me-2"></i>Informations Financières</h6>
                    </div>
                    <div class="wrap-content">
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="fw-bold">Prix unitaire :</label>
                                    <p class="mb-2">{{ number_format($reservation->unit_price, 0, ',', ' ') }} FCFA</p>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="fw-bold">Prix total :</label>
                                    <p class="mb-2 text-primary fw-bold">{{ number_format($reservation->total_price, 0, ',', ' ') }} FCFA</p>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="fw-bold">Montant payé :</label>
                                    <p class="mb-2 text-success">{{ number_format($reservation->payment_amount, 0, ',', ' ') }} FCFA</p>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="fw-bold">Reste à payer :</label>
                                    <p class="mb-2 {{ $reservation->still_to_pay > 0 ? 'text-danger' : 'text-success' }}">
                                        {{ number_format($reservation->still_to_pay, 0, ',', ' ') }} FCFA
                                    </p>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="fw-bold">Mode de paiement :</label>
                                    <p class="mb-2">{{ ucfirst($reservation->payment_method) }}</p>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="fw-bold">Statut paiement :</label>
                                    <p class="mb-2">
                                        @switch($reservation->statut_paiement)
                                            @case('paid')
                                                <span class="badge bg-success">Payé</span>
                                                @break
                                            @case('partial')
                                                <span class="badge bg-warning">Partiel</span>
                                                @break
                                            @case('unpaid')
                                                <span class="badge bg-danger">Non payé</span>
                                                @break
                                            @default
                                                <span class="badge bg-secondary">{{ $reservation->statut_paiement }}</span>
                                        @endswitch
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Notes et remarques -->
            <div class="col-md-6">
                <div class="widget-box-2 mb-4">
                    <div class="flat-bt-top">
                        <h6 class="title"><i class="icon icon-note me-2"></i>Notes et Remarques</h6>
                    </div>
                    <div class="wrap-content">
                        @if($reservation->notes)
                            <div class="form-group">
                                <label class="fw-bold">Notes client :</label>
                                <div class="p-3 bg-light rounded">
                                    {{ $reservation->notes }}
                                </div>
                            </div>
                        @else
                            <p class="text-muted">Aucune note particulière</p>
                        @endif

                        <div class="form-group mt-3">
                            <label class="fw-bold">Ajouter une note interne :</label>
                            <form action="" method="POST">
                                @csrf
                                <textarea name="internal_note" class="form-control mb-2" rows="3" placeholder="Note interne (visible uniquement par l'équipe)"></textarea>
                                <button type="submit" class="btn btn-sm btn-primary">Ajouter note</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Historique des actions -->
        <div class="row">
            <div class="col-md-12">
                <div class="widget-box-2">
                    <div class="flat-bt-top">
                        <h6 class="title"><i class="icon icon-history me-2"></i>Historique</h6>
                    </div>
                    <div class="wrap-content">
                        <div class="timeline">
                            <div class="timeline-item">
                                <div class="timeline-marker bg-success"></div>
                                <div class="timeline-content">
                                    <h6 class="timeline-title">Réservation créée</h6>
                                    <p class="timeline-text">{{ $reservation->created_at->format('d/m/Y à H:i') }}</p>
                                </div>
                            </div>
                            
                            @if($reservation->status === 'confirmed')
                                <div class="timeline-item">
                                    <div class="timeline-marker bg-info"></div>
                                    <div class="timeline-content">
                                        <h6 class="timeline-title">Réservation confirmée</h6>
                                        <p class="timeline-text">{{ $reservation->updated_at->format('d/m/Y à H:i') }}</p>
                                    </div>
                                </div>
                            @endif

                            @if($reservation->statut_paiement === 'paid')
                                <div class="timeline-item">
                                    <div class="timeline-marker bg-success"></div>
                                    <div class="timeline-content">
                                        <h6 class="timeline-title">Paiement effectué</h6>
                                        <p class="timeline-text">{{ number_format($reservation->payment_amount, 0, ',', ' ') }} FCFA via {{ ucfirst($reservation->payment_method) }}</p>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Actions en bas -->
        <div class="row mt-4">
            <div class="col-md-12">
                <div class="d-flex justify-content-between">
                    <a href="{{ route('partner.reservation.index') }}" class="btn btn-secondary">
                        <i class="icon icon-arrow-left"></i> Retour à la liste
                    </a>
                    {{-- <div>
                        @if($reservation->status !== 'cancelled')
                            <button class="btn btn-danger me-2" onclick="cancelReservation({{ $reservation->id }})">
                                <i class="icon icon-x"></i> Annuler réservation
                            </button>
                        @endif
                        @if($reservation->still_to_pay > 0)
                            <button class="btn btn-success" onclick="addPayment({{ $reservation->id }})">
                                <i class="icon icon-credit-card"></i> Ajouter paiement
                            </button>
                        @endif
                    </div> --}}
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
<style>
    .timeline {
        position: relative;
        padding-left: 30px;
    }

    .timeline::before {
        content: '';
        position: absolute;
        left: 15px;
        top: 0;
        bottom: 0;
        width: 2px;
        background: #e9ecef;
    }

    .timeline-item {
        position: relative;
        margin-bottom: 20px;
    }

    .timeline-marker {
        position: absolute;
        left: -22px;
        top: 5px;
        width: 14px;
        height: 14px;
        border-radius: 50%;
        border: 3px solid #fff;
        box-shadow: 0 0 0 2px #e9ecef;
    }

    .timeline-content {
        background: #f8f9fa;
        padding: 15px;
        border-radius: 5px;
        border-left: 3px solid #007bff;
    }

    .timeline-title {
        margin: 0 0 5px 0;
        font-size: 14px;
        font-weight: 600;
    }

    .timeline-text {
        margin: 0;
        font-size: 13px;
        color: #6c757d;
    }
</style>
@endpush

{{-- @push('scripts')
<script>
function sendConfirmation() {
    if (confirm('Envoyer un email de confirmation au client ?')) {
        // Logique pour envoyer l'email
        fetch(`/reservations/{{ $reservation->id }}/send-confirmation`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Email de confirmation envoyé avec succès !');
            } else {
                alert('Erreur lors de l\'envoi de l\'email');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Erreur lors de l\'envoi de l\'email');
        });
    }
}

function cancelReservation(id) {
    if (confirm('Êtes-vous sûr de vouloir annuler cette réservation ?')) {
        const reason = prompt('Raison de l\'annulation (optionnel):');
        
        fetch(`/reservations/${id}/cancel`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({
                reason: reason
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            } else {
                alert('Erreur lors de l\'annulation');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Erreur lors de l\'annulation');
        });
    }
}

function addPayment(id) {
    const amount = prompt('Montant du paiement (FCFA):');
    if (amount && !isNaN(amount) && amount > 0) {
        const method = prompt('Mode de paiement (cash, card, transfer, mobile):');
        if (method) {
            fetch(`/reservations/${id}/add-payment`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({
                    amount: parseFloat(amount),
                    method: method,
                    notes: prompt('Notes sur le paiement (optionnel):')
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    location.reload();
                } else {
                    alert('Erreur lors de l\'ajout du paiement');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Erreur lors de l\'ajout du paiement');
            });
        }
    }
}
</script>
@endpush --}}