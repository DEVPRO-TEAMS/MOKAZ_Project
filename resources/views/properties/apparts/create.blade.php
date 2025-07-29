@extends('layouts.app')

@section('content')

<style>
    /* Styles pour la liste des fichiers */
        .files-list {
            margin-top: 20px;
            padding: 15px;
            background: #f8f9fa;
            border-radius: 5px;
            display: none;
        }

        .files-list.show {
            display: block;
        }

        .files-list h6 {
            margin: 0 0 10px 0;
            color: #333;
            font-size: 14px;
            font-weight: 600;
        }

        .file-item {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 8px 12px;
            margin: 5px 0;
            background: white;
            border-radius: 4px;
            border: 1px solid #e0e0e0;
        }

        .file-info {
            display: flex;
            align-items: center;
            flex: 1;
        }

        .file-icon {
            margin-right: 8px;
            font-size: 16px;
        }

        .file-details {
            display: flex;
            flex-direction: column;
        }

        .file-name-display {
            font-size: 13px;
            color: #333;
            font-weight: 500;
        }

        .file-size {
            font-size: 11px;
            color: #666;
        }

        .file-remove {
            background: #dc3545;
            color: white;
            border: none;
            border-radius: 3px;
            padding: 4px 8px;
            font-size: 11px;
            cursor: pointer;
            transition: background 0.3s;
        }

        .file-remove:hover {
            background: #c82333;
        }

        .files-count {
            color: #007bff;
            font-weight: 600;
        }

        .preview-container img {
        width: 100px;
        height: 100px;
        object-fit: cover;
        margin-bottom: 10px;
        border-radius: 8px;
        }

        .preview-item {
            position: relative;
            display: inline-block;
        }

        .remove-btn {
            position: absolute;
            top: -8px;
            right: -8px;
            background: red;
            color: white;
            border: none;
            border-radius: 50%;
            width: 20px;
            height: 20px;
            cursor: pointer;
            font-size: 12px;
        }
