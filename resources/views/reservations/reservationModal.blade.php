<!-- Modal Multi-Étapes -->
<div class="modal fade" id="reservationModal" tabindex="-1" aria-labelledby="reservationModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-danger text-light">
                <h5 class="modal-title text-light" id="reservationModalLabel">
                    <i class="fas fa-calendar-check me-2"></i>Processus de Réservation
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Stepper -->
                <div class="stepper-wrapper mb-4">
                    <div class="stepper-item active" data-step="1">
                        <div class="step-counter bg-danger text-white">1</div>
                        <div class="step-name fw-bold">Informations<br>Personnelles</div>
                    </div>
                    <div class="stepper-item" data-step="2">
                        <div class="step-counter bg-secondary">2</div>
                        <div class="step-name">Facture &<br>Paiement</div>
                    </div>
                    <div class="stepper-item" data-step="3">
                        <div class="step-counter bg-secondary">3</div>
                        <div class="step-name">Confirmation &<br>Reçu</div>
                    </div>
                </div>

                @php
                    $tarifHeure = $appart->tarifications->where('sejour', 'Heure');
                    $tarifJour = $appart->tarifications->where('sejour', 'Jour');
                    $tarifHeureSort = $tarifHeure->sortBy('price')->first();
                    $tarifHeureCount = $tarifHeure->count();
                    $tarifJourCount = $tarifJour->count();
                    $tarifByDay = $tarifJour->first();
                    
                    // Déterminer la sélection par défaut
                    $checkedType = null;
                    if ($tarifHeureCount > 0 && $tarifJourCount > 0) {
                        $checkedType = $tarifHeureCount >= $tarifJourCount ? 'heure' : 'jour';
                    } elseif ($tarifHeureCount > 0) {
                        $checkedType = 'heure';
                    } elseif ($tarifJourCount > 0) {
                        $checkedType = 'jour';
                    }
                @endphp

                <!-- Étape 1: Informations Personnelles -->
                <div class="step-content active" id="step1">
                    <div class="row g-3">
                        <!-- Choix du type de séjour -->
                        @if($tarifHeureCount > 0 || $tarifJourCount > 0)
                            <div class="col-12">
                                <label class="form-label d-block"><i class="fas fa-clock me-2"></i>Type de séjour *</label>
                                <div class="d-flex gap-3 flex-wrap">
                                    @if($tarifJourCount > 0)
                                        <div class="card p-3 flex-fill text-center type-sejour-card" style="cursor: pointer;">
                                            <input type="radio" name="sejour" id="sejour_jour" class="btn-check"
                                                value="jour" autocomplete="off"
                                                {{ $checkedType === 'jour' ? 'checked' : '' }}>
                                            <label class="btn btn-outline-danger w-100" for="sejour_jour">
                                                <i class="fas fa-calendar-day me-2"></i>Par Jour
                                            </label>
                                        </div>
                                    @endif

                                    @if($tarifHeureCount > 0)
                                        <div class="card p-3 flex-fill text-center type-sejour-card" style="cursor: pointer;">
                                            <input type="radio" name="sejour" id="sejour_heure" class="btn-check"
                                                value="heure" autocomplete="off"
                                                {{ $checkedType === 'heure' ? 'checked' : '' }}>
                                            <label class="btn btn-outline-danger w-100" for="sejour_heure">
                                                <i class="fas fa-clock me-2"></i>Par Heure
                                            </label>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @endif

                        <!-- Bloc: Dates si "jour" est sélectionné -->
                        <div id="bloc-jour" class="row g-3 {{ $checkedType === 'jour' ? '' : 'd-none'}}">
                            <div class="col-md-6">
                                <label for="start_date_jour" class="form-label">
                                    <i class="fas fa-calendar-alt me-2"></i>Date d'arrivée *
                                </label>
                                <input type="date" class="form-control form-control-lg" name="start_date_jour" id="start_date_jour">
                            </div>
                            <div class="col-md-6">
                                <label for="end_date_jour" class="form-label">
                                    <i class="fas fa-calendar-alt me-2"></i>Date de départ *
                                </label>
                                <input type="date" class="form-control form-control-lg" name="end_date_jour" id="end_date_jour">
                            </div>
                        </div>
                        
                        <!-- Bloc: Options si "heure" est sélectionné -->
                        <div id="bloc-heure" class="row g-3 {{ $checkedType === 'heure' ? '' : 'd-none'}}">
                            <div class="col-md-6 d-flex flex-column justify-content-center align-items-start">
                                @foreach($appart->tarifications->where('etat','!=', 'inactif')->where('sejour', 'Heure') as $tarif)
                                    <div class="form-check mb-3">
                                        <input class="form-check-input" type="radio" value="{{ $tarif->price }}" 
                                               name="tarif_by_sejour" id="tarifBySejour{{ $tarif->uuid }}" 
                                               data-hours="{{ $tarif->nbr_of_sejour }}" required
                                               {{ $loop->first ? 'checked' : '' }}>
                                        <label class="form-check-label" for="tarifBySejour{{ $tarif->uuid }}">
                                            <strong>{{ number_format($tarif->price, 0, ',', ' ') }} FCFA / {{ $tarif->nbr_of_sejour }} heure{{ $tarif->nbr_of_sejour > 1 ? 's' : '' }}</strong>
                                        </label>
                                    </div>
                                @endforeach
                                
                                <div class="form-check mb-3">
                                    <input class="form-check-input" type="radio" value="custom" name="tarif_by_sejour" id="tarifCustom">
                                    <label class="form-check-label" for="tarifCustom">
                                        <strong>Autre durée</strong>
                                    </label>
                                </div>
                            </div>
                            <div id="custom-hours-block" class="col-md-6 d-none">
                                <label for="custom_hours" class="form-label">
                                    <i class="fas fa-hourglass-half me-2"></i>Nombre d'heures *
                                </label>
                                <input type="number" min="1" class="form-control form-control-lg"
                                    name="custom_hours" id="custom_hours" placeholder="Ex: 3">
                            </div>
                            
                            <div class="col-12 row">
                                <div class="col-md-6">
                                    <label for="start_date_heure" class="form-label">
                                        <i class="fas fa-calendar-alt me-2"></i>Date d'arrivée *
                                    </label>
                                    <input type="date" class="form-control form-control-lg" name="start_date_heure" id="start_date_heure">
                                </div>
                                <div class="col-md-6">
                                    <label for="start_time_heure" class="form-label">
                                        <i class="fas fa-clock me-2"></i>Heure d'arrivée *
                                    </label>
                                    <input type="time" class="form-control form-control-lg" name="start_time_heure" id="start_time_heure">
                                </div>
                            </div>
                        </div>

                        <!-- Informations personnelles -->
                        <div class="col-md-6">
                            <label for="nom" class="form-label"><i class="fas fa-user me-2"></i>Nom *</label>
                            <input type="text" class="form-control form-control-lg" name="nom" id="nom" placeholder="Dupont" required>
                        </div>
                        <div class="col-md-6">
                            <label for="prenoms" class="form-label"><i class="fas fa-user me-2"></i>Prénoms *</label>
                            <input type="text" class="form-control form-control-lg" name="prenoms" id="prenoms" placeholder="Jean" required>
                        </div>
                        <div class="col-md-6">
                            <label for="email" class="form-label"><i class="fas fa-envelope me-2"></i>Email *</label>
                            <input type="email" class="form-control form-control-lg" name="email" id="email" placeholder="jean.dupont@example.com" required>
                        </div>
                        <div class="col-md-6">
                            <label for="phone" class="form-label"><i class="fas fa-phone me-2"></i>Téléphone *</label>
                            <input type="tel" class="form-control form-control-lg" name="phone" id="phone" placeholder="0123456789" required>
                        </div>

                        <!-- Notes -->
                        <div class="col-12">
                            <label for="notes" class="form-label">
                                <i class="fas fa-comment me-2"></i>Commentaires
                            </label>
                            <textarea class="form-control form-control-lg" name="notes" id="notes" rows="3" placeholder="Demandes spéciales, préférences..."></textarea>
                        </div>
                    </div>

                    <!-- Aperçu du prix -->
                    <div id="price-preview" class="card bg-danger text-white mt-4">
                        <div class="card-body">
                            <h5 class="card-title"><i class="fas fa-calculator me-2"></i>Aperçu des prix</h5>
                            <div class="d-flex justify-content-between mb-2">
                                <span id="price-label">Tarif:</span>
                                <span id="unit-price">0 XOF</span>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <span id="duration-label">Durée:</span>
                                <span id="duration-value">0</span>
                            </div>
                            <div class="d-flex justify-content-between border-top pt-2 fw-bold">
                                <span>Total:</span>
                                <span id="total-amount">0 XOF</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Étape 2: Facture et Paiement -->
                <div class="step-content" id="step2">
                    <div class="row g-4">
                        <div class="col-lg-6">
                            <div class="card border-danger">
                                <div class="card-header bg-danger text-white">
                                    <h5 class="mb-0 text-white"><i class="fas fa-file-invoice me-2"></i>Facture</h5>
                                </div>
                                <div class="card-body" id="invoice-details">
                                    <!-- Contenu généré dynamiquement -->
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="card border-primary">
                                <div class="card-header bg-danger text-light">
                                    <h5 class="mb-0 text-white"><i class="fas fa-credit-card me-2"></i>Mode de paiement</h5>
                                </div>
                                <div class="card-body">
                                    <div class="row g-3">
                                        <div class="col-6">
                                            <button class="payment-method btn btn-outline-danger w-100 h-100 py-3" data-method="visa">
                                                <i class="fab fa-cc-visa fa-2x mb-2"></i>
                                                <div>Visa</div>
                                            </button>
                                        </div>
                                        <div class="col-6">
                                            <button class="payment-method btn btn-outline-danger w-100 h-100 py-3" data-method="mastercard">
                                                <i class="fab fa-cc-mastercard fa-2x mb-2"></i>
                                                <div>Mastercard</div>
                                            </button>
                                        </div>
                                        <div class="col-6">
                                            <button class="payment-method btn btn-outline-danger w-100 h-100 py-3" data-method="orange">
                                                <i class="fas fa-mobile-alt fa-2x mb-2"></i>
                                                <div>Orange Money</div>
                                            </button>
                                        </div>
                                        <div class="col-6">
                                            <button class="payment-method btn btn-outline-danger w-100 h-100 py-3" data-method="mtn">
                                                <i class="fas fa-mobile-alt fa-2x mb-2"></i>
                                                <div>MTN Money</div>
                                            </button>
                                        </div>
                                    </div>

                                    <div id="payment-form" class="mt-4 d-none">
                                        <div class="mb-3">
                                            <label for="card-number" class="form-label">Numéro de carte / Téléphone *</label>
                                            <input type="text" class="form-control" id="card-number" placeholder="1234 5678 9012 3456" required>
                                        </div>
                                        <div class="row g-2">
                                            <div class="col-md-6">
                                                <label for="expiry-date" class="form-label">Date d'expiration</label>
                                                <input type="text" class="form-control" id="expiry-date" placeholder="MM/AA">
                                            </div>
                                            <div class="col-md-6">
                                                <label for="cvv-code" class="form-label">CVV</label>
                                                <input type="text" class="form-control" id="cvv-code" placeholder="123" maxlength="3">
                                            </div>
                                        </div>
                                        <div class="mb-3 mt-2">
                                            <label for="card-name" class="form-label">Nom sur la carte *</label>
                                            <input type="text" class="form-control" id="card-name" placeholder="JEAN DUPONT" required>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Étape 3: Confirmation et Reçu -->
                <div class="step-content" id="step3">
                    <div class="text-center mb-4">
                        <div class="alert alert-success">
                            <i class="fas fa-check-circle fa-3x mb-3 text-success"></i>
                            <h4>Paiement réussi!</h4>
                            <p class="mb-0">Votre réservation a été confirmée avec succès</p>
                        </div>
                    </div>

                    <div class="card border-danger">
                        <div class="card-header bg-danger-light text-white">
                            <h5 class="mb-0"><i class="fas fa-receipt me-2"></i>Reçu de Paiement</h5>
                        </div>
                        <div class="card-body">
                            <div class="text-center mb-3">
                                <p class="text-muted mb-1">Numéro de réservation: <strong id="reservation-number"></strong></p>
                                <p class="text-muted">Date: <strong id="payment-date"></strong></p>
                            </div>
                            <div id="final-receipt">
                                <!-- Contenu généré dynamiquement -->
                            </div>
                        </div>
                    </div>

                    <div class="text-center mt-4">
                        <button class="btn btn-success btn-lg" onclick="downloadReceipt()">
                            <i class="fas fa-download me-2"></i>Télécharger le reçu
                        </button>
                    </div>
                </div>

                <!-- Politiques (affiché sur toutes les étapes) -->
                <div class="card mt-4">
                    <div class="card-header bg-light">
                        <h6 class="mb-0"><i class="fas fa-shield-alt me-2"></i>Politiques et Conditions</h6>
                    </div>
                    <div class="card-body">
                        <div class="form-check mb-3">
                            <input class="form-check-input" type="checkbox" id="policy-privacy" required>
                            <label class="form-check-label" for="policy-privacy">
                                <strong>Politique de confidentialité:</strong> J'accepte que mes données personnelles
                                soient collectées et traitées conformément à la politique de confidentialité
                            </label>
                        </div>
                        <div class="form-check mb-3">
                            <input class="form-check-input" type="checkbox" id="policy-refund" required>
                            <label class="form-check-label" for="policy-refund">
                                <strong>Politique de remboursement:</strong> J'ai lu et j'accepte les conditions de
                                remboursement (remboursement intégral jusqu'à 48h avant l'arrivée)
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="policy-terms" required>
                            <label class="form-check-label" for="policy-terms">
                                <strong>Conditions générales:</strong> J'accepte les conditions générales d'utilisation
                                et de séjour
                            </label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" id="prev-btn" onclick="previousStep()" style="display: none;">
                    <i class="fas fa-arrow-left me-2"></i>Précédent
                </button>
                <button type="button" class="btn btn-primary" id="next-btn" onclick="nextStep()">
                    Suivant <i class="fas fa-arrow-right ms-2"></i>
                </button>
                <button type="button" class="btn btn-success" id="pay-btn" onclick="processPayment()" style="display: none;">
                    <i class="fas fa-credit-card me-2"></i>Payer maintenant
                </button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" id="close-btn" style="display: none;">
                    Fermer
                </button>
            </div>
        </div>
    </div>
