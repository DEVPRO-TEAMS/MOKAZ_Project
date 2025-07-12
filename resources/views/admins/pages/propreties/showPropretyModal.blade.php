<!-- Modal détails propriété -->
<div class="modal fade" id="showPropertyModal{{ $property->id }}" tabindex="-1" aria-labelledby="showPropertyModalLabel{{ $property->id }}" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header bg-primary bg-opacity-10 border-0">
                <div class="d-flex align-items-center">
                    <div class="property-image me-3">
                        @if($property->image_property)
                            <img src="{{ asset('media/properties/'.$property->image_property)}}" 
                                 alt="{{ $property->title }}" 
                                 class="rounded-2" 
                                 style="width: 40px; height: 40px; object-fit: cover;">
                        @else
                            <div class="avatar-initials bg-primary bg-opacity-10 text-primary d-flex align-items-center justify-content-center rounded-2" 
                                 style="width: 40px; height: 40px;">
                                <i class="fas fa-home"></i>
                            </div>
                        @endif
                    </div>
                    <div>
                        <h5 class="modal-title mb-0" id="showPropertyModalLabel{{ $property->id }}">
                            {{ $property->title ?? 'Propriété' }}
                        </h5>
                        <small class="text-muted">Code: #{{ $property->property_code ?? '' }}</small>
                    </div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
            </div>
            
            <div class="modal-body p-4">
                <div class="row">
                    <!-- Image principale -->
                    <div class="col-md-5 mb-4">
                        <div class="property-image-container">
                            @if($property->image_property)
                                <img src="{{ asset('media/properties/'.$property->image_property)}}" 
                                     alt="{{ $property->title }}" 
                                     class="img-fluid rounded-3 shadow-sm w-100" 
                                     style="height: 200px; object-fit: cover;">
                            @else
                                <div class="bg-light rounded-3 d-flex align-items-center justify-content-center" 
                                     style="height: 200px;">
                                    <i class="fas fa-home fa-3x text-muted"></i>
                                </div>
                            @endif
                        </div>
                    </div>
                    
                    <!-- Informations principales -->
                    <div class="col-md-7">
                        <div class="row g-3">
                            <div class="col-12">
                                <div class="info-item">
                                    <label class="form-label fw-semibold text-muted mb-1">
                                        <i class="fas fa-tag me-2"></i>Titre
                                    </label>
                                    <p class="mb-0">{{ $property->title ?? 'Non renseigné' }}</p>
                                </div>
                            </div>
                            
                            <div class="col-6">
                                <div class="info-item">
                                    <label class="form-label fw-semibold text-muted mb-1">
                                        <i class="fas fa-handshake me-2"></i>Partenaire
                                    </label>
                                    <p class="mb-0">
                                        <span class="badge bg-info bg-opacity-10 text-info">
                                            {{ $property->partner_code ?? 'Non assigné' }}
                                        </span>
                                    </p>
                                </div>
                            </div>
                            
                            <div class="col-6">
                                <div class="info-item">
                                    <label class="form-label fw-semibold text-muted mb-1">
                                        <i class="fas fa-toggle-on me-2"></i>Statut
                                    </label>
                                    <p class="mb-0">
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
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <hr class="my-4">
                
                <!-- Localisation -->
                <div class="row mb-4">
                    <div class="col-12">
                        <h6 class="fw-semibold mb-3">
                            <i class="fas fa-map-marker-alt me-2 text-danger"></i>Localisation
                        </h6>
                    </div>
                    <div class="col-md-6">
                        <div class="info-item mb-3">
                            <label class="form-label fw-semibold text-muted mb-1">Adresse</label>
                            <p class="mb-0">{{ $property->address ?? 'Non renseigné' }}</p>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="info-item mb-3">
                            <label class="form-label fw-semibold text-muted mb-1">Ville</label>
                            <p class="mb-0">{{ $property->city ?? 'Non renseigné' }}</p>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="info-item mb-3">
                            <label class="form-label fw-semibold text-muted mb-1">Code postal</label>
                            <p class="mb-0">{{ $property->zipCode ?? 'Non renseigné' }}</p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="info-item mb-3">
                            <label class="form-label fw-semibold text-muted mb-1">Pays</label>
                            <p class="mb-0">{{ $property->country ?? 'Non renseigné' }}</p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="info-item mb-3">
                            <label class="form-label fw-semibold text-muted mb-1">Coordonnées GPS</label>
                            <p class="mb-0">
                                @if($property->latitude && $property->longitude)
                                    <span class="badge bg-secondary bg-opacity-10 text-secondary">
                                        <i class="fas fa-map-pin me-1"></i>
                                        {{ $property->latitude }}, {{ $property->longitude }}
                                    </span>
                                @else
                                    Non renseigné
                                @endif
                            </p>
                        </div>
                    </div>
                </div>
                
                <!-- Description -->
                <div class="row mb-4">
                    <div class="col-12">
                        <h6 class="fw-semibold mb-3">
                            <i class="fas fa-align-left me-2 text-primary"></i>Description
                        </h6>
                        <div class="bg-light rounded-3 p-3">
                            <p class="mb-0">{!! $property->description ?? 'Aucune description disponible' !!}</p>
                        </div>
                    </div>
                </div>
                
                <!-- Informations de suivi -->
                <div class="row">
                    <div class="col-12">
                        <h6 class="fw-semibold mb-3">
                            <i class="fas fa-info-circle me-2 text-info"></i>Informations de suivi
                        </h6>
                    </div>
                    <div class="col-md-4">
                        <div class="info-item mb-3">
                            <label class="form-label fw-semibold text-muted mb-1">Créé le</label>
                            <p class="mb-0">
                                {{ $property->created_at->format('d/m/Y à H:i') ?? 'Non renseigné' }}
                                <br>
                                <small class="text-muted">{{ $property->created_at->diffForHumans() ?? '' }}</small>
                            </p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="info-item mb-3">
                            <label class="form-label fw-semibold text-muted mb-1">Créé par</label>
                            <p class="mb-0">{{ $property->created_by ?? 'Non renseigné' }}</p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="info-item mb-3">
                            <label class="form-label fw-semibold text-muted mb-1">Modifié le</label>
                            <p class="mb-0">
                                {{ $property->updated_at->format('d/m/Y à H:i') ?? 'Non renseigné' }}
                                <br>
                                <small class="text-muted">{{ $property->updated_at->diffForHumans() ?? '' }}</small>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="modal-footer border-0 bg-light">
                <div class="d-flex justify-content-between w-100">
                    <div>
                        @if($property->etat == 'pending')
                            <button type="button" class="btn btn-success me-2" onclick="approveProperty({{ $property->id }})">
                                <i class="fas fa-check me-1"></i> Approuver
                            </button>
                            <button type="button" class="btn btn-danger" onclick="rejectProperty({{ $property->id }})">
                                <i class="fas fa-times me-1"></i> Rejeter
                            </button>
                        @endif
                    </div>
                    <div>
                        <button type="button" class="btn btn-secondary me-2" onclick="editProperty({{ $property->id }})">
                            <i class="fas fa-edit me-1"></i> Modifier
                        </button>
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                            <i class="fas fa-times me-1"></i> Fermer
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>