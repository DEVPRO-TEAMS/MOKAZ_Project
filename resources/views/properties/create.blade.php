@extends('layouts.app')

@section('content')
    <div class="main-content-inner wrap-dashboard-content">
        <div class="button-show-hide show-mb">
            <span class="body-1">Afficher le tableau de bord</span>
        </div>
        <form id="addPropertyForm" enctype="multipart/form-data">
            {{-- @csrf --}}
            <input type="hidden" name="partner_code" value="{{ Auth::user()->email ?? ''}}">
            <div class="widget-box-2">
                <h6 class="title">Charger l'image de la propriété</h6>
                <div class="box-uploadfile text-center">
                    <label class="uploadfile">
                        <span class="icon icon-img-2"></span>
                        <div class="btn-upload">
                            <a href="#" class="tf-btn primary">Choisir une image</a>
                            <input type="file" class="ip-file" name="image_property" required>
                        </div>
                        <p class="file-name fw-5">Ou glisser déposez l'image ici</p>
                    </label>
                </div>
            </div>
            <div class="widget-box-2">
                <h6 class="title">Information sur la propriété</h6>
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
                        <textarea class="textarea-tinymce" name="description" placeholder="Entrer la description de la propriété" cols="30" rows="10" required id="desc"></textarea>
                    </fieldset>

                    <div class="box grid-2 gap-30">
                        <fieldset class="box-fieldset">
                            <label for="address">
                                Adresse complète:<span>*</span>
                            </label>
                            <input type="text" class="form-control style-1"
                                placeholder="Entrer l'adresse complète de la propriété" name="address" required>
                        </fieldset>
                        <fieldset class="box-fieldset">
                            <label for="zip">
                                Code postal:<span></span>
                            </label>
                            <input type="text" class="form-control style-1" placeholder="Entrer le code postal"
                                name="zipCode" value="">
                        </fieldset>

                    </div>
                    <div class="box grid-2 gap-30">
                        <fieldset class="box-fieldset">
                            <label for="country">
                                Pays:<span>*</span>
                            </label>
                            <select name="country" class="nice-select list style-1" id="country" required>
                                @foreach ($countries as $country)
                                    <option value="{{ $country->code }}" @if ($country->code == 'CIV') selected @endif>{{ $country->label }}</option>
                                @endforeach
                            </select>
                        </fieldset>
                        <fieldset class="box-fieldset">
                            <label for="city">
                                Ville:<span>*</span>
                            </label>

                            <select name="city" class="nice-select list style-1" id="city" required>
                                
                            </select>
                        </fieldset>
                    </div>
                    <div class="box box-fieldset">
                        <label for="location">Emplacement:<span>*</span></label>
                        
                        <div class="row">
                            <div class="box-ip col-md-6">
                                <input type="text" name="longitude" class="form-control style-1" placeholder="Longitude" required>
                            </div>
                            <div class="box-ip col-md-5">
                                <input type="text" name="latitude" class="form-control style-1" placeholder="Latitude" required>
                            </div>
                            <div class="box-ip col-md-1">
                                <a href="#" class="btn-location"><i class="icon icon-location"></i></a>
                            </div>
                        </div>
                    </div>
                    <div class="box box-fieldset">
                        {{-- <div id="map-single" class="map-single" data-map-zoom="16" data-map-scroll="true"></div> --}}
                        <div id="map-single-property" class="map-single" data-map-zoom="16" data-map-scroll="true"></div>
                    </div>

                </div>
            </div>
            <div class="d-flex justify-content-end">
                <button type="submit" class="tf-btn primary"> Ajouter</button>
            </div>
            {{-- <a href="#" class="tf-btn primary">Add Property</a> --}}
        </form>

    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const countrySelect = document.getElementById('country');
            const citySelect = document.getElementById('city');

            countrySelect.addEventListener('change', function () {
                const selectedCountry = this.value;

                // Vider les anciennes options
                citySelect.innerHTML = '<option value="">Chargement...</option>';

                fetch(`/api/get-cities-by-country?country=${selectedCountry}`, {
                    headers: {
                        'Accept': 'application/json'
                    }
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Erreur lors de la récupération des villes');
                    }
                    return response.json();
                })
                .then(data => {
                    citySelect.innerHTML = ''; // Vider le select

                    if (data.length === 0) {
                        citySelect.innerHTML = '<option value="">Aucune ville trouvée</option>';
                        return;
                    }

                    data.forEach(city => {
                        const option = document.createElement('option');
                        option.value = city.code;
                        option.textContent = city.label; // Assurez-vous que votre modèle `city` a un champ `name`
                        citySelect.appendChild(option);
                    });
                })
                .catch(error => {
                    console.error(error);
                    citySelect.innerHTML = '<option value="">Erreur lors du chargement</option>';
                });
            });

            // Déclencher le chargement des villes au chargement initial si un pays est déjà sélectionné
            if (countrySelect.value) {
                countrySelect.dispatchEvent(new Event('change'));
            }
        });

        document.getElementById('addPropertyForm').addEventListener('submit', async function(e) {
            e.preventDefault();
        
            const submitBtn = this.querySelector('button[type="submit"]');
            const originalText = submitBtn.innerHTML;
            
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Envoi en cours...';
            submitBtn.disabled = true;
            
            try {
                const formData = new FormData(this);
                const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content;
                if(csrfToken) {
                    formData.append('_token', csrfToken);
                }

                console.log('Form data:', Object.fromEntries(formData));

                const response = await fetch('/api/property/add', {
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
                    text: 'Propriété ajoutée avec succès',
                    timer: 5000,
                    showConfirmButton: false,
                    position: 'top-end',
                    toast: true
                });

                // const modal = bootstrap.Modal.getInstance(document.getElementById('demandPartnariaModal'));
                // modal.hide();
                this.reset();
                
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
document.addEventListener('DOMContentLoaded', function () {
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
    marker.on('dragend', function (e) {
        const pos = marker.getLatLng();
        latitudeInput.value = pos.lat.toFixed(6);
        longitudeInput.value = pos.lng.toFixed(6);
    });

    // Bouton pour localiser automatiquement l'utilisateur
    locationButton.addEventListener('click', function (e) {
        e.preventDefault();
        if (!navigator.geolocation) {
            alert('La géolocalisation n’est pas supportée par ce navigateur.');
            return;
        }

        navigator.geolocation.getCurrentPosition(function (position) {
            const lat = position.coords.latitude;
            const lng = position.coords.longitude;

            latitudeInput.value = lat.toFixed(6);
            longitudeInput.value = lng.toFixed(6);

            // Déplacer le marqueur et centrer la carte
            marker.setLatLng([lat, lng]);
            map.setView([lat, lng], 16);
        }, function (error) {
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