</div>

<style>
    /* Stepper Styles */
    .stepper-wrapper {
        display: flex;
        justify-content: space-between;
        position: relative;
    }

    .stepper-wrapper::before {
        content: '';
        position: absolute;
        top: 20px;
        left: 50px;
        right: 50px;
        height: 2px;
        background: var(--bs-gray-300);
        z-index: 1;
    }

    .stepper-item {
        display: flex;
        flex-direction: column;
        align-items: center;
        position: relative;
        z-index: 2;
        flex: 1;
    }

    .stepper-item .step-counter {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: bold;
        margin-bottom: 8px;
    }

    .stepper-item .step-name {
        font-size: 0.9rem;
        text-align: center;
        color: var(--bs-gray-600);
    }

    .stepper-item.active .step-name {
        color: var(--bs-dark);
        font-weight: 600;
    }

    /* Step Content */
    .step-content {
        display: none;
        animation: fadeIn 0.3s ease-in-out;
    }

    .step-content.active {
        display: block;
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(10px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* Payment Method Active State */
    .payment-method.active {
        background-color: rgba(220, 53, 69, 0.1);
        border-color: var(--bs-danger) !important;
        color: var(--bs-danger);
    }
</style>


<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
{{-- <script>
    // Variables globales
    const DAILY_RATE = @json($tarifByDay->price ?? 0);
    const HOURLY_RATE = @json($tarifHeureSort->price ?? 0);
    const MINIMUM_HOURS = 1;
    let currentStep = 1;
    let reservationData = {};
    let selectedPaymentMethod = null;

    // Initialisation
    document.addEventListener('DOMContentLoaded', function() {
        initializeDates();
        setupEventListeners();
        updatePricePreview();
    });

    function initializeDates() {
        const today = new Date().toISOString().split('T')[0];
        document.getElementById('start_date_jour').min = today;
        document.getElementById('end_date_jour').min = today;
        document.getElementById('start_date_heure').min = today;
        
        // Définir l'heure par défaut à maintenant + 1 heure
        const now = new Date();
        const defaultHour = now.getHours() + 1;
        document.getElementById('start_time_heure').value = `${defaultHour.toString().padStart(2, '0')}:00`;
    }

    function setupEventListeners() {
        // Changement de type de séjour
        document.querySelectorAll('input[name="sejour"]').forEach(radio => {
            radio.addEventListener('change', function() {
                if (this.value === 'jour') {
                    document.getElementById('bloc-jour').classList.remove('d-none');
                    document.getElementById('bloc-heure').classList.add('d-none');
                    
                    // Réinitialiser les sélections horaires
                    document.querySelectorAll('input[name="tarif_by_sejour"]').forEach(r => r.checked = false);
                    document.getElementById('custom_hours').value = '';
                    document.getElementById('custom-hours-block').classList.add('d-none');
                    
                    // Réinitialiser les dates/heures
                    document.getElementById('start_date_heure').value = '';
                    document.getElementById('start_time_heure').value = '';
                } else {
                    document.getElementById('bloc-jour').classList.add('d-none');
                    document.getElementById('bloc-heure').classList.remove('d-none');
                    
                    // Réinitialiser les dates journalières
                    document.getElementById('start_date_jour').value = '';
                    document.getElementById('end_date_jour').value = '';
                }
                updatePricePreview();
            });
        });

        // Changement de tarif horaire
        document.querySelectorAll('input[name="tarif_by_sejour"]').forEach(radio => {
            radio.addEventListener('change', function() {
                if (this.value === 'custom') {
                    document.getElementById('custom-hours-block').classList.remove('d-none');
                    document.getElementById('custom_hours').value = '';
                    document.getElementById('start_date_heure').removeAttribute('readonly');
                    document.getElementById('start_time_heure').removeAttribute('readonly');
                } else {
                    document.getElementById('custom-hours-block').classList.add('d-none');
                    document.getElementById('start_date_heure').removeAttribute('readonly');
                    document.getElementById('start_time_heure').removeAttribute('readonly');
                }
                updatePricePreview();
            });
        });

        // Validation du nombre d'heures personnalisé
        document.getElementById('custom_hours').addEventListener('input', function() {
            if (parseInt(this.value) > 0) {
                document.getElementById('start_date_heure').removeAttribute('readonly');
                document.getElementById('start_time_heure').removeAttribute('readonly');
            } else {
                document.getElementById('start_date_heure').value = '';
                document.getElementById('start_time_heure').value = '';
                document.getElementById('start_date_heure').setAttribute('readonly', true);
                document.getElementById('start_time_heure').setAttribute('readonly', true);
            }
            updatePricePreview();
        });

        // Écouteurs pour les champs de date/heure
        document.getElementById('start_date_jour').addEventListener('change', function() {
            const endDateInput = document.getElementById('end_date_jour');
            if (this.value) {
                endDateInput.min = this.value;
                updatePricePreview();
            }
        });

        document.getElementById('end_date_jour').addEventListener('change', function() {
            if (this.value) {
                updatePricePreview();
            }
        });
        
        document.getElementById('start_date_heure').addEventListener('change', updatePricePreview);
        document.getElementById('start_time_heure').addEventListener('change', updatePricePreview);

        // Écouteurs pour les modes de paiement
        document.querySelectorAll('.payment-method').forEach(method => {
            method.addEventListener('click', function() {
                selectPaymentMethod(this);
            });
        });

        // Reset modal au close
        document.getElementById('reservationModal').addEventListener('hidden.bs.modal', function() {
            resetModal();
        });
    }

    function updatePricePreview() {
        const isHourly = document.querySelector('input[name="sejour"]:checked')?.value === 'heure';
        
        if (isHourly) {
            updateHourlyPrice();
        } else {
            updateDailyPrice();
        }
    }

    function updateHourlyPrice() {
        let hours, unitPrice, total;
        const customTarifSelected = document.getElementById('tarifCustom').checked;
        
        if (customTarifSelected) {
            hours = parseInt(document.getElementById('custom_hours').value) || 0;
            unitPrice = HOURLY_RATE;
            total = hours * unitPrice;
            
            document.getElementById('price-label').textContent = 'Prix horaire:';
            document.getElementById('duration-label').textContent = 'Nombre d\'heures:';
        } else {
            const selectedTarif = document.querySelector('input[name="tarif_by_sejour"]:checked');
            if (selectedTarif) {
                hours = parseInt(selectedTarif.dataset.hours) || 0;
                unitPrice = parseFloat(selectedTarif.value) || 0;
                total = unitPrice;
                
                document.getElementById('price-label').textContent = 'Forfait:';
                document.getElementById('duration-label').textContent = 'Durée:';
            } else {
                // Aucun tarif sélectionné
                document.getElementById('unit-price').textContent = '0 XOF';
                document.getElementById('duration-value').textContent = '0 heure';
                document.getElementById('total-amount').textContent = '0 XOF';
                return;
            }
        }
        
        // Mise à jour de l'affichage
        document.getElementById('unit-price').textContent = unitPrice.toLocaleString('fr-FR') + ' XOF';
        document.getElementById('duration-value').textContent = hours + (hours > 1 ? ' heures' : ' heure');
        document.getElementById('total-amount').textContent = total.toLocaleString('fr-FR') + ' XOF';
        
        // Stocker les données pour l'étape suivante
        reservationData = {
            ...reservationData,
            isHourly: true,
            hours: hours,
            unitPrice: unitPrice,
            totalPrice: total,
            paymentAmount: total * 0.1, // 10% d'acompte
            startDate: document.getElementById('start_date_heure').value,
            startTime: document.getElementById('start_time_heure').value,
            customTarif: customTarifSelected
        };
    }

    function updateDailyPrice() {
        const startDate = document.getElementById('start_date_jour').value;
        const endDate = document.getElementById('end_date_jour').value;
        
        if (!startDate || !endDate) {
            document.getElementById('unit-price').textContent = '0 XOF';
            document.getElementById('duration-value').textContent = '0 jour';
            document.getElementById('total-amount').textContent = '0 XOF';
            return;
        }
        
        const start = new Date(startDate);
        const end = new Date(endDate);
        const days = Math.ceil((end - start) / (1000 * 60 * 60 * 24));
        
        if (days > 0) {
            const total = days * DAILY_RATE;
            
            document.getElementById('price-label').textContent = 'Prix journalier:';
            document.getElementById('unit-price').textContent = DAILY_RATE.toLocaleString('fr-FR') + ' XOF';
            document.getElementById('duration-label').textContent = 'Nombre de jours:';
            document.getElementById('duration-value').textContent = days + (days > 1 ? ' jours' : ' jour');
            document.getElementById('total-amount').textContent = total.toLocaleString('fr-FR') + ' XOF';
            
            // Stocker les données pour l'étape suivante
            reservationData = {
                ...reservationData,
                isHourly: false,
                days: days,
                unitPrice: DAILY_RATE,
                totalPrice: total,
                paymentAmount: total * 0.1, // 10% d'acompte
                startDate: startDate,
                endDate: endDate
            };
        }
    }

    function selectPaymentMethod(method) {
        document.querySelectorAll('.payment-method').forEach(m => m.classList.remove('active'));
        method.classList.add('active');
        selectedPaymentMethod = method;
        document.getElementById('payment-form').classList.remove('d-none');
    }

    function nextStep() {
        if (validateCurrentStep()) {
            if (currentStep < 3) {
                currentStep++;
                updateStepDisplay();

                if (currentStep === 2) {
                    generateInvoice();
                } else if (currentStep === 3) {
                    generateReceipt();
                }
            }
        }
    }

    function previousStep() {
        if (currentStep > 1) {
            currentStep--;
            updateStepDisplay();
        }
    }

    function validateCurrentStep() {
        // Validation des politiques
        const policiesChecked = document.querySelectorAll(
            '#policy-privacy:checked, #policy-refund:checked, #policy-terms:checked').length === 3;

        if (!policiesChecked) {
            Swal.fire({
                icon: 'warning',
                title: 'Politiques requises',
                text: 'Vous devez accepter toutes les politiques pour continuer'
            });
            return false;
        }

        if (currentStep === 1) {
            // Validation des champs obligatoires
            const requiredFields = ['nom', 'prenoms', 'email', 'phone'];
            const emptyFields = requiredFields.filter(field => !document.getElementById(field).value.trim());

            if (emptyFields.length > 0) {
                Swal.fire({
                    icon: 'error',
                    title: 'Champs requis',
                    text: 'Veuillez remplir tous les champs obligatoires'
                });
                return false;
            }

            // Validation spécifique selon le type de séjour
            const isHourly = document.querySelector('input[name="sejour"]:checked')?.value === 'heure';
            
            if (isHourly) {
                // Validation pour réservation horaire
                const customTarifSelected = document.getElementById('tarifCustom').checked;
                const hours = customTarifSelected ? 
                    parseInt(document.getElementById('custom_hours').value) : 
                    parseInt(document.querySelector('input[name="tarif_by_sejour"]:checked')?.dataset.hours);
                
                if (!hours || hours < MINIMUM_HOURS) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Durée invalide',
                        text: `Veuillez sélectionner une durée d'au moins ${MINIMUM_HOURS} heure${MINIMUM_HOURS > 1 ? 's' : ''}`
                    });
                    return false;
                }

                if (!document.getElementById('start_date_heure').value || !document.getElementById('start_time_heure').value) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Date/heure requise',
                        text: 'Veuillez sélectionner une date et une heure de début'
                    });
                    return false;
                }
            } else {
                // Validation pour réservation journalière
                if (!document.getElementById('start_date_jour').value || !document.getElementById('end_date_jour').value) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Dates requises',
                        text: 'Veuillez sélectionner une date d\'arrivée et de départ'
                    });
                    return false;
                }

                const startDate = new Date(document.getElementById('start_date_jour').value);
                const endDate = new Date(document.getElementById('end_date_jour').value);
                
                if (endDate <= startDate) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Dates invalides',
                        text: 'La date de départ doit être postérieure à la date d\'arrivée'
                    });
                    return false;
                }
            }

            // Stocker les données personnelles
            reservationData = {
                ...reservationData,
                nom: document.getElementById('nom').value.trim(),
                prenoms: document.getElementById('prenoms').value.trim(),
                email: document.getElementById('email').value.trim(),
                phone: document.getElementById('phone').value.trim(),
                notes: document.getElementById('notes').value.trim(),
                appart_uuid: @json($appart->uuid)
            };

            return true;
        }

        if (currentStep === 2) {
            // Validation du paiement
            if (!selectedPaymentMethod) {
                Swal.fire({
                    icon: 'error',
                    title: 'Mode de paiement requis',
                    text: 'Veuillez sélectionner un mode de paiement'
                });
                return false;
            }

            const cardNumber = document.getElementById('card-number').value.trim();
            const cardName = document.getElementById('card-name').value.trim();

            if (!cardNumber || !cardName) {
                Swal.fire({
                    icon: 'error',
                    title: 'Informations de paiement',
                    text: 'Veuillez remplir les informations de paiement'
                });
                return false;
            }

            reservationData.paymentMethod = selectedPaymentMethod.dataset.method;
            reservationData.cardNumber = cardNumber;
            reservationData.cardName = cardName;
            reservationData.expiry = document.getElementById('expiry-date').value.trim();
            reservationData.cvv = document.getElementById('cvv-code').value.trim();

            return true;
        }

        return true;
    }

    function updateStepDisplay() {
        // Mettre à jour le stepper
        document.querySelectorAll('.stepper-item').forEach((item, index) => {
            const stepCounter = item.querySelector('.step-counter');
            if (index < currentStep - 1) {
                item.classList.add('completed');
                item.classList.remove('active');
                stepCounter.classList.remove('bg-secondary');
                stepCounter.classList.add('bg-success');
            } else if (index === currentStep - 1) {
                item.classList.add('active');
                item.classList.remove('completed');
                stepCounter.classList.remove('bg-secondary');
                stepCounter.classList.add('bg-primary');
            } else {
                item.classList.remove('active', 'completed');
                stepCounter.classList.remove('bg-primary', 'bg-success');
                stepCounter.classList.add('bg-secondary');
            }
        });

        // Afficher/masquer le contenu des étapes
        document.querySelectorAll('.step-content').forEach((content, index) => {
            content.classList.toggle('active', index === currentStep - 1);
        });

        // Gérer les boutons de navigation
        document.getElementById('prev-btn').style.display = currentStep > 1 ? 'block' : 'none';
        document.getElementById('next-btn').style.display = currentStep < 3 ? 'block' : 'none';
        document.getElementById('pay-btn').style.display = currentStep === 2 ? 'block' : 'none';
        document.getElementById('close-btn').style.display = currentStep === 3 ? 'block' : 'none';

        // Faire défiler vers le haut de l'étape
        document.getElementById(`step${currentStep}`).scrollIntoView({
            behavior: 'smooth',
            block: 'start'
        });
    }

    function generateInvoice() {
        const isHourly = reservationData.isHourly;
        const invoiceHTML = `
            <div class="d-flex justify-content-between mb-2">
                <span>Client:</span>
                <span>${reservationData.prenoms} ${reservationData.nom}</span>
            </div>
            ${isHourly ? `
                <div class="d-flex justify-content-between mb-2">
                    <span>Date et heure:</span>
                    <span>${formatDate(reservationData.startDate)} à ${reservationData.startTime}</span>
                </div>
                <div class="d-flex justify-content-between mb-2">
                    <span>Durée:</span>
                    <span>${reservationData.hours} heure${reservationData.hours > 1 ? 's' : ''}</span>
                </div>
                <div class="d-flex justify-content-between mb-2">
                    <span>Type tarif:</span>
                    <span>${reservationData.customTarif ? 'Personnalisé' : 'Forfait'}</span>
                </div>
            ` : `
                <div class="d-flex justify-content-between mb-2">
                    <span>Période:</span>
                    <span>${formatDate(reservationData.startDate)} - ${formatDate(reservationData.endDate)}</span>
                </div>
                <div class="d-flex justify-content-between mb-2">
                    <span>Nombre de nuits:</span>
                    <span>${reservationData.days}</span>
                </div>
            `}
            <div class="d-flex justify-content-between mb-2">
                <span>${isHourly ? 'Prix horaire' : 'Prix journalier'}:</span>
                <span>${reservationData.unitPrice.toLocaleString('fr-FR')} XOF</span>
            </div>
            <div class="d-flex justify-content-between border-top pt-2 mb-2">
                <span>Sous-total:</span>
                <span>${reservationData.totalPrice.toLocaleString('fr-FR')} XOF</span>
            </div>
            <div class="d-flex justify-content-between mb-2">
                <span>Acompte (10%):</span>
                <span>${reservationData.paymentAmount.toLocaleString('fr-FR')} XOF</span>
            </div>
            <div class="d-flex justify-content-between border-top pt-2 fw-bold">
                <span>Total à payer:</span>
                <span>${reservationData.paymentAmount.toLocaleString('fr-FR')} XOF</span>
            </div>
        `;
        document.getElementById('invoice-details').innerHTML = invoiceHTML;
    }

    async function processPayment() {
        // Afficher le loader
        Swal.fire({
            title: 'Traitement du paiement',
            html: 'Veuillez patienter...',
            timerProgressBar: true,
            didOpen: () => {
                Swal.showLoading();
            },
            allowOutsideClick: false
        });

        try {
            // 1. Enregistrer la réservation
            const reservationResponse = await saveReservation();

            if (!reservationResponse.success) {
                throw new Error(reservationResponse.message || "Échec de la réservation");
            }

            // 2. Simuler le paiement
            await simulatePayment();

            // 3. Passer à l'étape suivante
            Swal.close();
            nextStep();

        } catch (error) {
            Swal.fire({
                icon: 'error',
                title: 'Erreur',
                text: error.message || 'Une erreur est survenue lors du traitement'
            });
        }
    }

    async function saveReservation() {
        // Préparer les données pour l'API
        const isHourly = reservationData.isHourly;
        
        const reservationPayload = {
            nom: reservationData.nom,
            prenoms: reservationData.prenoms,
            email: reservationData.email,
            phone: reservationData.phone,
            appart_uuid: reservationData.appart_uuid,
            start_time: isHourly ? 
                `${reservationData.startDate} ${reservationData.startTime}` : 
                reservationData.startDate,
            end_time: isHourly ? 
                calculateEndTime(reservationData.startDate, reservationData.startTime, reservationData.hours) : 
                reservationData.endDate,
            unit_price: reservationData.unitPrice,
            total_price: reservationData.totalPrice,
            payment_method: reservationData.paymentMethod,
            notes: reservationData.notes,
            is_hourly: isHourly,
            hours: isHourly ? reservationData.hours : null,
            days: !isHourly ? reservationData.days : null,
            custom_tarif: isHourly ? reservationData.customTarif : null
        };

        try {
            const response = await fetch('/api/reservation/store', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify(reservationPayload)
            });

            const data = await response.json();

            if (!response.ok) {
                throw new Error(data.message || "Erreur lors de l'enregistrement");
            }

            return data;

        } catch (error) {
            console.error('Erreur API:', error);
            throw error;
        }
    }

    function calculateEndTime(startDate, startTime, hours) {
        const [year, month, day] = startDate.split('-');
        const [hoursStart, minutes] = startTime.split(':');
        
        const startDateTime = new Date(year, month - 1, day, hoursStart, minutes);
        const endDateTime = new Date(startDateTime.getTime() + (hours * 60 * 60 * 1000));
        
        return endDateTime.toISOString();
    }

    function simulatePayment() {
        return new Promise((resolve) => {
            // Simuler un délai de traitement de paiement
            setTimeout(() => {
                resolve({
                    success: true,
                    transactionId: 'TRX-' + Math.floor(100000 + Math.random() * 900000)
                });
            }, 1500);
        });
    }

    function generateReceipt() {
        // Générer un numéro de réservation aléatoire
        const reservationNumber = 'RES-' + Math.floor(100000 + Math.random() * 900000);
        reservationData.reservationNumber = reservationNumber;
        reservationData.paymentDate = new Date().toLocaleDateString('fr-FR', {
            day: '2-digit',
            month: '2-digit',
            year: 'numeric',
            hour: '2-digit',
            minute: '2-digit'
        });

        document.getElementById('reservation-number').textContent = reservationNumber;
        document.getElementById('payment-date').textContent = reservationData.paymentDate;

        const isHourly = reservationData.isHourly;
        const receiptHTML = `
            <div class="d-flex justify-content-between mb-2">
                <span>Référence:</span>
                <span>${reservationNumber}</span>
            </div>
            <div class="d-flex justify-content-between mb-2">
                <span>Date paiement:</span>
                <span>${reservationData.paymentDate}</span>
            </div>
            <div class="d-flex justify-content-between mb-2">
                <span>Moyen de paiement:</span>
                <span>${getPaymentMethodName(reservationData.paymentMethod)}</span>
            </div>
            <div class="d-flex justify-content-between mb-2">
                <span>Montant payé:</span>
                <span>${reservationData.paymentAmount.toLocaleString('fr-FR')} XOF</span>
            </div>
            <div class="d-flex justify-content-between border-top pt-2 mb-2">
                <span>Statut:</span>
                <span class="badge bg-success">Payé</span>
            </div>
            <div class="mt-4 p-3 bg-light rounded">
                <h6 class="mb-2">Détails de la réservation</h6>
                <p class="mb-1">${reservationData.prenoms} ${reservationData.nom}</p>
                <p class="mb-1">${reservationData.email}</p>
                <p class="mb-1">${reservationData.phone}</p>
                <p class="mb-0 mt-2">
                    ${isHourly ? 
                        `Type: Réservation horaire<br>
                         Date: ${formatDate(reservationData.startDate)}<br>
                         Heure: ${reservationData.startTime}<br>
                         Durée: ${reservationData.hours} heure${reservationData.hours > 1 ? 's' : ''}<br>
                         Tarif: ${reservationData.customTarif ? 'Personnalisé' : 'Forfait'}` : 
                        `Type: Réservation journalière<br>
                         Période: ${formatDate(reservationData.startDate)} - ${formatDate(reservationData.endDate)}<br>
                         Nuits: ${reservationData.days}`}
                </p>
            </div>
        `;
        document.getElementById('final-receipt').innerHTML = receiptHTML;
    }

    function downloadReceipt() {
        try {
            const { jsPDF } = window.jspdf;
            const doc = new jsPDF();

            // En-tête
            doc.setFontSize(16);
            doc.text("Reçu de Réservation", 105, 15, { align: 'center' });
            
            // Informations de base
            doc.setFontSize(12);
            let yPosition = 40;
            
            doc.text(`Nom: ${reservationData.prenoms} ${reservationData.nom}`, 20, yPosition);
            yPosition += 10;
            doc.text(`Référence: ${reservationData.reservationNumber}`, 20, yPosition);
            yPosition += 10;
            doc.text(`Date: ${reservationData.paymentDate}`, 20, yPosition);
            yPosition += 10;
            doc.text(`Méthode de paiement: ${getPaymentMethodName(reservationData.paymentMethod)}`, 20, yPosition);
            yPosition += 10;
            doc.text(`Montant payé: ${reservationData.paymentAmount.toLocaleString('fr-FR')} XOF`, 20, yPosition);
            yPosition += 15;

            // Détails spécifiques
            if (reservationData.isHourly) {
                doc.text(`Type: Réservation horaire`, 20, yPosition);
                yPosition += 10;
                doc.text(`Date: ${formatDate(reservationData.startDate)}`, 20, yPosition);
                yPosition += 10;
                doc.text(`Heure: ${reservationData.startTime}`, 20, yPosition);
                yPosition += 10;
                doc.text(`Durée: ${reservationData.hours} heure${reservationData.hours > 1 ? 's' : ''}`, 20, yPosition);
                yPosition += 10;
                doc.text(`Tarif: ${reservationData.customTarif ? 'Personnalisé' : 'Forfait'}`, 20, yPosition);
            } else {
                doc.text(`Type: Réservation journalière`, 20, yPosition);
                yPosition += 10;
                doc.text(`Arrivée: ${formatDate(reservationData.startDate)}`, 20, yPosition);
                yPosition += 10;
                doc.text(`Départ: ${formatDate(reservationData.endDate)}`, 20, yPosition);
                yPosition += 10;
                doc.text(`Nuits: ${reservationData.days}`, 20, yPosition);
            }

            // Pied de page
            yPosition += 20;
            doc.setFontSize(10);
            doc.text("Merci pour votre réservation !", 105, yPosition, { align: 'center' });

            // Enregistrer le PDF
            doc.save(`recu_reservation_${reservationData.reservationNumber}.pdf`);

            Swal.fire({
                icon: 'success',
                title: 'Reçu téléchargé',
                text: 'Votre reçu a été généré avec succès',
                timer: 2000,
                showConfirmButton: false
            });
        } catch (error) {
            console.error("Erreur génération PDF:", error);
            Swal.fire({
                icon: 'error',
                title: 'Erreur',
                text: 'Impossible de générer le PDF. Veuillez prendre une capture d\'écran de cette page.'
            });
        }
    }

    function resetModal() {
        // Réinitialiser le formulaire
        document.querySelector('form').reset();
        document.getElementById('payment-form').classList.add('d-none');

        // Réinitialiser les étapes
        currentStep = 1;
        updateStepDisplay();

        // Réinitialiser les données
        reservationData = {};
        selectedPaymentMethod = null;

        // Désélectionner les méthodes de paiement
        document.querySelectorAll('.payment-method').forEach(m => m.classList.remove('active'));

        // Réinitialiser les dates
        initializeDates();
    }

    // Fonctions utilitaires
    function formatDate(dateString) {
        if (!dateString) return '';
        const options = { day: '2-digit', month: '2-digit', year: 'numeric' };
        return new Date(dateString).toLocaleDateString('fr-FR', options);
    }

    function getPaymentMethodName(method) {
        const methods = {
            'visa': 'Visa',
            'mastercard': 'Mastercard',
            'orange': 'Orange Money',
            'mtn': 'MTN Money'
        };
        return methods[method] || method;
    }
