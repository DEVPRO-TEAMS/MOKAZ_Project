@extends('layouts.main')
@section('content')
    <section class="flat-section pt-4 flat-property-detail">
        <div class="container border rounded shadow p-4">
            <div class="text-center mb-4">
                <div class="alert alert-success">
                    <i class="fas fa-check-circle fa-3x mb-3 text-success"></i>
                    <h4>Paiement réussi!</h4>
                    <p class="mb-0">Le paiement a été effectué avec successe. Merci de votre confiance.</p>
                </div>
            </div>
            @php
                $start = \Carbon\Carbon::parse($reservation->start_time);
                $end = \Carbon\Carbon::parse($reservation->end_time);
                $totalMinutes = $start->diffInMinutes($end);
                $limit = $start->copy()->addMinutes($totalMinutes * 0.06);
                $date_limit = $limit->format('d/m/Y à H:i');
            @endphp
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
    </section>
{{-- <div class="d-flex justify-content-between mb-2"><span>Moyen de paiement:</span><span>${r.payment_method ?? 'Non spécifié'}</span></div> --}}

    {{-- <script>
        document.addEventListener('DOMContentLoaded', function() {
            const reservationData = @json($reservation);
            console.log(reservationData);

            // Récupérer l'UUID en JS
            const reservationUuid = reservationData.uuid;

            function generateReceipt() {
                if (!reservationData) return;

                const r = reservationData;
                document.getElementById('reservation-number').textContent = r.code;
                document.getElementById('payment-date').textContent = new Date().toLocaleDateString('fr-FR');

                // Conversion en objets Date (compatibilité ISO)
                const start = new Date(r.start_time.replace(" ", "T"));
                const end = new Date(r.end_time.replace(" ", "T"));

                const receiptHTML = `
                    <div class="d-flex justify-content-between mb-2"><span>Référence:</span><span>${r.code}</span></div>
                    <div class="d-flex justify-content-between mb-2"><span>Date paiement:</span><span>${new Date().toLocaleString('fr-FR')}</span></div>
                    <div class="d-flex justify-content-between mb-2"><span>Moyen de paiement:</span><span>${r.payment_method ?? 'Non spécifié'}</span></div>
                    <div class="d-flex justify-content-between mb-2"><span>Montant payé:</span><span>${Number(r.payment_amount).toLocaleString('fr-FR')} XOF</span></div>
                    <div class="d-flex justify-content-between border-top pt-2 mb-2"><span>Statut:</span><span class="badge bg-success">Payé</span></div>
                    <div class="mt-3 p-3 bg-light rounded">
                        <h6>Détails</h6>
                        <p class="mb-1"><strong>${r.prenoms} ${r.nom}</strong></p>
                        <p class="mb-1">${r.email}</p>
                        <p class="mb-1">${r.phone}</p>
                        <p class="mb-0 mt-2">
                            ${r.sejour === 'Heure' ? `
                                    Type: Réservation horaire<br>
                                    Date: ${start.toLocaleDateString('fr-FR')}<br>
                                    Heure de début: ${start.toLocaleTimeString('fr-FR', {hour: '2-digit', minute:'2-digit'})}<br>
                                    Heure de fin: ${end.toLocaleTimeString('fr-FR', {hour: '2-digit', minute:'2-digit'})}<br>
                                    Durée: ${r.nbr_of_sejour} heure(s)
                                ` : `
                                    Type: Réservation journalière<br>
                                    Arrivée: ${start.toLocaleString('fr-FR', {day: '2-digit', month: '2-digit', year: 'numeric', hour: '2-digit', minute:'2-digit'})}<br>
                                    Départ: ${end.toLocaleString('fr-FR', {day: '2-digit', month: '2-digit', year: 'numeric', hour: '2-digit', minute:'2-digit'})}<br>
                                    Nuits: ${r.nbr_of_sejour}
                                `}
                        </p>
                    </div>
                `;
                document.getElementById('final-receipt').innerHTML = receiptHTML;
            }




            // Appeler la fonction dès que la page est chargée
            generateReceipt();

            // Fonction de téléchargement
            window.downloadReceipt = function() {
                if (reservationUuid) {
                    window.location.href = '/api/reservation/download-receipt/' + reservationUuid;
                } else {
                    alert("Réservation introuvable !");
                }
            }
        });
    </script> --}}

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const reservationData = @json($reservation);
            const dateLimit = @json($date_limit);

            const reservationUuid = reservationData.uuid;
            let receiptDownloaded = false; // flag de validation

            function generateReceipt() {
                if (!reservationData) return;

                const r = reservationData;
                document.getElementById('reservation-number').textContent = r.code;
                document.getElementById('payment-date').textContent = new Date().toLocaleDateString('fr-FR');

                const start = new Date(r.start_time.replace(" ", "T"));
                const end = new Date(r.end_time.replace(" ", "T"));

                const receiptHTML = `
            <div class="d-flex justify-content-between mb-2"><span>Référence:</span><span>${r.code}</span></div>
            <div class="d-flex justify-content-between mb-2"><span>Date paiement:</span><span>${new Date().toLocaleString('fr-FR')}</span></div>
            
            <div class="d-flex justify-content-between mb-2"><span>Montant payé:</span><span>${Number(r.payment_amount).toLocaleString('fr-FR')} XOF</span></div>
            <div class="d-flex justify-content-between border-top pt-2 mb-2"><span>Statut:</span><span class="badge bg-success">Payé</span></div>
            <div class="mt-3 p-3 bg-light rounded">
                <h6>Détails</h6>
                <p class="mb-1"><strong>${r.prenoms} ${r.nom}</strong></p>
                <p class="mb-1">${r.email}</p>
                <p class="mb-1">${r.phone}</p>
                <p class="mb-0 mt-2">
                    ${r.sejour === 'Heure' ? `
                            Type: Réservation horaire<br>
                            Date: ${start.toLocaleDateString('fr-FR')}<br>
                            Heure de début: ${start.toLocaleTimeString('fr-FR', {hour: '2-digit', minute:'2-digit'})}<br>
                            Heure de fin: ${end.toLocaleTimeString('fr-FR', {hour: '2-digit', minute:'2-digit'})}<br>
                            Durée: ${r.nbr_of_sejour} heure(s)
                        ` : `
                            Type: Réservation journalière<br>
                            Arrivée: ${start.toLocaleString('fr-FR', {day: '2-digit', month: '2-digit', year: 'numeric', hour: '2-digit', minute:'2-digit'})}<br>
                            Départ: ${end.toLocaleString('fr-FR', {day: '2-digit', month: '2-digit', year: 'numeric', hour: '2-digit', minute:'2-digit'})}<br>
                            Nuits: ${r.nbr_of_sejour}
                        `}
                </p>
                <p class="mb-1 text-danger">NB: Afin de garantir votre réservation, merci de vous présenter au plus tard le <strong>${dateLimit}</strong>. En cas de retard, votre reservation sera automatiquement annulée.</p>
            </div>
        `;
                document.getElementById('final-receipt').innerHTML = receiptHTML;
            }

            // Exécuter à l'ouverture
            generateReceipt();

            // Fonction de téléchargement
            window.downloadReceipt = function() {
                if (reservationUuid) {
                    receiptDownloaded = true; // ✅ Marquer comme téléchargé
                    window.location.href = '/api/reservation/download-receipt/' + reservationUuid;
                } else {
                    alert("Réservation introuvable !");
                }
            }

            // Bloquer la fermeture si le reçu n’est pas téléchargé
            window.addEventListener('beforeunload', function(e) {
                if (!receiptDownloaded) {
                    e.preventDefault();
                    e.returnValue = "Veuillez télécharger votre reçu avant de quitter la page.";
                    return "Veuillez télécharger votre reçu avant de quitter la page.";
                }
            });
        });
    </script>


    {{-- <script>
    document.addEventListener('DOMContentLoaded', function() {
            // Récupération des coordonnées depuis les variables Blade (Laravel)
            const latitude = @json($appart->property->latitude);
            const longitude = @json($appart->property->longitude);


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
</script> --}}
@endsection
