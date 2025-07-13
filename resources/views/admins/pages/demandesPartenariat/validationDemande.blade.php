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
<style>
    .card-counter {
        box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        transition: all 0.3s ease;
    }
    .card-counter:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 16px rgba(0,0,0,0.15);
    }
    .counter-icon {
        font-size: 2rem;
        opacity: 0.8;
    }
    .status-badge {
        font-size: 0.75rem;
        padding: 0.35em 0.65em;
    }
    .demande-card {
        transition: all 0.3s ease;
        border-left: 4px solid transparent;
    }
    .demande-card:hover {
        transform: translateX(5px);
        box-shadow: 0 4px 12px rgba(0,0,0,0.08);
    }
    .pending {
        border-left-color: #ffc107;
    }
    .actif {
        border-left-color: #28a745;
    }
    .inactif {
        border-left-color: #dc3545;
    }
    .search-box {
        background: #f8f9fa;
        border-radius: 10px;
        padding: 20px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.05);
    }
    .avatar-initials {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: bold;
        color: white;
    }
    .action-btn {
        width: 32px;
        height: 32px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
    }
</style>

    <div class="main-content-inner">
        <div class="row mb-4">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center">
                    <h3 class="mb-0">
                        <i class="fas fa-handshake me-2 text-danger"></i> Demandes de Partenariat
                    </h3>
                    <div>
                        <span class="badge bg-light text-dark">
                            <i class="fas fa-filter me-1"></i> Filtres actifs: 
                            @if(request('search')) Recherche: "{{ request('search') }}" @endif
                            @if(request('date_debut')) Du {{ request('date_debut') }} @endif
                            @if(request('date_fin')) au {{ request('date_fin') }} @endif
                            @if(request('etat')) Statut: {{ ucfirst(request('etat')) }} @endif
                        </span>
                    </div>
                </div>
            </div>
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Fermer"></button>
            </div>
        @endif

           <!-- Cards Counters -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card card-counter bg-white rounded-3">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted mb-2">Total Demandes</h6>
                            <h3 class="mb-0">{{ count($demandePartenariats) }}</h3>
                        </div>
                        <div class="counter-icon text-primary">
                            <i class="fas fa-list"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-3">
            <div class="card card-counter bg-white rounded-3">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted mb-2">En Attente</h6>
                            <h3 class="mb-0">{{ count($demandePartenariats->where('etat', 'pending')) }}</h3>
                        </div>
                        <div class="counter-icon text-warning">
                            <i class="fas fa-clock"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-3">
            <div class="card card-counter bg-white rounded-3">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted mb-2">Acceptées</h6>
                            <h3 class="mb-0">{{ count($demandePartenariats->where('etat', 'actif')) }}</h3>
                        </div>
                        <div class="counter-icon text-success">
                            <i class="fas fa-check-circle"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-3">
            <div class="card card-counter bg-white rounded-3">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted mb-2">Rejetées</h6>
                            <h3 class="mb-0">{{ count($demandePartenariats->where('etat', 'inactif')) }}</h3>
                        </div>
                        <div class="counter-icon text-danger">
                            <i class="fas fa-times-circle"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Search and Filter Section -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="search-box">
                <form action="{{ route('admin.demande.view') }}" method="get">
                    <div class="row g-3">
                        <div class="col-md-3">
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-search"></i></span>
                                <input type="text" class="form-control" placeholder="Recherche..." name="search" value="{{ request('search') }}">
                            </div>
                        </div>
                        
                        <div class="col-md-2">
                            <input type="date" class="form-control" name="date_debut" value="{{ request('date_debut') }}" placeholder="Date début">
                        </div>
                        
                        <div class="col-md-2">
                            <input type="date" class="form-control" name="date_fin" value="{{ request('date_fin') }}" placeholder="Date fin">
                        </div>
                        
                        <div class="col-md-3">
                            <select name="etat" class="form-select">
                                <option value="">Tous les statuts</option>
                                <option value="pending" {{ request('etat') == 'pending' ? 'selected' : '' }}>En Attente</option>
                                <option value="actif" {{ request('etat') == 'actif' ? 'selected' : '' }}>Accepté</option>
                                <option value="inactif" {{ request('etat') == 'inactif' ? 'selected' : '' }}>Rejeté</option>
                            </select>
                        </div>
                        
                        <div class="col-md-2">
                            <button type="submit" class="btn btn-primary w-100">
                                <i class="fas fa-filter me-1"></i> Filtrer
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
        <div class="wrapper-content row">
            <div class="col-xl-12">
                <div class="card">
                    <div class="wrap-table">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th>ID</th>
                                        <th>Entreprise</th>
                                        <th>Contact</th>
                                        <th>Date</th>
                                        <th>Statut</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($demandePartenariats as $demande)
                                    <tr class="demande-card {{ $demande->etat }}">
                                        <td>#{{ $demande->id }}</td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="avatar-initials bg-primary me-3">
                                                    {{ substr($demande->company, 0, 2) }}
                                                </div>
                                                <div>
                                                    <h6 class="mb-0">{{ $demande->company }}</h6>
                                                    <small class="text-muted">{{ $demande->email }}</small>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div>
                                                <i class="fas fa-phone me-2 text-muted"></i> {{ $demande->phone }}
                                            </div>
                                        </td>
                                        <td>
                                            {{ $demande->created_at->format('d/m/Y') }}
                                            <br>
                                            <small class="text-muted">{{ $demande->created_at->diffForHumans() }}</small>
                                        </td>
                                        <td>
                                            @if ($demande->etat == 'actif')
                                                <span class="badge status-badge bg-success">
                                                    <i class="fas fa-check-circle me-1"></i> Accepté
                                                </span>
                                            @elseif ($demande->etat == 'inactif')
                                                <span class="badge status-badge bg-danger">
                                                    <i class="fas fa-times-circle me-1"></i> Rejeté
                                                </span>
                                            @else
                                                <span class="badge status-badge bg-warning text-dark">
                                                    <i class="fas fa-clock me-1"></i> En attente
                                                </span>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="d-flex gap-2">
                                                <button class="action-btn btn btn-outline-primary" 
                                                        data-bs-toggle="modal" 
                                                        data-bs-target="#showDemandeModal{{ $demande->id }}"
                                                        title="Voir détails">
                                                    <i class="fas fa-eye"></i>
                                                </button>
                                                
                                                @if($demande->etat == 'pending')
                                                    <button class="action-btn btn btn-outline-success"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#approveDemandModal{{ $demande->id }}"
                                                            title="Approuver">
                                                        <i class="fas fa-check"></i>
                                                    </button>
                                                    
                                                    <button class="action-btn btn btn-outline-danger"
                                                            onclick="rejectDemande({{ $demande->id }})"
                                                            title="Rejeter">
                                                        <i class="fas fa-times"></i>
                                                    </button>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                    
                                    @include('admins.pages.demandesPartenariat.showDemande', ['demandePartenariat' => $demande])
                                    
                                    @empty
                                    <tr>
                                        <td colspan="6" class="text-center py-4">
                                            <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                                            <h5>Aucune demande trouvée</h5>
                                            <p class="text-muted">Aucune demande ne correspond à vos critères de recherche</p>
                                        </td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
