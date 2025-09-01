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

            {{-- <div class="single-property-element single-property-map">
                <div class="h7 title fw-7">Itinéraire</div>
                <div id="map-location-property-intinerary" class="map-single" data-map-zoom="16" data-map-scroll="true"
                    style="height:400px;">
                </div>

                <!-- Infos itinéraire -->
                <ul class="info-map mt-3">
                    <li>
                        <div class="fw-7">Adresse</div>
                        <span class="mt-4 text-variant-1">{{ $reservation->property->address }}</span>
                    </li>
                    <li>
                        <div class="fw-7">Distance</div>
                        <span class="mt-4 text-variant-1">Calcul en cours...</span>
                    </li>
                    <li>
                        <div class="fw-7">En Véhicule</div>
                        <span class="mt-4 text-variant-1">Calcul en cours...</span>
                    </li>
                    <li>
                        <div class="fw-7">À pied</div>
                        <span class="mt-4 text-variant-1">Calcul en cours...</span>
                    </li>
                </ul>

                <!-- Boutons de mode de transport -->
                <div class="mt-3">
                    <button class="btn btn-sm btn-outline-primary" onclick="changeMode('driving')">🚗 Véhicule</button>
                    <button class="btn btn-sm btn-outline-success" onclick="changeMode('foot')">🚶 À pied</button>
                    <button class="btn btn-sm btn-outline-warning" onclick="changeMode('bike')">🚴 Vélo</button>
                    <a id="googleMapsBtn" target="_blank" class="btn btn-sm btn-outline-danger">📍 Ouvrir dans Google
                        Maps</a>
                </div>
            </div> --}}

            <div class="single-property-element single-property-map">
                <div class="h7 title fw-7">Itinéraire</div>
                <div id="map-location-property-intinerary" class="map-single"
                    style="height:450px; border-radius:15px; overflow:hidden;"></div>

                <!-- Infos itinéraire -->
                <ul class="info-map mt-3 list-unstyled">
                    <li>
                        <div class="fw-7">📍 Adresse</div>
                        <span class="badge bg-light text-dark mt-2">{{ $reservation->property->address }}</span>
                    </li>
                    <li>
                        <div class="fw-7">📏 Distance</div>
                        <span class="badge bg-primary mt-2">Calcul en cours...</span>
                    </li>
                    <li>
                        <div class="fw-7">🚗 En Véhicule</div>
                        <span class="badge bg-success mt-2">Calcul en cours...</span>
                    </li>
                    <li>
                        <div class="fw-7">🚶 À pied</div>
                        <span class="badge bg-warning mt-2">Calcul en cours...</span>
                    </li>
                </ul>

                <!-- Boutons de mode de transport -->
                <div class="mt-3 d-flex gap-2 flex-wrap">
                    <button class="btn btn-sm btn-outline-primary" onclick="changeMode('driving')">🚗 Véhicule</button>
                    <button class="btn btn-sm btn-outline-success" onclick="changeMode('foot')">🚶 À pied</button>
                    <button class="btn btn-sm btn-outline-warning" onclick="changeMode('bike')">🚴 Vélo</button>
                    <a id="googleMapsBtn" target="_blank" class="btn btn-sm btn-outline-danger">📍 Google Maps</a>
                </div>
            </div>
        </div>

    </section>

    {{-- <script>
        document.addEventListener('DOMContentLoaded', function() {
            const latitude = @json($reservation->property->latitude);
            const longitude = @json($reservation->property->longitude);

            // Fonds de carte modernes
            const baseMaps = {
                "Clair": L.tileLayer('https://{s}.basemaps.cartocdn.com/light_all/{z}/{x}/{y}{r}.png', {
                    attribution: '&copy; <a href="https://www.openstreetmap.org/">OSM</a> &copy; <a href="https://carto.com/">CARTO</a>'
                }),
                "Sombre": L.tileLayer('https://{s}.basemaps.cartocdn.com/dark_all/{z}/{x}/{y}{r}.png', {
                    attribution: '&copy; OSM &copy; CARTO'
                }),
                "Classique": L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    attribution: '&copy; OpenStreetMap'
                })
            };

            // Initialisation de la carte
            const map = L.map('map-location-property-intinerary', {
                center: [latitude, longitude],
                zoom: 15,
                layers: [baseMaps["Classique"]]
            });

            // Contrôle pour changer de fond
            L.control.layers(baseMaps).addTo(map);

            // Icônes personnalisées
            const propertyIcon = L.icon({
                iconUrl: "{{ asset('assets/images/location/map-icon.png') }}", // maison
                iconSize: [32, 32],
                iconAnchor: [16, 32],
                popupAnchor: [0, -32]
            });

            const userIcon = L.icon({
                iconUrl: "https://cdn-icons-png.flaticon.com/512/64/64113.png", // point bleu
                iconSize: [28, 28],
                iconAnchor: [14, 28],
                popupAnchor: [0, -28]
            });

            // Marqueur de la propriété
            const propertyMarker = L.marker([latitude, longitude], {
                    icon: propertyIcon
                }).addTo(map)
                .bindPopup("🏠 Emplacement de la propriété")
                .openPopup();

            let userMarker, control;
            let currentMode = "driving"; // OSRM gère que "driving"

            // Fonction mise à jour itinéraire
            function updateRoute(userLat, userLng) {
                if (control) map.removeControl(control);

                control = L.Routing.control({
                    waypoints: [L.latLng(userLat, userLng), L.latLng(latitude, longitude)],
                    router: L.Routing.osrmv1({
                        serviceUrl: 'https://router.project-osrm.org/route/v1'
                    }),
                    lineOptions: {
                        styles: [{
                            color: 'red',
                            weight: 5,
                            opacity: 0.8
                        }]
                    },
                    show: false,
                    addWaypoints: false
                }).addTo(map);

                control.on('routesfound', function(e) {
                    const route = e.routes[0];
                    const distanceKm = (route.summary.totalDistance / 1000).toFixed(2);
                    const durationMin = Math.round(route.summary.totalTime / 60);

                    // Mise à jour infos
                    document.querySelector('.info-map li:nth-child(2) span').innerText = distanceKm + " km";
                    document.querySelector('.info-map li:nth-child(3) span').innerText = durationMin +
                        " min en véhicule";
                    document.querySelector('.info-map li:nth-child(4) span').innerText =
                        Math.round(distanceKm * 12) + " min à pied"; // approx

                    // Lien Google Maps
                    document.getElementById('googleMapsBtn').href =
                        `https://www.google.com/maps/dir/?api=1&origin=${userLat},${userLng}&destination=${latitude},${longitude}&travelmode=${currentMode}`;
                });
            }
            // Bouton recentrer
            L.control.locate({
                position: 'topleft',
                strings: {
                    title: "Recentrer sur ma position"
                },
                flyTo: true,
                keepCurrentZoomLevel: false
            }).addTo(map);

            

            // Suivi position utilisateur
            if (navigator.geolocation) {
                navigator.geolocation.watchPosition(position => {
                    const userLat = position.coords.latitude;
                    const userLng = position.coords.longitude;

                    if (!userMarker) {
                        userMarker = L.marker([userLat, userLng], {
                                icon: userIcon
                            }).addTo(map)
                            .bindPopup("📍 Votre position")
                            .openPopup();
                    } else {
                        userMarker.setLatLng([userLat, userLng]); // mise à jour fluide
                    }

                    updateRoute(userLat, userLng);

                }, () => {
                    alert("Impossible de récupérer votre position GPS.");
                }, {
                    enableHighAccuracy: true
                });
            }
        });
    </script> --}}

    <script>