</script> --}}

<script>
    // Variables globales
const DAILY_RATE = @json($tarifByDay->price ?? 0);
const HOURLY_RATE = @json($tarifHeureSort->price ?? 0);
const MINIMUM_HOURS = 1;
let currentStep = 1;
let reservationData = {};
let selectedPaymentMethod = null;

// Initialisation
document.addEventListener('DOMContentLoaded', function () {
    initializeDates();
    setupEventListeners();
    updatePricePreview();
});

function initializeDates() {
    const today = new Date().toISOString().split('T')[0];
    document.getElementById('start_date_jour').min = today;
    document.getElementById('end_date_jour').min = today;
    document.getElementById('start_date_heure').min = today;

    const now = new Date();
    const defaultHour = now.getHours() + 1;
    document.getElementById('start_time_heure').value = `${defaultHour.toString().padStart(2, '0')}:00`;
}

function setupEventListeners() {
    document.querySelectorAll('input[name="sejour"]').forEach(radio => {
        radio.addEventListener('change', function () {
            const isHourly = this.value === 'heure';
            document.getElementById('bloc-jour').classList.toggle('d-none', isHourly);
            document.getElementById('bloc-heure').classList.toggle('d-none', !isHourly);
            updatePricePreview();
        });
    });

    document.querySelectorAll('input[name="tarif_by_sejour"]').forEach(radio => {
        radio.addEventListener('change', function () {
            const isCustom = this.value === 'custom';
            document.getElementById('custom-hours-block').classList.toggle('d-none', !isCustom);
            updatePricePreview();
        });
    });

    document.getElementById('custom_hours').addEventListener('input', updatePricePreview);
    document.getElementById('start_date_jour').addEventListener('change', updatePricePreview);
    document.getElementById('end_date_jour').addEventListener('change', updatePricePreview);
    document.getElementById('start_date_heure').addEventListener('change', updatePricePreview);
    document.getElementById('start_time_heure').addEventListener('change', updatePricePreview);

    document.querySelectorAll('.payment-method').forEach(method => {
        method.addEventListener('click', function () {
            selectPaymentMethod(this);
        });
    });

    document.getElementById('reservationModal').addEventListener('hidden.bs.modal', resetModal);
}

