<style>
    .modal-content {
        border-radius: 15px;
        border: none;
        box-shadow: 0 10px 30px rgba(0,0,0,0.15);
        overflow: hidden;
    }
    
    .modal-header {
        background: linear-gradient(135deg, #cd380f 0%, #a02f0c 100%);
        color: white;
        border-bottom: none;
        padding: 1.5rem;
    }
    
    .modal-header h5 {
        font-weight: 600;
        margin: 0;
    }
    
    .modal-header .btn-close {
        filter: invert(1);
        opacity: 0.8;
    }
    
    .modal-header .btn-close:hover {
        opacity: 1;
    }
                
    .partner-info-card {
        background: #f8f9fa;
        border-radius: 10px;
        padding: 1.5rem;
        margin-bottom: 1.5rem;
        border-left: 4px solid #cd380f;
        transition: all 0.3s ease;
        animation: slideInUp 0.5s ease forwards;
        opacity: 0;
        transform: translateY(20px);
    }
    
    .partner-info-card:hover {
        box-shadow: 0 5px 15px rgba(205, 56, 15, 0.1);
        transform: translateY(-2px);
    }
    
    @keyframes slideInUp {
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    .info-section {
        margin-bottom: 2rem;
    }
                
    .info-section h6 {
        color: #cd380f;
        font-weight: 600;
        margin-bottom: 1rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    
    .info-section h6::after {
        content: '';
        flex: 1;
        height: 2px;
        background: linear-gradient(to right, #cd380f, transparent);
    }
    
    .info-item {
        display: flex;
        align-items: center;
        padding: 0.75rem 0;
        border-bottom: 1px solid #e9ecef;
        transition: all 0.3s ease;
    }
    
    .info-item:last-child {
        border-bottom: none;
    }
                
    .info-item:hover {
        background: rgba(205, 56, 15, 0.05);
        margin: 0 -1rem;
        padding-left: 1rem;
        padding-right: 1rem;
        border-radius: 8px;
    }
    
    .info-label {
        font-weight: 600;
        color: #495057;
        min-width: 120px;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    
    .info-value {
        color: #212529;
        flex: 1;
    }
                
    .status-badge {
        padding: 0.5rem 1rem;
        border-radius: 20px;
        font-weight: 500;
        font-size: 0.875rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        animation: pulse 2s infinite;
    }
    
    @keyframes pulse {
        0%, 100% { transform: scale(1); }
        50% { transform: scale(1.05); }
    }
    
    .status-pending {
        background: #fff3cd;
        color: #856404;
        border: 1px solid #ffeaa7;
    }
                
    .status-approved {
        background: #d1edff;
        color: #0c5460;
        border: 1px solid #b8daff;
    }
    
    .status-rejected {
        background: #f8d7da;
        color: #721c24;
        border: 1px solid #f5c6cb;
    }
    
    .contact-actions {
        display: flex;
        gap: 0.5rem;
        flex-wrap: wrap;
    }
    
    .contact-btn {
        padding: 0.5rem 1rem;
        border-radius: 25px;
        border: none;
        font-size: 0.875rem;
        font-weight: 500;
        transition: all 0.3s ease;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
    }
                
    .contact-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0,0,0,0.15);
    }
    
    .btn-email {
        background: #cd380f;
        color: white;
    }
    
    .btn-phone {
        background: #28a745;
        color: white;
    }
    
    .btn-website {
        background: #007bff;
        color: white;
    }
    
    .message-box {
        background: #fff;
        border: 1px solid #dee2e6;
        border-radius: 10px;
        padding: 1.5rem;
        margin-top: 1rem;
        position: relative;
        box-shadow: 0 2px 10px rgba(0,0,0,0.05);
    }
    
    .message-box::before {
        content: '"';
        position: absolute;
        top: -10px;
        left: 20px;
        font-size: 3rem;
        color: #cd380f;
        font-family: serif;
    }
    
    .timeline-item {
        position: relative;
        padding-left: 2rem;
        margin-bottom: 1rem;
    }
                
    .timeline-item::before {
        content: '';
        position: absolute;
        left: 0;
        top: 0.5rem;
        width: 12px;
        height: 12px;
        background: #cd380f;
        border-radius: 50%;
        animation: bounce 2s infinite;
    }
    
    @keyframes bounce {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-5px); }
    }
    
    .timeline-item::after {
        content: '';
        position: absolute;
        left: 5px;
        top: 1.2rem;
        width: 2px;
        height: calc(100% + 1rem);
        background: #e9ecef;
    }

    .timeline-item:last-child::after {
        display: none;
    }
    
    .modal-footer {
        border-top: 1px solid #e9ecef;
        padding: 1rem 1.5rem;
        background: #f8f9fa;
    }
    
    .btn-action {
        padding: 0.75rem 1.5rem;
        border-radius: 25px;
        font-weight: 500;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        transition: all 0.3s ease;
        border: none;
    }
    
    .btn-action:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0,0,0,0.15);
    }
    
    .btn-approve {
        background: #28a745;
        color: white;
    }
    
    .btn-reject {
        background: #dc3545;
        color: white;
    }
    
    .btn-secondary {
        background: #6c757d;
        color: white;
    }

    .fade-in {
        animation: fadeIn 0.6s ease forwards;
    }
    
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }
    
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
        gap: 1rem;
        margin-top: 1rem;
    }
    
    .stat-card {
        background: white;
        border-radius: 10px;
        padding: 1rem;
        text-align: center;
        box-shadow: 0 2px 8px rgba(0,0,0,0.05);
        transition: transform 0.3s ease;
    }
    
    .stat-card:hover {
        transform: translateY(-3px);
    }
    
    .stat-number {
        font-size: 1.5rem;
        font-weight: 700;
        color: #cd380f;
    }
    
    .stat-label {
        font-size: 0.875rem;
        color: #6c757d;
        margin-top: 0.25rem;
    }