</style>
    <div class="main-content-inne wrap-dashboard-content">
        <div class="row mb-4">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center">
                    <h3 class="mb-0">
                        <i class="fas fa-home me-2 text-danger"></i> Ajout d'appart dans la propriété #{{ $property_code }}
                    </h3>
                </div>
            </div>
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
                            <input type="file" class="ip-file" name="main_image" accept="image/*" required>
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
                        <textarea class="textarea-tinymce" name="description" placeholder="Entrer la description de la propriété"
                            cols="30" rows="10" id="desc"></textarea>
                    </fieldset>



                </div>
            </div>

            <div class="widget-box-2">
                <h6 class="title">Tarifs</h6>
                <div id="tarifs-container">
                    <div class="box-price-property tarif-block mb-3">
                        <div class="row box">
                            <fieldset class="box-fieldset col-md-4">
                                <label for="sejour_en_0">
                                    Séjour en:<span>*</span>
                                </label>
                                <select class="form-select list style-1 nice-select" id="sejour_en_0" name="sejour_en[]" required>
                                    <option value="">Sélectionnez...</option>
                                    <option value="Jour">Jour</option>
                                    <option value="Heure">Heure</option>
                                    <option value="Semaine">Semaine</option>
                                </select>
                            </fieldset>
                            <fieldset class="box-fieldset col-md-4">
                                <label>
                                    Nombre:<span>*</span>
                                </label>
                                <input type="number" name="temps[]" class="form-control style-1" placeholder="Exemple value: 1" required>
                            </fieldset>
                            <fieldset class="box-fieldset col-md-3">
                                <label>
                                    Coût:<span>*</span>
                                </label>
                                <input type="number" name="prix[]" class="form-control style-1" placeholder="Exemple value: 1" required>
                            </fieldset>

                            <fieldset class="box-fieldset col-md-1 pt-md-2 pt-lg-2" id="removeTarifBtnContainer">
                                {{-- Afficher le bouton de suppression ici --}}
                            </fieldset>
                        </div>
                    </div>
                </div>

                <div class="mt-3">
                    <button type="button" id="addTarifBtn" class="tf-btn primary">+ Ajouter un tarif</button>
                </div>
            </div>

            <div class="widget-box-2">
                <h6 class="title">Informations complémentaires</h6>
                <div class="row box">
                    <fieldset class="box-fieldset col-md-3">
                        <label for="appartType">
                            Type de l'appartment:<span>*</span>
                        </label>
                        
                        <select class="form-select nice-select list style-1" id="appartType" name="appartType" required>
                            <option value="" >Sélectionnez...</option>
                            <option value="Villa">Villa</option>
                            <option value="Studio">Studio</option>
                            <option value="Bureau">Bureau</option>
                            <option value="Maison de ville">Maison de ville</option>
                        </select>
                    </fieldset>
                    <fieldset class="box-fieldset col-md-3">
                        <label for="bedrooms">
                            Nombre de chambres:<span>*</span>
                        </label>
                        <input type="number" name="bedroomsNumber" class="form-control style-1" placeholder="Exemple valeur: 1">
                    </fieldset>
                    <fieldset class="box-fieldset col-md-3">
                        <label for="bathrooms">
                            Nombre de salles de bain:<span>*</span>
                        </label>
                        <input type="number" name="bathroomsNumber" class="form-control style-1" placeholder="Exemple valeur: 1">
                    </fieldset>
                    <fieldset class="box-fieldset col-md-3">
                        <label for="neighborhood">
                            Nombre disponible:<span>*</span>
                        </label>
                        <input type="number" name="available" class="form-control style-1" placeholder="Exemple valeur: 1">
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
                            <input type="file" class="ip-file ip-files" name="images_appart[]" id="imagesInput" multiple accept="image/*">
                        </div>
                        <p class="file-nam fw-5">
                            Fichiers sélectionnés (<span class="files-count text-danger" id="filesCount">0</span>)
                        </p>
                    </label>
                </div>

                <div id="previewContainer" class="preview-container d-flex flex-wrap gap-3 mt-3"></div>
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
        const imagesInput = document.getElementById('imagesInput');
        const previewContainer = document.getElementById('previewContainer');
        const filesCount = document.getElementById('filesCount');

        let imageFiles = [];

        imagesInput.addEventListener('change', function () {
            const newFiles = Array.from(imagesInput.files);

            // Fusionner les fichiers actuels et nouveaux sans doublon
            for (const file of newFiles) {
                if (!imageFiles.some(f => f.name === file.name && f.lastModified === file.lastModified)) {
                    imageFiles.push(file);
                }
            }

            renderPreviews();
        });

        function renderPreviews() {
            previewContainer.innerHTML = '';
            filesCount.textContent = imageFiles.length;

            imageFiles.forEach((file, index) => {
                const reader = new FileReader();
                reader.onload = function (e) {
                    const div = document.createElement('div');
                    div.classList.add('preview-item');

                    const img = document.createElement('img');
                    img.src = e.target.result;

                    const removeBtn = document.createElement('button');
                    removeBtn.className = 'remove-btn';
                    removeBtn.innerHTML = 'x';
                    removeBtn.onclick = () => {
                        imageFiles.splice(index, 1);
                        renderPreviews();
                    };

                    div.appendChild(img);
                    div.appendChild(removeBtn);
                    previewContainer.appendChild(div);
                };
                reader.readAsDataURL(file);
            });

            // Mettre à jour l'input pour correspondre aux fichiers sélectionnés
            const dataTransfer = new DataTransfer();
            imageFiles.forEach(file => dataTransfer.items.add(file));
            imagesInput.files = dataTransfer.files;
        }
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

</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const addTarifBtn = document.getElementById('addTarifBtn'); // Récupère le bouton "Ajouter un tarif"
        const tarifsContainer = document.getElementById('tarifs-container'); // Récupère le container des tarifs
        const tarifBlock = document.querySelector('.tarif-block'); // Récupère le premier bloc de tarif (à cloner)

        // Fonction pour cloner un bloc de tarif
        addTarifBtn.addEventListener('click', function () {
            const newTarifBlock = tarifBlock.cloneNode(true); // Clone le premier bloc de tarif

            // Crée un bouton de suppression
            const deleteBtn = document.createElement('button');
            deleteBtn.textContent = 'Supprimer';
            deleteBtn.classList.add('tf-btn', 'secondary', 'mt-sm-2', 'mt-lg-4', 'mt-md-4'); // Ajoute des classes au bouton de suppression
            // deleteBtn.style.marginTop = '40px';

            // Ajoute l'écouteur d'événement pour supprimer le bloc
            deleteBtn.addEventListener('click', function () {
                newTarifBlock.remove(); // Supprime le bloc cloné
            });

            // Trouve l'endroit pour insérer le bouton dans le bloc cloné
            const removeTarifBtnContainer = newTarifBlock.querySelector('#removeTarifBtnContainer');
            removeTarifBtnContainer.appendChild(deleteBtn); // Ajoute le bouton de suppression au bloc cloné

            // Ajoute le bloc cloné dans le container
            tarifsContainer.appendChild(newTarifBlock);
        });
    });
</script>







@endsection