function updatePricePreview() {
    const isHourly = document.querySelector('input[name="sejour"]:checked')?.value === 'heure';
    isHourly ? updateHourlyPrice() : updateDailyPrice();
}

function updateHourlyPrice() {
    const custom = document.getElementById('tarifCustom').checked;
    let hours = 0, unitPrice = 0;

    if (custom) {
        hours = parseInt(document.getElementById('custom_hours').value) || 0;
        unitPrice = HOURLY_RATE;
    } else {
        const selected = document.querySelector('input[name="tarif_by_sejour"]:checked');
        if (selected && selected.value !== 'custom') {
            hours = parseInt(selected.dataset.hours);
            unitPrice = parseFloat(selected.value);
        }
    }

    const total = hours * unitPrice;
    document.getElementById('unit-price').textContent = unitPrice.toLocaleString('fr-FR') + ' XOF';
    document.getElementById('duration-value').textContent = hours + (hours > 1 ? ' heures' : ' heure');
    document.getElementById('total-amount').textContent = total.toLocaleString('fr-FR') + ' XOF';

    reservationData = {
        ...reservationData,
        isHourly: true,
        hours,
        unitPrice,
        totalPrice: total,
        paymentAmount: total * 0.1,
        startDate: document.getElementById('start_date_heure').value,
        startTime: document.getElementById('start_time_heure').value,
        customTarif: custom
    };
}