</style>

<div class="modal fade" id="showDemandeModal{{ $demandePartenariat->id }}" tabindex="-1" aria-labelledby="showModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content" id="showDemandeContent{{ $demandePartenariat->id }}">
            <div class="modal-header">
                <h5 class="modal-title text-light">
                    <i class="fas fa-user-tie me-2"></i>Détails de la demande de partenariat
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" id="showDemandeBody{{ $demandePartenariat->id }}">
                <!-- Informations Personnelles -->
                <div class="info-section fade-in">
                    <h6><i class="fas fa-user"></i>Informations Personnelles</h6>
                    <div class="partner-info-card">
                        <div class="row g-0">
                            <div class="col-md-6">
                                <div class="info-item">
                                    <div class="info-label">
                                        <i class="fas fa-user-circle text-muted"></i>
                                        Prénom :
                                    </div>
                                    <div class="info-value" id="show-first-name">{{ $demandePartenariat->first_name ?? '' }}</div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="info-item">
                                    <div class="info-label">
                                        <i class="fas fa-user-circle text-muted"></i>
                                        Nom :
                                    </div>
                                    <div class="info-value" id="show-last-name">{{ $demandePartenariat->last_name ?? '' }}</div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="info-item">
                                    <div class="info-label">
                                        <i class="fas fa-envelope text-muted"></i>
                                        Email :
                                    </div>
                                    <div class="info-value" id="show-email">{{ $demandePartenariat->email ?? '' }}</div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="info-item">
                                    <div class="info-label">
                                        <i class="fas fa-phone text-muted"></i>
                                        Téléphone :
                                    </div>
                                    <div class="info-value" id="show-phone">{{ $demandePartenariat->phone ?? '' }}</div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="contact-actions mt-3">
                            <a href="#" class="contact-btn btn-email" id="email-btn">
                                <i class="fas fa-envelope"></i>
                                Envoyer un email
                            </a>
                            <a href="#" class="contact-btn btn-phone" id="phone-btn">
                                <i class="fas fa-phone"></i>
                                Appeler
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Informations Professionnelles -->
                <div class="info-section fade-in">
                    <h6><i class="fas fa-building"></i>Informations Professionnelles</h6>
                    <div class="partner-info-card">
                        <div class="row g-0">
                            <div class="col-md-6">
                                <div class="info-item">
                                    <div class="info-label">
                                        <i class="fas fa-building text-muted"></i>
                                        Entreprise :
                                    </div>
                                    <div class="info-value" id="show-company">{{ $demandePartenariat->company ?? '' }}</div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="info-item">
                                    <div class="info-label">
                                        <i class="fas fa-home text-muted"></i>
                                        Type de bien :
                                    </div>
                                    <div class="info-value" id="show-property-type">{{ $demandePartenariat->property_type ?? '' }}</div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="info-item">
                                    <div class="info-label">
                                        <i class="fas fa-map-marker-alt text-muted"></i>
                                        Zone d'activité :
                                    </div>
                                    <div class="info-value" id="show-activity-zone">{{ $demandePartenariat->activity_zone ?? '' }}</div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="info-item">
                                    <div class="info-label">
                                        <i class="fas fa-calendar-alt text-muted"></i>
                                        Expérience :
                                    </div>
                                    <div class="info-value" id="show-experience">5-10 ans</div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="info-item">
                                    <div class="info-label">
                                        <i class="fas fa-chart-bar text-muted"></i>
                                        Portefeuille :
                                    </div>
                                    <div class="info-value" id="show-portfolio-size">{{ $demandePartenariat->portfolio_size ?? '' }}</div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="info-item">
                                    <div class="info-label">
                                        <i class="fas fa-globe text-muted"></i>
                                        Site web :
                                    </div>
                                    <div class="info-value" id="show-website">{{ $demandePartenariat->website ?? '' }}</div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="contact-actions mt-3">
                            <a href="#" class="contact-btn btn-website" id="website-btn">
                                <i class="fas fa-globe"></i>
                                Visiter le site
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Statistiques -->
                <div class="info-section fade-in">
                    <h6><i class="fas fa-chart-line"></i>Statistiques</h6>
                    <div class="stats-grid">
                        <div class="stat-card">
                            <div class="stat-number">{{ $demandePartenariat->portfolio_size ?? '' }}</div>
                            <div class="stat-label">Biens en portefeuille</div>
                        </div>
                        <div class="stat-card">
                            <div class="stat-number">{{ $demandePartenariat->experience ?? '' }}</div>
                            <div class="stat-label">Années d'expérience</div>
                        </div>
                        <div class="stat-card">
                            <div class="stat-number">4.8</div>
                            <div class="stat-label">Note moyenne</div>
                        </div>
                    </div>
                </div>

                <!-- Message -->
                <div class="info-section fade-in">
                    <h6><i class="fas fa-comment-dots"></i>Message du partenaire</h6>
                    <div class="message-box">
                        <p id="show-message" class="mb-0">
                            {{ $demandePartenariat->message ?? '' }}
                        </p>
                    </div>
                </div>

                <!-- Statut et Préférences -->
                <div class="info-section fade-in">
                    <h6><i class="fas fa-cogs"></i>Statut et Préférences</h6>
                    <div class="partner-info-card">
                        <div class="row g-0">
                            <div class="col-md-6">
                                <div class="info-item">
                                    <div class="info-label">
                                        <i class="fas fa-bell text-muted"></i>
                                        Newsletter :
                                    </div>
                                    <div class="info-value" id="show-newsletter">
                                        <span class="badge bg-success">Acceptée</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="info-item">
                                    <div class="info-label">
                                        <i class="fas fa-flag text-muted"></i>
                                        État :
                                    </div>
                                    <div class="info-value" id="show-etat">
                                        <span id="etat-wrap-span" class="status badge bg-{{ $demandePartenariat->etat == 'actif' ? 'success' : ($demandePartenariat->etat == 'inactif' ? 'danger' : 'warning') }}">
                                            @if ($demandePartenariat->etat == 'actif')
                                                Approuve
                                            @elseif ($demandePartenariat->etat == 'inactif')
                                                Inactif
                                            @elseif ($demandePartenariat->etat == 'pending')
                                                En attente
                                            @else
                                                Non Defini
                                            @endif
                                        </span>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Timeline -->
                <div class="info-section fade-in">
                    <h6><i class="fas fa-history"></i>Historique</h6>
                    <div class="timeline-item">
                        <strong>Demande soumise</strong>
                        <div class="text-muted small">{{ $demandePartenariat->created_at->diffForHumans() ?? '' }}</div>
                    </div>
                    <div class="timeline-item">
                        <strong>Vérification en cours</strong>
                        <div class="text-muted small">Il y a 1 jour</div>
                    </div>
                    <div class="timeline-item">
                        <strong>En attente d'approbation</strong>
                        <div class="text-muted small">Maintenant</div>
                    </div>
                </div>
            </div>
            
            <div class="modal-footer">
                
                <button class="btn btn-action btn-approve" type="button" onclick="approveDemand(this)" data-id="{{ $demandePartenariat->id }}">
                    <i class="fas fa-check me-2"></i>Approuver
                </button>

                <button class="btn btn-action btn-reject" type="button" onclick="rejectDemand(this)" data-id="{{ $demandePartenariat->id }}">
                    <i class="fas fa-times me-2"></i>Refuser
                </button>

                <button class="btn btn-action btn-secondary" data-bs-dismiss="modal">
                    <i class="fas fa-arrow-left me-2"></i>Fermer
                </button>
            </div>
        </div>
    </div>
