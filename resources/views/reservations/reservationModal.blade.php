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
                        <div class="step-counter bg-primary text-white">1</div>
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

                <!-- Étape 1: Informations Personnelles -->
                <div class="step-content active" id="step1">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="nom" class="form-label">
                                <i class="fas fa-user me-2"></i>Nom *
                            </label>
                            <input type="text" class="form-control form-control-lg" id="nom" placeholder="Dupont" required>
                        </div>
                        <div class="col-md-6">
                            <label for="prenoms" class="form-label">
                                <i class="fas fa-user me-2"></i>Prénoms *
                            </label>
                            <input type="text" class="form-control form-control-lg" id="prenoms" placeholder="Jean" required>
                        </div>
                        <div class="col-md-6">
                            <label for="email" class="form-label">
                                <i class="fas fa-envelope me-2"></i>Email *
                            </label>
                            <input type="email" class="form-control form-control-lg" id="email" placeholder="jean.dupont@example.com" required>
                        </div>
                        <div class="col-md-6">
                            <label for="phone" class="form-label">
                                <i class="fas fa-phone me-2"></i>Téléphone *
                            </label>
                            <input type="tel" class="form-control form-control-lg" id="phone" placeholder="0123456789" required>
                        </div>
                        <div class="col-md-6">
                            <label for="start_time" class="form-label">
                                <i class="fas fa-calendar-alt me-2"></i>Date d'arrivée *
                            </label>
                            <input type="date" class="form-control form-control-lg" id="start_time" required>
                        </div>
                        <div class="col-md-6">
                            <label for="end_time" class="form-label">
                                <i class="fas fa-calendar-alt me-2"></i>Date de départ *
                            </label>
                            <input type="date" class="form-control form-control-lg" id="end_time" required>
                        </div>
                        <div class="col-12">
                            <label for="notes" class="form-label">
                                <i class="fas fa-comment me-2"></i>Commentaires
                            </label>
                            <textarea class="form-control form-control-lg" id="notes" rows="3" placeholder="Demandes spéciales, préférences..."></textarea>
                        </div>
                    </div>

                    <div id="pricePreview" class="card bg-danger text-white mt-4 d-none">
                        <div class="card-body">
                            <h5 class="card-title"><i class="fas fa-calculator me-2"></i>Aperçu des prix</h5>
                            <div class="d-flex justify-content-between mb-2">
                                <span>Prix par jour:</span>
                                <span>150,000 XOF</span>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <span>Nombre de jours:</span>
                                <span id="daysCount">0</span>
                            </div>
                            <div class="d-flex justify-content-between border-top pt-2 fw-bold">
                                <span>Total:</span>
                                <span id="totalAmount">0 XOF</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Étape 2: Facture et Paiement -->
                <div class="step-content" id="step2">
                    <div class="row g-4">
                        <div class="col-lg-6">
                            <div class="card border-danger">
                                <div class="card-header bg-danger  text-white">
                                    <h5 class="mb-0 text-white"><i class="fas fa-file-invoice me-2"></i>Facture</h5>
                                </div>
                                <div class="card-body" id="invoiceDetails">
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

                                    <div id="paymentForm" class="mt-4 d-none">
                                        <div class="mb-3">
                                            <label for="cardNumber" class="form-label">Numéro de carte / Téléphone *</label>
                                            <input type="text" class="form-control" id="cardNumber" placeholder="1234 5678 9012 3456" required>
                                        </div>
                                        <div class="row g-2">
                                            <div class="col-md-6">
                                                <label for="expiry" class="form-label">Date d'expiration</label>
                                                <input type="text" class="form-control" id="expiry" placeholder="MM/YY">
                                            </div>
                                            <div class="col-md-6">
                                                <label for="cvv" class="form-label">CVV</label>
                                                <input type="text" class="form-control" id="cvv" placeholder="123" maxlength="3">
                                            </div>
                                        </div>
                                        <div class="mb-3 mt-2">
                                            <label for="cardName" class="form-label">Nom sur la carte *</label>
                                            <input type="text" class="form-control" id="cardName" placeholder="JEAN DUPONT" required>
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
                                <p class="text-muted mb-1">Numéro de réservation: <strong id="reservationNumber"></strong></p>
                                <p class="text-muted">Date: <strong id="paymentDate"></strong></p>
                            </div>
                            <div id="finalReceipt">
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
                            <input class="form-check-input" type="checkbox" id="policyPrivacy" required>
                            <label class="form-check-label" for="policyPrivacy">
                                <strong>Politique de confidentialité:</strong> J'accepte que mes données personnelles soient collectées et traitées conformément à la politique de confidentialité
                            </label>
                        </div>
                        <div class="form-check mb-3">
                            <input class="form-check-input" type="checkbox" id="policyRefund" required>
                            <label class="form-check-label" for="policyRefund">
                                <strong>Politique de remboursement:</strong> J'ai lu et j'accepte les conditions de remboursement (remboursement intégral jusqu'à 48h avant l'arrivée)
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="policyTerms" required>
                            <label class="form-check-label" for="policyTerms">
                                <strong>Conditions générales:</strong> J'accepte les conditions générales d'utilisation et de séjour
                            </label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" id="prevBtn" onclick="previousStep()" style="display: none;">
                    <i class="fas fa-arrow-left me-2"></i>Précédent
                </button>
                <button type="button" class="btn btn-primary" id="nextBtn" onclick="nextStep()">
                    Suivant <i class="fas fa-arrow-right ms-2"></i>
                </button>
                <button type="button" class="btn btn-success" id="payBtn" onclick="processPayment()" style="display: none;">
                    <i class="fas fa-credit-card me-2"></i>Payer maintenant
                </button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" id="closeBtn" style="display: none;">
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
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }

    /* Payment Method Active State */
    .payment-method.active {
        background-color: rgba(13, 110, 253, 0.1);
        border-color: var(--bs-primary) !important;
        color: var(--bs-primary);
    }