function updateDailyPrice() {
    const start = document.getElementById('start_date_jour').value;
    const end = document.getElementById('end_date_jour').value;

    if (!start || !end) return;

    const days = Math.ceil((new Date(end) - new Date(start)) / (1000 * 60 * 60 * 24));
    const total = days * DAILY_RATE;

    document.getElementById('unit-price').textContent = DAILY_RATE.toLocaleString('fr-FR') + ' XOF';
    document.getElementById('duration-value').textContent = days + (days > 1 ? ' jours' : ' jour');
    document.getElementById('total-amount').textContent = total.toLocaleString('fr-FR') + ' XOF';

    reservationData = {
        ...reservationData,
        isHourly: false,
        days,
        unitPrice: DAILY_RATE,
        totalPrice: total,
        paymentAmount: total * 0.1,
        startDate: start,
        endDate: end
    };
}

function selectPaymentMethod(method) {
    document.querySelectorAll('.payment-method').forEach(m => m.classList.remove('active'));
    method.classList.add('active');
    selectedPaymentMethod = method;
    document.getElementById('payment-form').classList.remove('d-none');
}

function nextStep() {
    if (!validateCurrentStep()) return;

    if (currentStep < 3) {
        currentStep++;
        updateStepDisplay();

        if (currentStep === 2) generateInvoice();
        if (currentStep === 3) generateReceipt();
    }
}

