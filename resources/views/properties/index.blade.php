@extends('layouts.app')

@section('content')
    <div class="main-content-inne pt-5 mt-5 wrap-dashboard-content">
        <div class="row mb-4">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center">
                    <h3 class="mb-0">
                        <i class="fas fa-home me-2 text-danger"></i> Gestion des Propriétés
                    </h3>
                </div>
                
            </div>
        </div>
        <div class="row mb-4">
            <div class="col-12">
                <div class="d-flex justify-content-end align-items-center">
                    <div>
                        <span class="badge bg-light text-dark">
                            <i class="fas fa-filter me-1"></i> Filtres actifs:
                            @if (request('search'))
                                Recherche: "{{ request('search') }}"
                            @endif
                            @if (request('date_debut'))
                                Du {{ request('date_debut') }}
                            @endif
                            @if (request('date_fin'))
                                au {{ request('date_fin') }}
                            @endif
                            @if (request('etat'))
                                Statut: {{ ucfirst(request('etat')) }}
                            @endif
                        </span>
                    </div>
                </div>
            </div>
        </div>
        @if (session('success'))
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

        <div class="row mb-4">
            <div class="col-12">
                <div class="search-box">
                    <form action="{{ route('partner.properties.index') }}" method="get">
                        <div class="row g-3">
                            <div class="col-md-3">
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-search"></i></span>
                                    <input type="text" class="form-control" placeholder="Recherche..." name="search"
                                        value="{{ request('search') }}">
                                </div>
                            </div>

                            <div class="col-md-2">
                                <input type="date" class="form-control" name="date_debut"
                                    value="{{ request('date_debut') }}" placeholder="Date début">
                            </div>

                            <div class="col-md-2">
                                <input type="date" class="form-control" name="date_fin"
                                    value="{{ request('date_fin') }}" placeholder="Date fin">
                            </div>

                            <div class="col-md-3">
                                <select name="etat" class="nice-select form-select list style-1">
                                    <option value="">Tous les statuts</option>
                                    <option value="pending" {{ request('etat') == 'pending' ? 'selected' : '' }}>En Attente
                                    </option>
                                    <option value="actif" {{ request('etat') == 'actif' ? 'selected' : '' }}>Active
                                    </option>
                                    <option value="inactif" {{ request('etat') == 'inactif' ? 'selected' : '' }}>Inactive
                                    </option>
                                </select>
                            </div>

                            <div class="col-md-2">
                                <button type="submit" class="btn btn-outline-secondary w-100">
                                    <i class="fas fa-filter me-1"></i> Filtrer
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="widget-box-2 wd-listing">
            <div class="row align-items-center justify-content-center">
                <div class="flat-bt-top col-md-9">
                    <h6 class="title">Mes Properties</h6>
                </div>
                <div class="flat-bt-top col-md-3 text-end">
                    <a class="tf-btn primary" href="{{ route('partner.properties.create') }}"><i
                            class="icon icon-plus"></i> Ajouter une propriété</a>
                </div>
            </div>

            <div class="wrapper-content row">
                <div class="col-xl-12">
                    <div class="card border-0 shadow-sm rounded-3 overflow-hidden">
                        <div class="card-body p-0">
                            <div class="table-responsive-lg p-3">
                                <table class="table table-hover table-striped table-bordered align-middle" id="example2">
                                    <thead class="table-light">
                                        <tr>
                                            <th width="80">Code</th>
                                            <th>Propriété</th>
                                            <th>Localisation</th>
                                            <th>Nombre d'appart</th>
                                            <th width="140">Date</th>
                                            <th width="120">Statut</th>
                                            <th width="140">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($properties as $property)
                                            <tr class="position-relative text-wrap">
                                                <td class="fw-semibold">#{{ $property->property_code ?? '' }}</td>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <div class="property-image me-3">

                                                            @if ($property->image)
                                                                <img src="{{ asset($property->image) }}"
                                                                    alt="{{ $property->title }}" class="rounded-2"
                                                                    style="width: 50px; height: 50px; object-fit: cover;">
                                                            @else
                                                                <div class="avatar-initials bg-primary bg-opacity-10 text-primary d-flex align-items-center justify-content-center rounded-2"
                                                                    style="width: 50px; height: 50px;">
                                                                    <i class="fas fa-home"></i>
                                                                </div>
                                                            @endif
                                                        </div>
                                                        <div>
                                                            <h6 class="mb-0 fw-semibold">{{ $property->title ?? '' }}</h6>
                                                            <small
                                                                class="text-muted d-block">{{ Str::limit($property->description ?? '', 50) }}</small>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="d-flex flex-column">
                                                        <span class="fw-semibold">{{ $property->ville->label ?? '' }},
                                                            {{ $property->pays->label ?? '' }}</span>
                                                        <small class="text-muted">{{ $property->address ?? '' }}</small>
                                                        {{-- @if ($property->zipCode)
                                                            <small class="text-muted">{{ $property->zipCode ?? '' }}</small>
                                                        @endif --}}
                                                    </div>
                                                </td>
                                                <td>
                                                    <span>{{ count($property->apartements) ?? '0' }}</span>
                                                </td>
                                                <td>
                                                    <div class="d-flex flex-column">
                                                        <span>{{ $property->created_at->format('d/m/Y') ?? '' }}</span>
                                                        <small
                                                            class="text-muted">{{ $property->created_at->diffForHumans() ?? '' }}</small>
                                                    </div>
                                                </td>
                                                <td>
                                                    @if ($property->etat == 'actif')
                                                        <span
                                                            class="badge rounded-pill bg-success bg-opacity-10 text-success">
                                                            <i class="fas fa-check-circle me-1"></i> Active
                                                        </span>
                                                    @elseif ($property->etat == 'inactif')
                                                        <span
                                                            class="badge rounded-pill bg-danger bg-opacity-10 text-danger">
                                                            <i class="fas fa-times-circle me-1"></i> Inactive
                                                        </span>
                                                    @else
                                                        <span
                                                            class="badge rounded-pill bg-warning bg-opacity-10 text-warning">
                                                            <i class="fas fa-clock me-1"></i> En attente
                                                        </span>
                                                    @endif
                                                </td>
                                                <td>
                                                    <div class="d-flex gap-2">
                                                        <a title="Voir détails"
                                                            class="btn btn-sm btn-icon btn-outline-primary rounded-circle"
                                                            href="{{ route('partner.properties.show', $property->uuid) }}">
                                                            {{-- <i class="icon icon-eye"></i> --}}
                                                            <i class="fas fa-eye"></i>
                                                        </a>

                                                        <a title="Modifier" href="javascript:void(0)"
                                                            class="btn btn-sm btn-icon btn-outline-secondary rounded-circle"
                                                            title="Modifier">
                                                            <i class="fas fa-edit"></i>
                                                        </a>
                                                        <a class="btn btn-sm btn-icon btn-outline-danger rounded-circle"
                                                            href="javascript:void(0)" title="Supprimer"><i
                                                                class="icon icon-trash"></i></a>


                                                    </div>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="7" class="text-center py-5">
                                                    <div class="d-flex flex-column align-items-center">
                                                        <i class="fas fa-home fa-3x text-muted mb-3 opacity-50"></i>
                                                        <h5 class="fw-semibold">Aucune propriété trouvée</h5>
                                                        <p class="text-muted">Aucune propriété ne correspond à vos critères
                                                            de recherche</p>
                                                        <a href="{{ route('partner.properties.index') }}"
                                                            class="btn btn-sm btn-outline-primary mt-2">
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
    </div>
@endsection