</style>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.5.3/jspdf.debug.js"></script>
{{-- <script>
    // Variables globales
    const DAILY_RATE = 150000;
    let currentStep = 1;
    let reservationData = {};
    let selectedPaymentMethod = null;

    // Initialisation
    document.addEventListener('DOMContentLoaded', function() {
        initializeDates();
        setupEventListeners();
    });

    function initializeDates() {
        const today = new Date().toISOString().split('T')[0];
        document.getElementById('start_time').min = today;
        document.getElementById('end_time').min = today;
    }

    function setupEventListeners() {
        // Écouteurs pour les dates
        document.getElementById('start_time').addEventListener('change', function() {
            const endDateInput = document.getElementById('end_time');
            if (this.value) {
                endDateInput.min = this.value;
                calculatePrice();
            }
        });

        document.getElementById('end_time').addEventListener('change', function() {
            const startDate = new Date(document.getElementById('start_time').value);
            const endDate = new Date(this.value);

            if (endDate <= startDate) {
                Swal.fire({
                    icon: 'error',
                    title: 'Erreur de date',
                    text: 'La date de départ doit être postérieure à la date d\'arrivée'
                });
                this.value = '';
                return;
            }
            calculatePrice();
        });

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

    function calculatePrice() {
        const startDate = document.getElementById('start_time').value;
        const endDate = document.getElementById('end_time').value;

        if (!startDate || !endDate) return;

        const start = new Date(startDate);
        const end = new Date(endDate);
        const days = Math.ceil((end - start) / (1000 * 60 * 60 * 24));

        if (days > 0) {
            const total = days * DAILY_RATE;
            const paymentAmount = total * 0.1; // 10% d'acompte

            document.getElementById('daysCount').textContent = days;
            document.getElementById('totalAmount').textContent = total.toLocaleString('fr-FR') + ' XOF';
            document.getElementById('pricePreview').classList.remove('d-none');

            // Stocker les données
            reservationData.days = days;
            reservationData.totalPrice = total;
            reservationData.paymentAmount = paymentAmount;
        }
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
        const policiesChecked = document.querySelectorAll('#policyPrivacy:checked, #policyRefund:checked, #policyTerms:checked').length === 3;

        if (!policiesChecked) {
            Swal.fire({
                icon: 'warning',
                title: 'Politiques requises',
                text: 'Vous devez accepter toutes les politiques pour continuer'
            });
            return false;
        }

        if (currentStep === 1) {
            // Validation étape 1
            const requiredFields = ['nom', 'prenoms', 'email', 'phone', 'start_time', 'end_time'];
            const emptyFields = requiredFields.filter(field => !document.getElementById(field).value.trim());

            if (emptyFields.length > 0) {
                Swal.fire({
                    icon: 'error',
                    title: 'Champs requis',
                    text: 'Veuillez remplir tous les champs obligatoires'
                });
                return false;
            }

            if (!reservationData.days || reservationData.days <= 0) {
                Swal.fire({
                    icon: 'error',
                    title: 'Dates invalides',
                    text: 'Veuillez sélectionner des dates valides'
                });
                return false;
            }

            // Stocker les données
            reservationData = {
                ...reservationData,
                nom: document.getElementById('nom').value.trim(),
                prenoms: document.getElementById('prenoms').value.trim(),
                email: document.getElementById('email').value.trim(),
                phone: document.getElementById('phone').value.trim(),
                startDate: document.getElementById('start_time').value,
                endDate: document.getElementById('end_time').value,
                notes: document.getElementById('notes').value.trim()
            };

            return true;
        }

        if (currentStep === 2) {
            // Validation étape 2
            if (!selectedPaymentMethod) {
                Swal.fire({
                    icon: 'error',
                    title: 'Mode de paiement requis',
                    text: 'Veuillez sélectionner un mode de paiement'
                });
                return false;
            }

            const cardNumber = document.getElementById('cardNumber').value.trim();
            const cardName = document.getElementById('cardName').value.trim();

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
            reservationData.expiry = document.getElementById('expiry').value.trim();
            reservationData.cvv = document.getElementById('cvv').value.trim();

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
        document.getElementById('prevBtn').style.display = currentStep > 1 ? 'block' : 'none';
        document.getElementById('nextBtn').style.display = currentStep < 3 ? 'block' : 'none';
        document.getElementById('payBtn').style.display = currentStep === 2 ? 'block' : 'none';
        document.getElementById('closeBtn').style.display = currentStep === 3 ? 'block' : 'none';

        // Faire défiler vers le haut de l'étape
        document.getElementById(`step${currentStep}`).scrollIntoView({ behavior: 'smooth', block: 'start' });
    }

    function selectPaymentMethod(method) {
        document.querySelectorAll('.payment-method').forEach(m => m.classList.remove('active'));
        method.classList.add('active');
        selectedPaymentMethod = method;
        
        // Afficher le formulaire de paiement
        document.getElementById('paymentForm').classList.remove('d-none');
    }

    function generateInvoice() {
        const invoiceHTML = `
            <div class="d-flex justify-content-between mb-2">
                <span>Client:</span>
                <span>${reservationData.prenoms} ${reservationData.nom}</span>
            </div>
            <div class="d-flex justify-content-between mb-2">
                <span>Période:</span>
                <span>${formatDate(reservationData.startDate)} - ${formatDate(reservationData.endDate)}</span>
            </div>
            <div class="d-flex justify-content-between mb-2">
                <span>Durée:</span>
                <span>${reservationData.days} jours</span>
            </div>
            <div class="d-flex justify-content-between mb-2">
                <span>Prix journalier:</span>
                <span>${DAILY_RATE.toLocaleString('fr-FR')} XOF</span>
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
        document.getElementById('invoiceDetails').innerHTML = invoiceHTML;
    }

    function processPayment() {
        // Simulation de traitement de paiement
        Swal.fire({
            title: 'Traitement du paiement',
            html: 'Veuillez patienter...',
            timerProgressBar: true,
            didOpen: () => {
                Swal.showLoading();
                // Simuler un délai de traitement
                setTimeout(() => {
                    Swal.close();
                    nextStep();
                }, 2000);
            }
        });
    }

    function generateReceipt() {
        // Générer un numéro de réservation aléatoire
        const reservationNumber = 'RES-' + Math.floor(100000 + Math.random() * 900000);
        reservationData.reservationNumber = reservationNumber;
        reservationData.paymentDate = new Date().toLocaleDateString('fr-FR');
        
        document.getElementById('reservationNumber').textContent = reservationNumber;
        document.getElementById('paymentDate').textContent = reservationData.paymentDate;

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
                <p class="mb-0 mt-2">Période: ${formatDate(reservationData.startDate)} - ${formatDate(reservationData.endDate)}</p>
            </div>
        `;
        document.getElementById('finalReceipt').innerHTML = receiptHTML;
    }


    
    function downloadReceipt() {
        const doc = new jsPDF();

        const reservationData = {
            nom: "Jean Dupont",
            date: "13/07/2025",
            montant: "25.000 FCFA",
            référence: "RES12345"
        };

        doc.setFontSize(16);
        doc.text("Reçu de Réservation", 20, 20);

        doc.setFontSize(12);
        doc.text(`Nom : ${reservationData.nom}`, 20, 40);
        doc.text(`Date : ${reservationData.date}`, 20, 50);
        doc.text(`Montant : ${reservationData.montant}`, 20, 60);
        doc.text(`Référence : ${reservationData.référence}`, 20, 70);

        doc.save("recu_reservation.pdf");

        Swal.fire({
            icon: 'success',
            title: 'Téléchargement du reçu',
            text: 'Votre reçu a été généré avec succès',
            timer: 2000,
            showConfirmButton: false
        });
    }


    function resetModal() {
        // Réinitialiser le formulaire
        document.getElementById('reservationForm').reset();
        document.getElementById('pricePreview').classList.add('d-none');
        document.getElementById('paymentForm').classList.add('d-none');
        
        // Réinitialiser les étapes
        currentStep = 1;
        updateStepDisplay();
        
        // Réinitialiser les données
        reservationData = {};
        selectedPaymentMethod = null;
        
        // Désélectionner les méthodes de paiement
        document.querySelectorAll('.payment-method').forEach(m => m.classList.remove('active'));
    }

    // Fonctions utilitaires
    function formatDate(dateString) {
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
    const DAILY_RATE = 150000;
    let currentStep = 1;
    let reservationData = {};
    let selectedPaymentMethod = null;

    // Initialisation
    document.addEventListener('DOMContentLoaded', function() {
        initializeDates();
        setupEventListeners();
    });

    function initializeDates() {
        const today = new Date().toISOString().split('T')[0];
        document.getElementById('start_time').min = today;
        document.getElementById('end_time').min = today;
    }

    function setupEventListeners() {
        // Écouteurs pour les dates
        document.getElementById('start_time').addEventListener('change', function() {
            const endDateInput = document.getElementById('end_time');
            if (this.value) {
                endDateInput.min = this.value;
                calculatePrice();
            }
        });

        document.getElementById('end_time').addEventListener('change', function() {
            const startDate = new Date(document.getElementById('start_time').value);
            const endDate = new Date(this.value);

            if (endDate <= startDate) {
                Swal.fire({
                    icon: 'error',
                    title: 'Erreur de date',
                    text: 'La date de départ doit être postérieure à la date d\'arrivée'
                });
                this.value = '';
                return;
            }
            calculatePrice();
        });

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

    function calculatePrice() {
        const startDate = document.getElementById('start_time').value;
        const endDate = document.getElementById('end_time').value;

        if (!startDate || !endDate) return;

        const start = new Date(startDate);
        const end = new Date(endDate);
        const days = Math.ceil((end - start) / (1000 * 60 * 60 * 24));

        if (days > 0) {
            const total = days * DAILY_RATE;
            const paymentAmount = total * 0.1; // 10% d'acompte

            document.getElementById('daysCount').textContent = days;
            document.getElementById('totalAmount').textContent = total.toLocaleString('fr-FR') + ' XOF';
            document.getElementById('pricePreview').classList.remove('d-none');

            // Stocker les données
            reservationData.days = days;
            reservationData.totalPrice = total;
            reservationData.paymentAmount = paymentAmount;
            reservationData.unit_price = DAILY_RATE;
        }
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
        const policiesChecked = document.querySelectorAll('#policyPrivacy:checked, #policyRefund:checked, #policyTerms:checked').length === 3;

        if (!policiesChecked) {
            Swal.fire({
                icon: 'warning',
                title: 'Politiques requises',
                text: 'Vous devez accepter toutes les politiques pour continuer'
            });
            return false;
        }

        if (currentStep === 1) {
            // Validation étape 1
            const requiredFields = ['nom', 'prenoms', 'email', 'phone', 'start_time', 'end_time'];
            const emptyFields = requiredFields.filter(field => !document.getElementById(field).value.trim());

            if (emptyFields.length > 0) {
                Swal.fire({
                    icon: 'error',
                    title: 'Champs requis',
                    text: 'Veuillez remplir tous les champs obligatoires'
                });
                return false;
            }

            if (!reservationData.days || reservationData.days <= 0) {
                Swal.fire({
                    icon: 'error',
                    title: 'Dates invalides',
                    text: 'Veuillez sélectionner des dates valides'
                });
                return false;
            }

            // Stocker les données
            reservationData = {
                ...reservationData,
                nom: document.getElementById('nom').value.trim(),
                prenoms: document.getElementById('prenoms').value.trim(),
                email: document.getElementById('email').value.trim(),
                phone: document.getElementById('phone').value.trim(),
                start_time: document.getElementById('start_time').value,
                end_time: document.getElementById('end_time').value,
                notes: document.getElementById('notes').value.trim(),
                // Ajouter l'ID de la chambre (à définir selon votre logique)
                room_id: 1 // Remplacez par l'ID réel de la chambre
            };

            return true;
        }

        if (currentStep === 2) {
            // Validation étape 2
            if (!selectedPaymentMethod) {
                Swal.fire({
                    icon: 'error',
                    title: 'Mode de paiement requis',
                    text: 'Veuillez sélectionner un mode de paiement'
                });
                return false;
            }

            const cardNumber = document.getElementById('cardNumber').value.trim();
            const cardName = document.getElementById('cardName').value.trim();

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
            reservationData.expiry = document.getElementById('expiry').value.trim();
            reservationData.cvv = document.getElementById('cvv').value.trim();

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
        document.getElementById('prevBtn').style.display = currentStep > 1 ? 'block' : 'none';
        document.getElementById('nextBtn').style.display = currentStep < 3 ? 'block' : 'none';
        document.getElementById('payBtn').style.display = currentStep === 2 ? 'block' : 'none';
        document.getElementById('closeBtn').style.display = currentStep === 3 ? 'block' : 'none';

        // Faire défiler vers le haut de l'étape
        document.getElementById(`step${currentStep}`).scrollIntoView({ behavior: 'smooth', block: 'start' });
    }

    function selectPaymentMethod(method) {
        document.querySelectorAll('.payment-method').forEach(m => m.classList.remove('active'));
        method.classList.add('active');
        selectedPaymentMethod = method;
        
        // Afficher le formulaire de paiement
        document.getElementById('paymentForm').classList.remove('d-none');
    }

    function generateInvoice() {
        const invoiceHTML = `
            <div class="d-flex justify-content-between mb-2">
                <span>Client:</span>
                <span>${reservationData.prenoms} ${reservationData.nom}</span>
            </div>
            <div class="d-flex justify-content-between mb-2">
                <span>Période:</span>
                <span>${formatDate(reservationData.start_time)} - ${formatDate(reservationData.end_time)}</span>
            </div>
            <div class="d-flex justify-content-between mb-2">
                <span>Durée:</span>
                <span>${reservationData.days} jours</span>
            </div>
            <div class="d-flex justify-content-between mb-2">
                <span>Prix journalier:</span>
                <span>${DAILY_RATE.toLocaleString('fr-FR')} XOF</span>
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
        document.getElementById('invoiceDetails').innerHTML = invoiceHTML;
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
        const reservationPayload = {
            nom: reservationData.nom,
            prenoms: reservationData.prenoms,
            email: reservationData.email,
            phone: reservationData.phone,
            room_id: reservationData.room_id,
            start_time: reservationData.start_time,
            end_time: reservationData.end_time,
            unit_price: reservationData.unit_price,
            total_price: reservationData.totalPrice,
            payment_method: reservationData.paymentMethod,
            notes: reservationData.notes
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
        reservationData.paymentDate = new Date().toLocaleDateString('fr-FR');
        
        document.getElementById('reservationNumber').textContent = reservationNumber;
        document.getElementById('paymentDate').textContent = reservationData.paymentDate;

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
                <p class="mb-0 mt-2">Période: ${formatDate(reservationData.start_time)} - ${formatDate(reservationData.end_time)}</p>
            </div>
        `;
        document.getElementById('finalReceipt').innerHTML = receiptHTML;
    }

    function downloadReceipt() {
        const doc = new jsPDF();

        doc.setFontSize(16);
        doc.text("Reçu de Réservation", 20, 20);

        doc.setFontSize(12);
        doc.text(`Nom : ${reservationData.prenoms} ${reservationData.nom}`, 20, 40);
        doc.text(`Date : ${reservationData.paymentDate}`, 20, 50);
        doc.text(`Montant : ${reservationData.paymentAmount.toLocaleString('fr-FR')} XOF`, 20, 60);
        doc.text(`Référence : ${reservationData.reservationNumber}`, 20, 70);
        doc.text(`Méthode de paiement : ${getPaymentMethodName(reservationData.paymentMethod)}`, 20, 80);
        doc.text(`Période : ${formatDate(reservationData.start_time)} - ${formatDate(reservationData.end_time)}`, 20, 90);

        doc.save(`recu_reservation_${reservationData.reservationNumber}.pdf`);

        Swal.fire({
            icon: 'success',
            title: 'Téléchargement du reçu',
            text: 'Votre reçu a été généré avec succès',
            timer: 2000,
            showConfirmButton: false
        });
    }

    function resetModal() {
        // Réinitialiser le formulaire
        document.getElementById('reservationForm').reset();
        document.getElementById('pricePreview').classList.add('d-none');
        document.getElementById('paymentForm').classList.add('d-none');
        
        // Réinitialiser les étapes
        currentStep = 1;
        updateStepDisplay();
        
        // Réinitialiser les données
        reservationData = {};
        selectedPaymentMethod = null;
        
        // Désélectionner les méthodes de paiement
        document.querySelectorAll('.payment-method').forEach(m => m.classList.remove('active'));
    }

    // Fonctions utilitaires
    function formatDate(dateString) {
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
</script>

