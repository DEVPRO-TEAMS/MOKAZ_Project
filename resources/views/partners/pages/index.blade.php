@extends('layouts.app')

@section('content')
<div class="container-fluid py-4">

    <!-- ✅ BREADCRUMB -->
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb bg-light rounded px-4 py-2 shadow-sm">
            <li class="breadcrumb-item"><a href="javascript:void(0);"><i class="fas fa-home me-1"></i> Accueil</a></li>
            <li class="breadcrumb-item active" aria-current="page">Partenaires</li>
        </ol>
    </nav>

    <!-- ✅ HEADER + BUTTON AJOUT -->
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <h4 class="fw-bold mb-1"><i class="fas fa-handshake text-primary me-2"></i>Liste des partenaires</h4>
            <p class="text-muted small mb-0">{{ count($partners) }} partenaires enregistrés</p>
        </div>
        <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addPartnerModal">
            <i class="fas fa-plus-circle me-1"></i> Ajouter un partenaire
        </button>
    </div>

    <!-- ✅ TABLE CARD -->
    <div class="card shadow-sm border-0">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table align-middle mb-0 table-hover table-bordered">
                    <thead class="bg-light text-dark fw-semibold">
                        <tr>
                            <th>Entreprise</th>
                            <th>Email</th>
                            <th>Téléphone</th>
                            <th>Site Web</th>
                            <th>Adresse</th>
                            <th>Statut</th>
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($partners as $partner)
                            <tr>
                                <td>{{ $partner->raison_social ?? 'N/A' }}</td>
                                <td>{{ $partner->email ?? '-' }}</td>
                                <td>{{ $partner->phone ?? '-' }}</td>
                                <td><a href="{{ $partner->website }}" target="_blank">{{ $partner->website ?? '-' }}</a></td>
                                <td>{{ $partner->adresse ?? '-' }}</td>
                                <td>
                                    <span class="badge {{ $partner->etat == 'actif' ? 'bg-success' : 'bg-secondary' }}">
                                        {{ strtoupper($partner->etat ?? 'inconnu') }}
                                    </span>
                                </td>
                                <td class="text-center">
                                    <div class="d-flex justify-content-center gap-2">
                                        <button class="btn btn-sm btn-outline-info">
                                            <a href="{{ route('admin.showPartner', $partner->uuid) }}" title="Voir">
                                                <i class="fas fa-eye text-secondary"></i>
                                            </a>
                                        </button>
                                        <button class="btn btn-sm btn-outline-primary"
                                            data-bs-toggle="modal" data-bs-target="#editModal{{ $partner->uuid }}"
                                            title="Modifier">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button class="btn btn-sm btn-outline-danger" title="Supprimer">
                                            <a class="deleteConfirmation" data-uuid="{{ $partner->uuid }}"
                                                data-token="{{ csrf_token() }}"
                                                data-type="confirmation_redirect"
                                                data-url="{{ route('admin.destroyPartner', $partner->uuid) }}"
                                                data-title="Vous êtes sur le point de supprimer {{ $partner->raison_social }}"
                                                data-id="{{ $partner->uuid }}"
                                                data-route="{{ route('admin.destroyPartner', $partner->uuid) }}">
                                                <i class="fas fa-trash"></i>
                                            </a>
                                        </button>
                                    </div>
                                </td>
                            </tr>

                            {{-- Modal modification --}}
                            @include('partners.components.editModal', ['partner' => $partner])
                        @empty
                            <tr>
                                <td colspan="7" class="text-center text-muted">Aucun partenaire trouvé.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

{{-- Modal ajout partenaire --}}
@include('partners.components.addModal')
@endsection
