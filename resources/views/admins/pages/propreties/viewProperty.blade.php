@extends('layouts.app')

@section('content')
    <div class="main-content-inn">
        <div class="row mb-4">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center">
                    <h3 class="mb-0">
                        <i class="fas fa-home me-2 text-danger"></i> Gestion des Propriétés
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
                                <h6 class="text-muted mb-2">Total Propriétés</h6>
                                <h3 class="mb-0">{{ count($properties) }}</h3>
                            </div>
                            <div class="counter-icon text-primary">
                                <i class="fas fa-home"></i>
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
                                <h3 class="mb-0">{{ count($properties->where('etat', 'pending')) }}</h3>
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
                                <h6 class="text-muted mb-2">Actives</h6>
                                <h3 class="mb-0">{{ count($properties->where('etat', 'actif')) }}</h3>
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
                                <h6 class="text-muted mb-2">Inactives</h6>
                                <h3 class="mb-0">{{ count($properties->where('etat', 'inactif')) }}</h3>
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
                    <form action="{{ route('admin.proprety.view') }}" method="get">
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
                                    <option value="actif" {{ request('etat') == 'actif' ? 'selected' : '' }}>Active</option>
                                    <option value="inactif" {{ request('etat') == 'inactif' ? 'selected' : '' }}>Inactive</option>
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
                <div class="card border-0 shadow-sm rounded-3 overflow-hidden">
                    <div class="card-body p-0">
                        <div class="table-responsive p-3">
                            <table class="table table-hover align-middle mb-0" id="example2">
                                <thead class="table-light">
                                    <tr>
                                        <th width="80">Code</th>
                                        <th>Propriété</th>
                                        <th>Localisation</th>
                                        <th>Partenaire</th>
                                        <th width="140">Date</th>
                                        <th width="120">Statut</th>
                                        <th width="140">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($properties as $property)
                                    <tr class="position-relative">
                                        <td class="fw-semibold">#{{ $property->code ?? '' }}</td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="property-image me-3">
                                                    @if ($property->image)
                                                        <img src="{{ asset($property->image) }}"
                                                            alt="image" class="rounded-2"
                                                            style="width: 50px; height: 50px; object-fit: cover;">
                                                    @else
                                                        <div class="avatar-initials bg-primary bg-opacity-10 text-primary d-flex align-items-center justify-content-center rounded-2"
                                                            style="width: 50px; height: 50px;">
                                                            <i class="fas fa-home"></i>
                                                        </div>
                                                    @endif
                                                </div>
                                                <div>
                                                    <h6 class="mb-0 fw-semibold">{!! Str::words($property->title ?? '', 3, '...') ?? '' !!}</h6>
                                                    <small class="text-muted d-block">{!! Str::limit($property->description ?? '', 50) !!}</small>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="d-flex flex-column">
                                                <span class="fw-semibold">{{ $property->ville->label ?? '' }}, {{ $property->pays->label ?? '' }}</span>
                                                <small class="text-muted">{{ $property->address ?? '' }}</small>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="badge bg-info bg-opacity-10 text-info">
                                                <i class="fas fa-handshake me-1"></i>
                                                {{ $property->partner->raison_social ?? 'Non assigné' }}
                                            </span>
                                        </td>
                                        <td>
                                            <div class="d-flex flex-column">
                                                <span>{{ $property->created_at->format('d/m/Y') ?? '' }}</span>
                                                <small class="text-muted">{{ $property->created_at->diffForHumans() ?? '' }}</small>
                                            </div>
                                        </td>
                                        <td>
                                            @if ($property->etat == 'actif')
                                                <span class="badge rounded-pill bg-success bg-opacity-10 text-success">
                                                    <i class="fas fa-check-circle me-1"></i> Active
                                                </span>
                                            @elseif ($property->etat == 'inactif')
                                                <span class="badge rounded-pill bg-danger bg-opacity-10 text-danger">
                                                    <i class="fas fa-times-circle me-1"></i> Inactive
                                                </span>
                                            @else
                                                <span class="badge rounded-pill bg-warning bg-opacity-10 text-warning">
                                                    <i class="fas fa-clock me-1"></i> En attente
                                                </span>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="d-flex gap-2">
                                                {{-- <button class="btn btn-sm btn-icon btn-outline-primary rounded-circle" 
                                                        data-bs-toggle="modal" 
                                                        data-bs-target="#showPropertyModal{{ $property->id }}"
                                                        title="Voir détails">
                                                    <i class="fas fa-eye"></i>
                                                </button> --}}
                                                <a title="Voir détails"
                                                    class="btn btn-sm btn-icon btn-outline-primary rounded-circle"
                                                    href="{{ route('admin.properties.show', $property->uuid) }}">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                
                                                {{-- <button class="btn btn-sm btn-icon btn-outline-secondary rounded-circle"
                                                        onclick="editProperty({{ $property->id }})"
                                                        title="Modifier">
                                                    <i class="fas fa-edit"></i>
                                                </button> --}}
                                                
                                                {{-- @if($property->etat == 'pending')
                                                    <button class="btn btn-sm btn-icon btn-outline-success rounded-circle">
                                                        <a class="deleteConfirmation" data-uuid="{{$property->uuid}}"
                                                        data-type="confirmation_redirect" data-placement="top"
                                                        data-token="{{ csrf_token() }}"
                                                        data-url="{{route('admin.approveProperty',$property->uuid)}}"
                                                        data-title="Vous êtes sur le point d'approuver la propriété {{$property->code}} "
                                                        data-id="{{$property->uuid}}" data-param="0"
                                                        data-route="{{route('admin.approveProperty',$property->uuid)}}" title="Approuver">
                                                        <i class="fas fa-check" style="cursor: pointer"></i></a>
                                                    </button>
                                                    
                                                    <button class="btn btn-sm btn-icon btn-outline-success rounded-circle">
                                                        <a class="deleteConfirmation" data-uuid="{{$property->uuid}}"
                                                        data-type="confirmation_redirect" data-placement="top"
                                                        data-token="{{ csrf_token() }}"
                                                        data-url="{{route('admin.rejectProperty',$property->uuid)}}"
                                                        data-title="Vous êtes sur le point de rejeter la propriété {{$property->code}} "
                                                        data-id="{{$property->uuid}}" data-param="0"
                                                        data-route="{{route('admin.rejectProperty',$property->uuid)}}" title="Rejeter">
                                                        <i class="fas fa-times" style="cursor: pointer"></i></a>
                                                    </button>
                                                @endif --}}
                                            </div>
                                        </td>
                                    </tr>
                                    
                                    @include('admins.pages.propreties.showPropretyModal')
                                    @empty
                                    <tr>
                                        <td colspan="7" class="text-center py-5">
                                            <div class="d-flex flex-column align-items-center">
                                                <i class="fas fa-home fa-3x text-muted mb-3 opacity-50"></i>
                                                <h5 class="fw-semibold">Aucune propriété trouvée</h5>
                                                <p class="text-muted">Aucune propriété ne correspond à vos critères de recherche</p>
                                                <a href="{{ route('admin.proprety.view') }}" class="btn btn-sm btn-outline-primary mt-2">
                                                    <i class="fas fa-sync-alt me-1"></i> Réinitialiser les filtres
                                                </a>
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
        </div>
    </div>

    <script>
        function editProperty(propertyId) {
            // Logique pour éditer une propriété
            console.log('Edit property:', propertyId);
        }

        function approveProperty(propertyId) {
            if (confirm('Êtes-vous sûr de vouloir approuver cette propriété ?')) {
                // Logique pour approuver
                console.log('Approve property:', propertyId);
            }
        }

        function rejectProperty(propertyId) {
            if (confirm('Êtes-vous sûr de vouloir rejeter cette propriété ?')) {
                // Logique pour rejeter
                console.log('Reject property:', propertyId);
            }
        }
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Récupération des coordonnées depuis les variables Blade (Laravel)
            const latitude = @json($property->latitude ?? 0);
            const longitude = @json($property->longitude ?? 0);
            

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

@endsection