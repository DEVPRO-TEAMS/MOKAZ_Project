@extends('layouts.app')

@section('content')
    <div class="main-content-inner wrap-dashboard-content">
        <div class="button-show-hide show-mb">
            <span class="body-1">Afficher le tableau de bord</span>
        </div>
        <form id="addAppartForm" enctype="multipart/form-data">
            {{-- @csrf --}}
            <input type="hidden" name="partner_code" value="{{ Auth::user()->email ?? '' }}">
            <input type="hidden" name="property_code" id="property_code" value="{{ $property_code }}">
            <div class="widget-box-2">
                <h6 class="title">Charger l'images de l'appartement</h6>
                <div class="box-uploadfile text-center">
                    <label class="uploadfile">
                        <span class="icon icon-img-2"></span>
                        <div class="btn-upload">
                            <a href="#" class="tf-btn primary">Choisir l'image</a>
                            <input type="file" class="ip-file" name="main_image" required>
                        </div>
                        <p class="file-name fw-5">Ou glisser déposez l'images ici</p>
                    </label>
                </div>
            </div>
            <div class="widget-box-2">
                <h6 class="title">Information sur l'appartement</h6>
                <div class="box-info-property">
                    <fieldset class="box box-fieldset">
                        <label for="title">
                            Titre:<span>*</span>
                        </label>
                        <input type="text" class="form-control style-1" value=""
                            placeholder="Entrer le titre de la propriété" name="title">
                    </fieldset>
                    <fieldset class="box box-fieldset">
                        <label for="desc">Description:</label>
                        <textarea class="textarea-tinymc" name="description" placeholder="Entrer la description de la propriété"
                            cols="30" rows="10" id="desc"></textarea>
                    </fieldset>



                </div>
            </div>
            <div class="widget-box-2">
                <h6 class="title">Prix</h6>
                <div class="box-price-property">
                    <div class="box grid-2 gap-30">
                        <fieldset class="box-fieldset">
                            <label for="price">
                                Prix unitaire:<span>*</span>
                            </label>
                            <input type="number" name="price" class="form-control style-1" placeholder="Example value: 12345.67">
                        </fieldset>
                        <fieldset class="box-fieldset">
                            <label for="neighborhood">
                                Nombre disponible:<span>*</span>
                            </label>
                            <input type="number" name="available" class="form-control style-1" placeholder="Example value: 12345.67">
                        </fieldset>
                    </div>
                </div>
            </div>
            <div class="widget-box-2">
                <h6 class="title">Informations complémentaires</h6>
                <div class="box grid-3 gap-30">
                    <fieldset class="box-fieldset">
                        <label for="appartType">
                            Type de l'appartment:<span>*</span>
                        </label>
                        
                        <select class="form-select nice-select" id="appartType" name="appartType" required>
                            <option value="" >Sélectionnez...</option>
                            <option value="Villa">Villa</option>
                            <option value="Studio">Studio</option>
                            <option value="Bureau">Bureau</option>
                            <option value="Maison de ville">Maison de ville</option>
                        </select>
                    </fieldset>
                    <fieldset class="box-fieldset">
                        <label for="bedrooms">
                            Nombre de chambres:<span>*</span>
                        </label>
                        <input type="number" name="bedroomsNumber" class="form-control style-1">
                    </fieldset>
                    <fieldset class="box-fieldset">
                        <label for="bathrooms">
                            Nombre de salles de bain:<span>*</span>
                        </label>
                        <input type="number" name="bathroomsNumber" class="form-control style-1">
                    </fieldset> 
                </div>
            </div>
            <div class="widget-box-2">
                <h6 class="title">Commodités <span>*</span></h6>
                <div class="box-amenities-property">
                    <div class="box-amenities">
                        <div class="title-amenities fw-7">Sécurité à domicile ::</div>
                        <fieldset class="amenities-item">
                            <input type="checkbox" value="Détecteur de fumée" name="CommoditiesHomesafety" class="tf-checkbox style-1 primary" id="cb1" checked>
                            <label for="cb1" class="text-cb-amenities">Détecteur de fumée</label>
                        </fieldset>
                        <fieldset class="amenities-item">
                            <input type="checkbox" value="Détecteur de monoxyde de carbone" name="CommoditiesHomesafety" class="tf-checkbox style-1 primary" id="cb2">
                            <label for="cb2" class="text-cb-amenities">Détecteur de monoxyde de carbone</label>
                        </fieldset>
                        <fieldset class="amenities-item">
                            <input type="checkbox" value="Trousse de secours" name="CommoditiesHomesafety" class="tf-checkbox style-1 primary" id="cb3" checked>
                            <label for="cb3" class="text-cb-amenities">Trousse de secours</label>
                        </fieldset>
                        <fieldset class="amenities-item">
                            <input type="checkbox" value="Enregistrement automatique avec boîte à clé" name="CommoditiesHomesafety" class="tf-checkbox style-1 primary" id="cb4" checked>
                            <label for="cb4" class="text-cb-amenities">Enregistrement automatique avec boîte à clé</label>
                        </fieldset>
                        <fieldset class="amenities-item">
                            <input type="checkbox" name="CommoditiesHomesafety" value="Caméras de sécurité" class="tf-checkbox style-1 primary" id="cb5">
                            <label for="cb5" class="text-cb-amenities">Caméras de sécurité</label>
                        </fieldset>
                    </div>
                    <div class="box-amenities">
                        <div class="title-amenities fw-7">Chambre à coucher:</div>
                        <fieldset class="amenities-item">
                            <input type="checkbox" value="cintres" name="CommoditiesBedroom" class="tf-checkbox style-1 primary" id="cb6">
                            <label for="cb6" class="text-cb-amenities">cintres</label>
                        </fieldset>
                        <fieldset class="amenities-item">
                            <input type="checkbox" value="Linge de lit" name="CommoditiesBedroom" class="tf-checkbox style-1 primary" id="cb7" checked>
                            <label for="cb7" class="text-cb-amenities">Linge de lit</label>
                        </fieldset>
                        <fieldset class="amenities-item">
                            <input type="checkbox" value="Oreillers et couvertures supplémentaires" name="CommoditiesBedroom" class="tf-checkbox style-1 primary" id="cb8">
                            <label for="cb8" class="text-cb-amenities">Oreillers et couvertures supplémentaires</label>
                        </fieldset>
                        <fieldset class="amenities-item">
                            <input type="checkbox" value="Fer à repasser" name="CommoditiesBedroom" class="tf-checkbox style-1 primary" id="cb9">
                            <label for="cb9" class="text-cb-amenities">Fer à repasser</label>
                        </fieldset>
                        <fieldset class="amenities-item">
                            <input type="checkbox" value="Téléviseur avec câble standard" name="CommoditiesBedroom" class="tf-checkbox style-1 primary" id="cb10" checked>
                            <label for="cb10" class="text-cb-amenities">Téléviseur avec câble standard</label>
                        </fieldset>
                    </div>
                    <div class="box-amenities">
                        <div class="title-amenities fw-7">Cuisine:</div>
                        <fieldset class="amenities-item">
                            <input type="checkbox" value="Réfrigérateur" name="CommoditiesKitchen" class="tf-checkbox style-1 primary" id="cb11">
                            <label for="cb11" class="text-cb-amenities">Réfrigérateur</label>
                        </fieldset>
                        <fieldset class="amenities-item">
                            <input type="checkbox" value="Micro-ondes" name="CommoditiesKitchen" class="tf-checkbox style-1 primary" id="cb12">
                            <label for="cb12" class="text-cb-amenities">Micro-ondes</label>
                        </fieldset>
                        <fieldset class="amenities-item">
                            <input type="checkbox" value="Lave-vaisselle" name="CommoditiesKitchen" class="tf-checkbox style-1 primary" id="cb13">
                            <label for="cb13" class="text-cb-amenities">Lave-vaisselle</label>
                        </fieldset>
                        <fieldset class="amenities-item">
                            <input type="checkbox" value="Cafetière" name="CommoditiesKitchen" class="tf-checkbox style-1 primary" id="cb14">
                            <label for="cb14" class="text-cb-amenities">Cafetière</label>
                        </fieldset>

                    </div>
                </div>
            </div>
            <div class="widget-box-2">
                <h6 class="title">Charger les images de l'appartement</h6>
                <div class="box-uploadfile text-center">
                    <label class="uploadfile">
                        <span class="icon icon-img-2"></span>
                        <div class="btn-upload">
                            <a href="#" class="tf-btn primary">Choisir au moins une image</a>
                            <input type="file" class="ip-file" name="images_appart" required multiple>
                        </div>
                        <p class="file-name fw-5">Ou glisser déposez les images ici</p>
                    </label>
                </div>
            </div>
            <div class="widget-box-2">
                <h6 class="title">Videos de l'appartement</h6>
                <fieldset class="box-fieldset">
                    <label for="video">URL de la vidéo :</label>
                    <input type="text" class="form-control style-1" id="video" name="video_url" placeholder="Youtube de preference">
                </fieldset>
            </div>
            <div class="d-flex justify-content-end">
                <button type="submit" class="tf-btn primary"> Ajouter</button>
            </div>
            
        </form>

    </div>

    <script>

        document.getElementById('addAppartForm').addEventListener('submit', async function(e) {
            e.preventDefault();
            const property_code = document.getElementById('property_code').value;

            const submitBtn = this.querySelector('button[type="submit"]');
            const originalText = submitBtn.innerHTML;

            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Envoi en cours...';
            submitBtn.disabled = true;

            try {
                const formData = new FormData(this);
                const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content;
                if (csrfToken) {
                    formData.append('_token', csrfToken);
                }

                console.log('Form data:', Object.fromEntries(formData));

                const response = await fetch('/api/appart/add', {
                    method: 'POST',
                    headers: {
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': csrfToken
                    },
                    body: formData
                });

                const data = await response.json();

                console.log('Response:', data);

                if (!response.ok) {
                    if (data.errors) {
                        const errorMessages = Object.values(data.errors).flat().join('\n');
                        throw new Error(errorMessages);
                    }
                    throw new Error(data.message || 'Erreur lors de l\'envoi');
                }

                // ✅ Message de succès
                Swal.fire({
                    icon: 'success',
                    title: 'Succès',
                    text: 'Appartement ajoutée avec succès',
                    timer: 5000,
                    showConfirmButton: false,
                    position: 'top-end',
                    toast: true
                });

                // const modal = bootstrap.Modal.getInstance(document.getElementById('demandPartnariaModal'));
                // modal.hide();
                this.reset();
                setTimeout(() => {
                    window.location.href = 'partner/property/show/' + property_code;
                }, 3000);

            } catch (error) {
                console.error('Erreur:', error);
                Swal.fire({
                    icon: "error",
                    title: "Erreur",
                    text: error.message,
                });
            } finally {
                submitBtn.innerHTML = originalText;
                submitBtn.disabled = false;
            }
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const mapElement = document.getElementById('map-single-property');
            const latitudeInput = document.querySelector('input[name="latitude"]');
            const longitudeInput = document.querySelector('input[name="longitude"]');
            const locationButton = document.querySelector('.btn-location');

            // Valeurs par défaut (centre sur Abidjan si vide)
            const defaultLat = 5.3361;
            const defaultLng = -4.0268;

            const initialLat = parseFloat(latitudeInput.value) || defaultLat;
            const initialLng = parseFloat(longitudeInput.value) || defaultLng;

            // Initialisation de la carte
            const map = L.map(mapElement).setView([initialLat, initialLng], 16);

            // Ajouter le fond de carte
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '© OpenStreetMap',
            }).addTo(map);

            // Ajout du marqueur
            let marker = L.marker([initialLat, initialLng], {
                draggable: true
            }).addTo(map);

            // Mettre à jour les champs quand on déplace le marqueur
            marker.on('dragend', function(e) {
                const pos = marker.getLatLng();
                latitudeInput.value = pos.lat.toFixed(6);
                longitudeInput.value = pos.lng.toFixed(6);
            });

            // Bouton pour localiser automatiquement l'utilisateur
            locationButton.addEventListener('click', function(e) {
                e.preventDefault();
                if (!navigator.geolocation) {
                    alert('La géolocalisation n’est pas supportée par ce navigateur.');
                    return;
                }

                navigator.geolocation.getCurrentPosition(function(position) {
                    const lat = position.coords.latitude;
                    const lng = position.coords.longitude;

                    latitudeInput.value = lat.toFixed(6);
                    longitudeInput.value = lng.toFixed(6);

                    // Déplacer le marqueur et centrer la carte
                    marker.setLatLng([lat, lng]);
                    map.setView([lat, lng], 16);
                }, function(error) {
                    alert("Impossible d'obtenir votre position.");
                    console.error(error);
                });
            });

            // Geocoder (recherche d’adresse)
            L.Control.geocoder({
                    defaultMarkGeocode: false
                })
                .on('markgeocode', function(e) {
                    const center = e.geocode.center;
                    map.setView(center, 16);
                    marker.setLatLng(center);
                    latitudeInput.value = center.lat.toFixed(6);
                    longitudeInput.value = center.lng.toFixed(6);
                })
                .addTo(map);
        });
    </script>
@endsection