function previousStep() {
    if (currentStep > 1) {
        currentStep--;
        updateStepDisplay();
    }
}

function validateCurrentStep() {
    const policies = ['policy-privacy', 'policy-refund', 'policy-terms'];
    const allChecked = policies.every(id => document.getElementById(id).checked);

    if (!allChecked) {
        Swal.fire('⚠️', 'Veuillez accepter toutes les politiques', 'warning');
        return false;
    }

    if (currentStep === 1) {
        const fields = ['nom', 'prenoms', 'email', 'phone'];
        for (const field of fields) {
            if (!document.getElementById(field).value.trim()) {
                Swal.fire('❌', 'Tous les champs obligatoires doivent être remplis', 'error');
                return false;
            }
        }

        const isHourly = document.querySelector('input[name="sejour"]:checked')?.value === 'heure';
        if (isHourly) {
            const custom = document.getElementById('tarifCustom').checked;
            const hours = custom
                ? parseInt(document.getElementById('custom_hours').value)
                : parseInt(document.querySelector('input[name="tarif_by_sejour"]:checked')?.dataset.hours);

            if (!hours || hours < 1) {
                Swal.fire('❌', 'Veuillez sélectionner une durée valide', 'error');
                return false;
            }

            if (!document.getElementById('start_date_heure').value || !document.getElementById('start_time_heure').value) {
                Swal.fire('❌', 'Veuillez sélectionner une date et une heure', 'error');
                return false;
            }
        } else {
            const start = document.getElementById('start_date_jour').value;
            const end = document.getElementById('end_date_jour').value;

            if (!start || !end || new Date(end) <= new Date(start)) {
                Swal.fire('❌', 'Les dates doivent être valides', 'error');
                return false;
            }
        }

        reservationData = {
            ...reservationData,
            nom: document.getElementById('nom').value.trim(),
            prenoms: document.getElementById('prenoms').value.trim(),
            email: document.getElementById('email').value.trim(),
            phone: document.getElementById('phone').value.trim(),
            notes: document.getElementById('notes').value.trim(),
            appart_uuid: @json($appart->uuid)
        };
    }

    if (currentStep === 2) {
        if (!selectedPaymentMethod) {
            Swal.fire('❌', 'Veuillez sélectionner un mode de paiement', 'error');
            return false;
        }

        const cardNumber = document.getElementById('card-number').value.trim();
        const cardName = document.getElementById('card-name').value.trim();

        if (!cardNumber || !cardName) {
            Swal.fire('❌', 'Veuillez remplir les informations de paiement', 'error');
            return false;
        }

        reservationData.paymentMethod = selectedPaymentMethod.dataset.method;
        reservationData.cardNumber = cardNumber;
        reservationData.cardName = cardName;
        reservationData.expiry = document.getElementById('expiry-date').value.trim();
        reservationData.cvv = document.getElementById('cvv-code').value.trim();
    }

    return true;
}