</div>

<script>
    // document.addEventListener('DOMContentLoaded', function() {
    
        async function approveDemand(buttonElement) {
            const demandeId = buttonElement.getAttribute('data-id');
            const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content;

            // Message de confirmation
            const confirmation = await Swal.fire({
                title: 'Confirmer l\'approbation ?',
                icon: 'question',
                text: 'Voulez-vous vraiment approuver cette demande ?',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Oui, approuver',
                cancelButtonText: 'Annuler',
                showLoaderOnConfirm: true,
                preConfirm: async () => {
                    try {
                        // Animation du bouton pendant le traitement
                        buttonElement.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Traitement...';
                        buttonElement.disabled = true;

                        const response = await fetch(`/api/partnership/accept/${demandeId}`, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': csrfToken,
                                'Accept': 'application/json'
                            },
                            body: JSON.stringify({})
                        });

                        if (!response.ok) {
                            throw new Error('Erreur réseau');
                        }

                        const result = await response.json();

                        if (!result.status) {
                            throw new Error(result.message || 'Erreur lors du traitement');
                        }

                        return result;
                    } catch (error) {
                        Swal.showValidationMessage(
                            `Erreur: ${error.message}`
                        );
                        // Réactiver le bouton en cas d'erreur
                        buttonElement.innerHTML = 'Approuver';
                        buttonElement.disabled = false;
                        return false;
                    }
                },
                allowOutsideClick: () => !Swal.isLoading()
            });

            if (confirmation.isConfirmed) {
                // Mise à jour du DOM après succès
                buttonElement.innerHTML = '<i class="fas fa-check-circle"></i> Approuvé';
                buttonElement.classList.remove('btn-primary');
                buttonElement.classList.add('btn-success');
                buttonElement.disabled = true;
                
                // Mise à jour du statut dans le tableau si nécessaire
                const statusElement = document.getElementById(`etat-wrap-span${demandeId}`); 
                
                if (statusElement) {
                    statusElement.textContent = 'Approuvé';
                    statusElement.classList.remove('bg-warning', 'bg-danger');
                    statusElement.classList.add('bg-success');
                }

                Swal.fire(
                    'Approuvé !',
                    'La demande a été approuvée avec succès.',
                    'success'
                );
            }

            const modal = bootstrap.Modal.getInstance(document.getElementById(`showDemandeModal${demandeId}`));
            modal.hide();

        }

        async function rejectDemand(buttonElement) {
            const demandeId = buttonElement.getAttribute('data-id');
            const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content;

            // Message de confirmation
            const confirmation = await Swal.fire({
                title: 'Confirmer le rejet ?',
                icon: 'warning',
                text: 'Voulez-vous vraiment rejeter cette demande ? Cette action est irréversible.',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Oui, rejeter',
                cancelButtonText: 'Annuler',
                showLoaderOnConfirm: true,
                preConfirm: async () => {
                    try {
                        // Animation du bouton pendant le traitement
                        buttonElement.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Traitement...';
                        buttonElement.disabled = true;
                        const response = await fetch(`/api/demande/rejet/${demandeId}`, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': csrfToken,
                                'Accept': 'application/json'
                            },
                            body: JSON.stringify({})
                        });

                        if (!response.ok) {
                            throw new Error('Erreur réseau', response.status);
                        }

                        const result = await response.json();

                        if (!result.status) {
                            throw new Error(result.message || 'Erreur lors du traitement');
                        }

                        return result;
                    } catch (error) {
                        Swal.showValidationMessage(
                            `Erreur: ${error.message}`
                        );
                        // Réactiver le bouton en cas d'erreur
                        buttonElement.innerHTML = 'Rejeter';
                        buttonElement.disabled = false;
                        return false;
                    }
                },
                allowOutsideClick: () => !Swal.isLoading()
            });

            if (confirmation.isConfirmed) {
                // Mise à jour du DOM après succès
                buttonElement.innerHTML = '<i class="fas fa-times-circle"></i> Rejeté';
                buttonElement.classList.remove('btn-danger');
                buttonElement.classList.add('btn-secondary');
                buttonElement.disabled = true;
                
                // Mise à jour du statut dans le tableau si nécessaire
                const statusElement = document.getElementById(`etat-wrap-span${demandeId}`); 
                
                if (statusElement) {
                    statusElement.textContent = 'Rejeté';
                    statusElement.classList.remove('bg-warning', 'bg-success');
                    statusElement.classList.add('bg-danger');
                }

                Swal.fire(
                    'Rejeté !',
                    'La demande a été rejetée avec succès.',
                    'success'
                );
            }

            setInterval(() => {
                window.location.reload();
                
            }, 2000);

            const modal = bootstrap.Modal.getInstance(document.getElementById(`showDemandeModal${demandeId}`));
            modal.hide();
        }

    // });

</script>

