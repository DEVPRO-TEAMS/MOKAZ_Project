/*var infoBox_ratingType='star-rating';*/

(function ($) {
    "use strict";

    function mainMap() {
        

        // var coteDIvoireBounds = [
        //     [4.333, -8.599], // Sud-Ouest
        //     [10.726, -2.504] // Nord-Est
        // ];
        // // Initialiser la carte centrée sur à Abidjan
        // var map = L.map('map').setView([7.539989, -5.547080], 7).setMaxBounds
        // Initialiser la carte Leaflet
        var coteDIvoireBounds = [
            [4.333, -8.599], // Sud-Ouest
            [10.726, -2.504] // Nord-Est
        ];
        // var map = L.map('map').setView([40.709295, -74.003099], 16);
       var map = L.map('map').setView([5.3489, -4.0030], 12).setMaxBounds(coteDIvoireBounds);
        // Initialiser la carte centrée sur à Abidjan
        // var map = L.map('map').setView([7.539989, -5.547080], 7).setMaxBounds(coteDIvoireBounds);
        // Ajouter le fond de carte
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);
        
        // Ajouter le contrôle de recherche
        L.Control.geocoder().addTo(map);

        function locationData(mapImg, mapURL, mapTitle, mapLocation, mapType, minTarif, tarifType, nbrSejour) {
            const plural = nbrSejour > 1 ? 's' : '';
            const priceLabel = minTarif !== null && tarifType
                ? `À partir de ${minTarif} FCFA/${nbrSejour}${tarifType.toLowerCase()}${plural}`
                : 'Tarif non disponible';

            return `
                <div class="map-listing-ite">
                    <div class="inner-box">
                        <div class="infoBox-close"><i class="icon icon-close"></i></div>
                        
                        <!-- Image -->
                        <div class="image-box">
                            <img src="${mapImg}" alt="${mapTitle}">
                        </div>
                        
                        <!-- Contenu -->
                        <div class="content">
                            
                            <!-- Localisation -->
                            <p class="location">
                                <span class="icon icon-mapPin"></span>
                                ${mapLocation}
                            </p>
                            
                            <!-- Titre -->
                            <div class="title">
                                <a href="${mapURL}">${mapTitle}</a>
                            </div>
                            
                            <!-- Étoiles de notation -->
                            <div class="rating">
                                <span class="star">&#9733;</span>
                                <span class="star">&#9733;</span>
                                <span class="star">&#9733;</span>
                                <span class="star">&#9733;</span>
                                <span class="star half">&#9733;</span>
                                <span class="rating-score">(4.5/5)</span>
                            </div>
                            
                            <!-- Info supplémentaire -->
                            <div class="extra-info">
                                <span class="category">🏨 ${mapType}</span> • 
                                <span class="price">${priceLabel}</span>
                            </div>
                            
                            <!-- Bouton -->
                            <div class="actions">
                                <a href="${mapURL}" class="btn-view">Voir plus</a>
                            </div>
                        </div>
                    </div>
                </div>
            `;
        }

        // var APP_URL = '{{ asset('/') }}';
        window.MAP_ICON_PATH = "{{ asset('assets/images/location/map-icon1.png') }}";
        // Récupération des propriétés via AJAX
        $.ajax({
            url: '/api/get-all-properties',
            type: 'GET',
            success: function(properties) {
                console.log(properties);
                properties.forEach(function(property) {
                    var popupContent = locationData(
                        property.image,
                        '/appart-by-property/' + property.uuid,
                        property.title,
                        "Distance à calculer",  
                        property.type.libelle,
                        property.min_tarif,
                        property.tarif_type,  // par "Heure" ou "Jour" 
                        property.nbr_sejour
                        );
                        
                        // Création du marqueur avec icône personnalisée
                    var customIcon = L.divIcon({
                        className: 'map-marker-container',
                        html: `
                            <div class="marker-container">
                                <div class="marker-card">
                                    <div class="front face">
                                        <div>
                                            
                                        </div>
                                    </div>
                                    <div class="back face">
                                        <div>
                                            
                                        </div>
                                    </div>
                                    <div class="marker-arrow"></div>
                                </div>
                            </div>`,
                        iconSize: [40, 40],
                        iconAnchor: [20, 40]
                    });
                    
                    // Ajout du marqueur à la carte
                    L.marker([property.latitude, property.longitude], {icon: customIcon})
                        .addTo(map)
                        .bindPopup(popupContent);
                });
            },
            error: function() {
                console.error('Erreur lors du chargement des propriétés');
            }
        });

        // Géolocalisation sécurisée (HTTPS seulement)
        if (window.location.protocol === 'https:') {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(
                    function(position) {
                        var userLatLng = [position.coords.latitude, position.coords.longitude];
                        
                        // Marqueur pour la position utilisateur
                        var userIcon = L.divIcon({
                            className: 'user-location-marker',
                            html: '<div class="user-marker"></div>',
                            iconSize: [20, 20]
                        });
                        
                        L.marker(userLatLng, {icon: userIcon})
                            .addTo(map)
                            .bindPopup('Votre position')
                            .openPopup();
                            
                        // Recentrer la carte sur la position
                        map.setView(userLatLng, 16);
                    },
                    function(error) {
                        console.log('Erreur de géolocalisation:', error.message);
                    },
                    {
                        enableHighAccuracy: true,
                        timeout: 5000,
                        maximumAge: 0
                    }
                );
            } else {
                console.log('Géolocalisation non supportée par le navigateur');
            }
        } else {
            console.log('La géolocalisation nécessite une connexion HTTPS');
        }
    }
    
    var map = document.getElementById("map");
    if (typeof map != "undefined" && map != null) {
        google.maps.event.addDomListener(window, "load", mainMap);
    }

    // Initialiser la carte quand le DOM est prêt
    $(document).ready(function() {
        mainMap();
    });

    function singleListingMap() {
        var myLatlng = new google.maps.LatLng({
            lng: $("#singleListingMap").data("longitude"),
            lat: $("#singleListingMap").data("latitude"),
        });
        var single_map = new google.maps.Map(
            document.getElementById("singleListingMap"),
            {
                zoom: 16,
                center: myLatlng,
                scrollwheel: false,
                zoomControl: false,
                mapTypeControl: false,
                scaleControl: false,
                panControl: false,
                navigationControl: false,
                streetViewControl: false,
                styles: [
                    {
                        featureType: "all",
                        elementType: "geometry.fill",
                        stylers: [
                            {
                                weight: "2.00",
                            },
                        ],
                    },
                    {
                        featureType: "all",
                        elementType: "geometry.stroke",
                        stylers: [
                            {
                                color: "#9c9c9c",
                            },
                        ],
                    },
                    {
                        featureType: "all",
                        elementType: "labels.text",
                        stylers: [
                            {
                                visibility: "on",
                            },
                        ],
                    },
                    {
                        featureType: "landscape",
                        elementType: "all",
                        stylers: [
                            {
                                color: "#f2f2f2",
                            },
                        ],
                    },
                    {
                        featureType: "landscape",
                        elementType: "geometry.fill",
                        stylers: [
                            {
                                color: "#ffffff",
                            },
                        ],
                    },
                    {
                        featureType: "landscape.man_made",
                        elementType: "geometry.fill",
                        stylers: [
                            {
                                color: "#ffffff",
                            },
                        ],
                    },
                    {
                        featureType: "poi",
                        elementType: "all",
                        stylers: [
                            {
                                visibility: "off",
                            },
                        ],
                    },
                    {
                        featureType: "road",
                        elementType: "all",
                        stylers: [
                            {
                                saturation: -100,
                            },
                            {
                                lightness: 45,
                            },
                        ],
                    },
                    {
                        featureType: "road",
                        elementType: "geometry.fill",
                        stylers: [
                            {
                                color: "#eeeeee",
                            },
                        ],
                    },
                    {
                        featureType: "road",
                        elementType: "labels.text.fill",
                        stylers: [
                            {
                                color: "#7b7b7b",
                            },
                        ],
                    },
                    {
                        featureType: "road",
                        elementType: "labels.text.stroke",
                        stylers: [
                            {
                                color: "#ffffff",
                            },
                        ],
                    },
                    {
                        featureType: "road.highway",
                        elementType: "all",
                        stylers: [
                            {
                                visibility: "simplified",
                            },
                        ],
                    },
                    {
                        featureType: "road.arterial",
                        elementType: "labels.icon",
                        stylers: [
                            {
                                visibility: "off",
                            },
                        ],
                    },
                    {
                        featureType: "transit",
                        elementType: "all",
                        stylers: [
                            {
                                visibility: "off",
                            },
                        ],
                    },
                    {
                        featureType: "water",
                        elementType: "all",
                        stylers: [
                            {
                                color: "#46bcec",
                            },
                            {
                                visibility: "on",
                            },
                        ],
                    },
                    {
                        featureType: "water",
                        elementType: "geometry.fill",
                        stylers: [
                            {
                                color: "#c8d7d4",
                            },
                        ],
                    },
                    {
                        featureType: "water",
                        elementType: "labels.text.fill",
                        stylers: [
                            {
                                color: "#070707",
                            },
                        ],
                    },
                    {
                        featureType: "water",
                        elementType: "labels.text.stroke",
                        stylers: [
                            {
                                color: "#ffffff",
                            },
                        ],
                    },
                ],
            }
        );
        $("#streetView").click(function (e) {
            e.preventDefault();
            single_map.getStreetView().setOptions({
                visible: true,
                position: myLatlng,
            });
        });
        var zoomControlDiv = document.createElement("div");
        var zoomControl = new ZoomControl(zoomControlDiv, single_map);
        function ZoomControl(controlDiv, single_map) {
            zoomControlDiv.index = 1;
            single_map.controls[google.maps.ControlPosition.RIGHT_CENTER].push(
                zoomControlDiv
            );
            controlDiv.style.padding = "5px";
            var controlWrapper = document.createElement("div");
            controlDiv.appendChild(controlWrapper);
            var zoomInButton = document.createElement("div");
            zoomInButton.className = "custom-zoom-in";
            controlWrapper.appendChild(zoomInButton);
            var zoomOutButton = document.createElement("div");
            zoomOutButton.className = "custom-zoom-out";
            controlWrapper.appendChild(zoomOutButton);
            google.maps.event.addDomListener(
                zoomInButton,
                "click",
                function () {
                    single_map.setZoom(single_map.getZoom() + 1);
                }
            );
            google.maps.event.addDomListener(
                zoomOutButton,
                "click",
                function () {
                    single_map.setZoom(single_map.getZoom() - 1);
                }
            );
        }
        var singleMapIco =
            "<i class='" + $("#singleListingMap").data("map-icon") + "'></i>";
        new CustomMarker(
            myLatlng,
            single_map,
            {
                marker_id: "1",
            },
            singleMapIco
        );
    }

    var single_map = document.getElementById("singleListingMap");
    if (typeof single_map != "undefined" && single_map != null) {
        google.maps.event.addDomListener(window, "load", singleListingMap);
    }

    function CustomMarker(latlng, map, args, markerIco) {
        this.latlng = latlng;
        this.args = args;
        this.markerIco = markerIco;
        this.setMap(map);
    }
    CustomMarker.prototype = new google.maps.OverlayView();
    CustomMarker.prototype.draw = function () {
        var self = this;
        var div = this.div;
        if (!div) {
            div = this.div = document.createElement("div");
            div.className = "map-marker-container";
            div.innerHTML =
                '<div class="marker-container">' +
                '<div class="marker-card">' +
                '<div class="front face">' +
                self.markerIco +
                "</div>" +
                '<div class="back face">' +
                self.markerIco +
                "</div>" +
                '<div class="marker-arrow"></div>' +
                "</div>" +
                "</div>";
            google.maps.event.addDomListener(div, "click", function (event) {
                $(".map-marker-container").removeClass(
                    "clicked infoBox-opened"
                );
                google.maps.event.trigger(self, "click");
                $(this).addClass("clicked infoBox-opened");
            });
            if (typeof self.args.marker_id !== "undefined") {
                div.dataset.marker_id = self.args.marker_id;
            }
            var panes = this.getPanes();
            panes.overlayImage.appendChild(div);
        }
        var point = this.getProjection().fromLatLngToDivPixel(this.latlng);
        if (point) {
            div.style.left = point.x + "px";
            div.style.top = point.y + "px";
        }
    };
    CustomMarker.prototype.remove = function () {
        if (this.div) {
            this.div.parentNode.removeChild(this.div);
            this.div = null;
            $(this).removeClass("clicked");
        }
    };
    CustomMarker.prototype.getPosition = function () {
        return this.latlng;
    };
})(this.jQuery);