document.addEventListener('DOMContentLoaded', function() {
    const latitude = @json($reservation->property->latitude);
    const longitude = @json($reservation->property->longitude);

    // Fonds de carte
    const baseMaps = {
        "Clair": L.tileLayer('https://{s}.basemaps.cartocdn.com/light_all/{z}/{x}/{y}{r}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/">OSM</a> &copy; <a href="https://carto.com/">CARTO</a>'
        }),
        "Sombre": L.tileLayer('https://{s}.basemaps.cartocdn.com/dark_all/{z}/{x}/{y}{r}.png', {
            attribution: '&copy; OSM &copy; CARTO'
        }),
        "Classique": L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; OpenStreetMap'
        })
    };

    // Initialisation de la carte
    const map = L.map('map-location-property-intinerary', {
        center: [latitude, longitude],
        zoom: 15,
        layers: [baseMaps["Classique"]]
    });

    // Contrôle pour changer de fond
    L.control.layers(baseMaps).addTo(map);

    // Icônes personnalisées
    const propertyIcon = L.icon({
        iconUrl: "{{ asset('assets/images/location/map-icon.png') }}",
        iconSize: [32, 32],
        iconAnchor: [16, 32],
        popupAnchor: [0, -32]
    });

    const customUserIcon = L.icon({
        iconUrl: "https://cdn-icons-png.flaticon.com/512/64/64113.png", // ton icône perso
        iconSize: [32, 32],
        iconAnchor: [16, 32],
        popupAnchor: [0, -32]
    });

    // Marqueur de la propriété
    const propertyMarker = L.marker([latitude, longitude], { icon: propertyIcon })
        .addTo(map)
        // .bindPopup("🏠 Emplacement de la propriété")
        // .openPopup();

    let userMarker, control;
    let currentMode = "driving";

    // Fonction mise à jour itinéraire
    function updateRoute(userLat, userLng) {
        if (control) map.removeControl(control);
        control = L.Routing.control({
            waypoints: [L.latLng(userLat, userLng), L.latLng(latitude, longitude)],
            router: L.Routing.osrmv1({ serviceUrl: 'https://router.project-osrm.org/route/v1' }),
            lineOptions: { styles: [{ color: 'red', weight: 5, opacity: 0.8 }] },
            show: false,
            addWaypoints: false
        }).addTo(map);

        control.on('routesfound', function(e) {
            const route = e.routes[0];
            const distanceKm = (route.summary.totalDistance / 1000).toFixed(2);
            const durationMin = Math.round(route.summary.totalTime / 60);

            document.querySelector('.info-map li:nth-child(2) span').innerText = distanceKm + " km";
            document.querySelector('.info-map li:nth-child(3) span').innerText = durationMin + " min en véhicule";
            document.querySelector('.info-map li:nth-child(4) span').innerText = Math.round(distanceKm * 12) + " min à pied";

            // Lien Google Maps
            document.getElementById('googleMapsBtn').href =
                `https://www.google.com/maps/dir/?api=1&origin=${userLat},${userLng}&destination=${latitude},${longitude}&travelmode=${currentMode}`;
        });
    }

    // Bouton recentrer
    L.control.locate({
        position: 'topleft',
        strings: { title: "Recentrer sur ma position" },
        flyTo: true,
        keepCurrentZoomLevel: false
    }).addTo(map);

    // Suivi position utilisateur
    if (navigator.geolocation) {
        navigator.geolocation.watchPosition(position => {
            const userLat = position.coords.latitude;
            const userLng = position.coords.longitude;

            if (!userMarker) {
                userMarker = L.marker([userLat, userLng], { icon: customUserIcon }) // ici ton icône perso
                    .addTo(map)
                    .bindPopup("📍 Votre position")
                    .openPopup();
            } else {
                userMarker.setLatLng([userLat, userLng]); // mise à jour fluide
            }

            updateRoute(userLat, userLng);
        }, () => {
            alert("Impossible de récupérer votre position GPS.");
        }, { enableHighAccuracy: true });
    }
});
</script>


    {{-- <script>
        document.addEventListener('DOMContentLoaded', function() {
            const latitude = @json($reservation->property->latitude);
            const longitude = @json($reservation->property->longitude);

            // Initialisation de la carte
            const map = L.map('map-location-property-intinerary').setView([latitude, longitude], 16);

            // Tuiles OpenStreetMap
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; OpenStreetMap contributors'
            }).addTo(map);

            // Marqueur de la propriété
            const propertyMarker = L.marker([latitude, longitude]).addTo(map)
                .bindPopup("Emplacement de la propriété")
                .openPopup();

            let userMarker, control;
            let currentMode = "driving"; // OSRM public gère seulement "driving"

            // Fonction pour créer ou mettre à jour l'itinéraire
            function updateRoute(userLat, userLng) {
                if (control) {
                    map.removeControl(control);
                }

                control = L.Routing.control({
                    waypoints: [
                        L.latLng(userLat, userLng),
                        L.latLng(latitude, longitude)
                    ],
                    router: L.Routing.osrmv1({
                        serviceUrl: 'https://router.project-osrm.org/route/v1'
                    }),
                    lineOptions: {
                        styles: [{
                            color: 'red',
                            weight: 4
                        }]
                    },
                    show: false,
                    addWaypoints: false
                }).addTo(map);

                control.on('routesfound', function(e) {
                    const route = e.routes[0];
                    const distanceKm = (route.summary.totalDistance / 1000).toFixed(2);
                    const durationMin = Math.round(route.summary.totalTime / 60);

                    // Mise à jour des infos
                    document.querySelector('.info-map li:nth-child(2) span').innerText = distanceKm + " km";
                    document.querySelector('.info-map li:nth-child(3) span').innerText = durationMin +
                        " min en véhicule";

                    // Estimations approximatives
                    document.querySelector('.info-map li:nth-child(4) span').innerText =
                        Math.round(distanceKm * 12) + " min à pied"; // vitesse 5 km/h
                });

                control.on('routingerror', function(err) {
                    console.error("Erreur de calcul d'itinéraire", err);
                    alert("Impossible de calculer l'itinéraire pour le moment.");
                });
            }

            // Suivi en temps réel de la position utilisateur
            if (navigator.geolocation) {
                navigator.geolocation.watchPosition(position => {
                    const userLat = position.coords.latitude;
                    const userLng = position.coords.longitude;

                    if (!userMarker) {
                        userMarker = L.marker([userLat, userLng], {
                                color: 'blue'
                            }).addTo(map)
                            .bindPopup("Votre position")
                            .openPopup();
                    } else {
                        userMarker.setLatLng([userLat, userLng]);
                    }

                    updateRoute(userLat, userLng);

                }, () => {
                    alert("Impossible de récupérer votre position GPS.");
                }, {
                    enableHighAccuracy: true
                });
            }
        });
    </script> --}}

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const latitude = @json($reservation->property->latitude);
            const longitude = @json($reservation->property->longitude);

            // Initialisation de la carte
            const map = L.map('map-location-property-intinerary').setView([latitude, longitude], 15);

            // Tuiles modernes
            L.tileLayer('https://{s}.tile.openstreetmap.fr/hot/{z}/{x}/{y}.png', {
                attribution: '&copy; OpenStreetMap contributors | Design HOT'
            }).addTo(map);

            // Icônes personnalisées
            const propertyIcon = L.icon({
                iconUrl: 'https://cdn-icons-png.flaticon.com/512/854/854878.png',
                iconSize: [40, 40],
                iconAnchor: [20, 40],
                popupAnchor: [0, -35]
            });

            const userIcon = L.icon({
                iconUrl: 'https://cdn-icons-png.flaticon.com/512/149/149071.png',
                iconSize: [35, 35],
                iconAnchor: [17, 35],
                popupAnchor: [0, -30]
            });

            // Marqueur de la propriété
            const propertyMarker = L.marker([latitude, longitude], {
                    icon: propertyIcon
                }).addTo(map)
                .bindPopup("<b>🏠 Propriété</b><br>Destination finale")
                .openPopup();

            let userMarker, control;
            let currentMode = "driving";

            // Fonction pour créer ou mettre à jour l'itinéraire
            function updateRoute(userLat, userLng) {
                if (control) {
                    map.removeControl(control);
                }

                control = L.Routing.control({
                    waypoints: [
                        L.latLng(userLat, userLng),
                        L.latLng(latitude, longitude)
                    ],
                    router: L.Routing.osrmv1({
                        serviceUrl: 'https://router.project-osrm.org/route/v1'
                    }),
                    lineOptions: {
                        styles: [{
                                color: 'red',
                                weight: 5,
                                opacity: 0.7
                            },
                            {
                                color: 'blue',
                                weight: 3,
                                opacity: 0.5
                            }
                        ]
                    },
                    show: false,
                    addWaypoints: false,
                    fitSelectedRoutes: true // ajuste la vue automatiquement
                }).addTo(map);

                control.on('routesfound', function(e) {
                    const route = e.routes[0];
                    const distanceKm = (route.summary.totalDistance / 1000).toFixed(2);
                    const durationMin = Math.round(route.summary.totalTime / 60);

                    // Popup dynamique sur le marqueur utilisateur
                    userMarker.bindPopup(`
                    <b>📍 Vous êtes ici</b><br>
                    Distance : <b>${distanceKm} km</b><br>
                    Temps en véhicule 🚗 : <b>${durationMin} min</b><br>
                    Temps à pied 🚶 : <b>${Math.round(distanceKm * 12)} min</b>
                `).openPopup();
                });

                control.on('routingerror', function(err) {
                    console.error("Erreur de calcul d'itinéraire", err);
                    alert("Impossible de calculer l'itinéraire pour le moment.");
                });
            }

            // Suivi de la position utilisateur
            if (navigator.geolocation) {
                navigator.geolocation.watchPosition(position => {
                    const userLat = position.coords.latitude;
                    const userLng = position.coords.longitude;

                    if (!userMarker) {
                        userMarker = L.marker([userLat, userLng], {
                            icon: userIcon
                        }).addTo(map);
                    } else {
                        userMarker.setLatLng([userLat, userLng]);
                    }

                    updateRoute(userLat, userLng);

                }, () => {
                    alert("Impossible de récupérer votre position GPS.");
                }, {
                    enableHighAccuracy: true
                });
            }
        });
    </script>



    {{-- <script>
        document.addEventListener('DOMContentLoaded', function() {
            const latitude = @json($reservation->property->latitude);
            const longitude = @json($reservation->property->longitude);

            // Initialisation de la carte
            const map = L.map('map-location-property-intinerary').setView([latitude, longitude], 16);

            // Tuiles OpenStreetMap
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; OpenStreetMap contributors'
            }).addTo(map);

            // Marqueur de la propriété
            const propertyMarker = L.marker([latitude, longitude]).addTo(map)
                .bindPopup("Emplacement de la propriété")
                .openPopup();

            let userMarker, control;
            let currentMode = "driving"; // par défaut véhicule

            // Fonction pour créer ou mettre à jour l'itinéraire
            function updateRoute(userLat, userLng) {
                if (control) {
                    map.removeControl(control);
                }

                control = L.Routing.control({
                    waypoints: [
                        L.latLng(userLat, userLng),
                        L.latLng(latitude, longitude)
                    ],
                    router: L.Routing.osrmv1({
                        serviceUrl: 'https://router.project-osrm.org/route/v1/' + currentMode
                    }),
                    lineOptions: {
                        styles: [{
                            color: 'red',
                            weight: 4
                        }]
                    },
                    show: false,
                    addWaypoints: false
                }).addTo(map);

                control.on('routesfound', function(e) {
                    const route = e.routes[0];
                    const distanceKm = (route.summary.totalDistance / 1000).toFixed(2);
                    const durationMin = Math.round(route.summary.totalTime / 60);

                    // Mise à jour des infos
                    document.querySelector('.info-map li:nth-child(2) span').innerText = distanceKm + " km";
                    document.querySelector('.info-map li:nth-child(3) span').innerText = durationMin +
                        " min en véhicule";
                    document.querySelector('.info-map li:nth-child(4) span').innerText = Math.round(
                        durationMin * 1.5) + " min à pied";

                    // Lien Google Maps
                    document.getElementById('googleMapsBtn').href =
                        `https://www.google.com/maps/dir/?api=1&origin=${userLat},${userLng}&destination=${latitude},${longitude}&travelmode=${currentMode}`;
                });
            }

            // Fonction pour changer le mode de transport
            window.changeMode = function(mode) {
                currentMode = mode;
                if (userMarker) {
                    const pos = userMarker.getLatLng();
                    updateRoute(pos.lat, pos.lng);
                }
            }

            // Suivi en temps réel de la position utilisateur
            if (navigator.geolocation) {
                navigator.geolocation.watchPosition(position => {
                    const userLat = position.coords.latitude;
                    const userLng = position.coords.longitude;

                    if (!userMarker) {
                        userMarker = L.marker([userLat, userLng], {
                                color: 'blue'
                            }).addTo(map)
                            .bindPopup("Votre position")
                            .openPopup();
                    } else {
                        userMarker.setLatLng([userLat, userLng]);
                    }

                    updateRoute(userLat, userLng);

                }, () => {
                    alert("Impossible de récupérer votre position GPS.");
                }, {
                    enableHighAccuracy: true
                });
            }
        });
    </script> --}}
@endsection
{{-- il me veux quoi ce mec --}}