function updateStepDisplay() {
    document.querySelectorAll('.stepper-item').forEach((item, index) => {
        const counter = item.querySelector('.step-counter');
        item.classList.toggle('active', index === currentStep - 1);
        item.classList.toggle('completed', index < currentStep - 1);
        counter.classList.toggle('bg-secondary', index >= currentStep);
        counter.classList.toggle('bg-success', index < currentStep - 1);
        counter.classList.toggle('bg-primary', index === currentStep - 1);
    });

    document.querySelectorAll('.step-content').forEach((content, index) => {
        content.classList.toggle('active', index === currentStep - 1);
    });

    document.getElementById('prev-btn').style.display = currentStep > 1 ? 'block' : 'none';
    document.getElementById('next-btn').style.display = currentStep < 3 ? 'block' : 'none';
    document.getElementById('pay-btn').style.display = currentStep === 2 ? 'block' : 'none';
    document.getElementById('close-btn').style.display = currentStep === 3 ? 'block' : 'none';
}

function generateInvoice() {
    const isHourly = reservationData.isHourly;
    const invoiceHTML = `
        <div class="d-flex justify-content-between mb-2"><span>Client:</span><span>${reservationData.prenoms} ${reservationData.nom}</span></div>
        ${isHourly ? `
            <div class="d-flex justify-content-between mb-2"><span>Date et heure:</span><span>${reservationData.startDate} à ${reservationData.startTime}</span></div>
            <div class="d-flex justify-content-between mb-2"><span>Durée:</span><span>${reservationData.hours} heure(s)</span></div>
            <div class="d-flex justify-content-between mb-2"><span>Type tarif:</span><span>${reservationData.customTarif ? 'Personnalisé' : 'Forfait'}</span></div>
        ` : `
            <div class="d-flex justify-content-between mb-2"><span>Période:</span><span>${reservationData.startDate} - ${reservationData.endDate}</span></div>
            <div class="d-flex justify-content-between mb-2"><span>Nuits:</span><span>${reservationData.days}</span></div>
        `}
        <div class="d-flex justify-content-between mb-2"><span>${isHourly ? 'Prix horaire' : 'Prix journalier'}:</span><span>${reservationData.unitPrice.toLocaleString('fr-FR')} XOF</span></div>
        <div class="d-flex justify-content-between border-top pt-2 mb-2"><span>Sous-total:</span><span>${reservationData.totalPrice.toLocaleString('fr-FR')} XOF</span></div>
        <div class="d-flex justify-content-between mb-2"><span>Acompte (10%):</span><span>${reservationData.paymentAmount.toLocaleString('fr-FR')} XOF</span></div>
        <div class="d-flex justify-content-between border-top pt-2 fw-bold"><span>Total à payer:</span><span>${reservationData.paymentAmount.toLocaleString('fr-FR')} XOF</span></div>
    `;
    document.getElementById('invoice-details').innerHTML = invoiceHTML;
}

async function processPayment() {
    Swal.fire({
        title: 'Traitement du paiement...',
        text: 'Veuillez patienter',
        allowOutsideClick: false,
        didOpen: () => Swal.showLoading()
    });

    try {
        const payload = {
            ...reservationData,
            start_time: reservationData.isHourly
                ? `${reservationData.startDate} ${reservationData.startTime}:00`
                : `${reservationData.startDate} 00:00:00`,
            end_time: reservationData.isHourly
                ? (() => {
                    const [y, m, d] = reservationData.startDate.split('-');
                    const [h, min] = reservationData.startTime.split(':');
                    const date = new Date(y, m - 1, d, h, min);
                    date.setHours(date.getHours() + reservationData.hours);
                    return date.toISOString().slice(0, 19).replace('T', ' ');
                })()
                : `${reservationData.endDate} 23:59:59`
        };

        const res = await fetch('/api/reservation/store', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify(payload)
        });

        const data = await res.json();

        if (!data.success) throw new Error(data.message || 'Erreur inconnue');

        reservationData.reservation = data.reservation;
        reservationData.pdfUrl = data.pdf_url;

        Swal.close();
        nextStep();

    } catch (err) {
        Swal.fire('❌ Erreur', err.message || 'Erreur serveur', 'error');
    }
}

function generateReceipt() {
    if (!reservationData.reservation) return;

    const r = reservationData.reservation;
    document.getElementById('reservation-number').textContent = r.code;
    document.getElementById('payment-date').textContent = new Date().toLocaleDateString('fr-FR');

    const receiptHTML = `
        <div class="d-flex justify-content-between mb-2"><span>Référence:</span><span>${r.code}</span></div>
        <div class="d-flex justify-content-between mb-2"><span>Date paiement:</span><span>${new Date().toLocaleString('fr-FR')}</span></div>
        <div class="d-flex justify-content-between mb-2"><span>Moyen de paiement:</span><span>${reservationData.paymentMethod}</span></div>
        <div class="d-flex justify-content-between mb-2"><span>Montant payé:</span><span>${r.payment_amount.toLocaleString('fr-FR')} XOF</span></div>
        <div class="d-flex justify-content-between border-top pt-2 mb-2"><span>Statut:</span><span class="badge bg-success">Payé</span></div>
        <div class="mt-3 p-3 bg-light rounded">
            <h6>Détails</h6>
            <p class="mb-1"><strong>${r.prenoms} ${r.nom}</strong></p>
            <p class="mb-1">${r.email}</p>
            <p class="mb-1">${r.phone}</p>
            <p class="mb-0 mt-2">
                ${r.sejour === 'Heure' ? `
                    Type: Réservation horaire<br>
                    Date: ${r.start_time.split(' ')[0]}<br>
                    Heure: ${r.start_time.split(' ')[1]}<br>
                    Durée: ${r.nbr_of_sejour} heure(s)
                ` : `
                    Type: Réservation journalière<br>
                    Arrivée: ${r.start_time}<br>
                    Départ: ${r.end_time}<br>
                    Nuits: ${r.nbr_of_sejour}
                `}
            </p>
        </div>
    `;
    document.getElementById('final-receipt').innerHTML = receiptHTML;
}

// function downloadReceipt() {
//     if (reservationData.reservation?.uuid) {
//         window.open(reservationData.pdfUrl, '_blank');
//     }
// }

function downloadReceipt() {
    if (reservationData.reservation?.uuid) {
        window.location.href = '/api/reservation/download-receipt/' + reservationData.reservation.uuid;
    }
}
// window.open(`/api/reservation/download/${reservationData.reservation.uuid}`, '_blank');

function resetModal() {
    currentStep = 1;
    reservationData = {};
    selectedPaymentMethod = null;
    document.querySelector('form')?.reset();
    document.querySelectorAll('.payment-method').forEach(m => m.classList.remove('active'));
    document.getElementById('payment-form').classList.add('d-none');
    updateStepDisplay();
    initializeDates();
}
</script>