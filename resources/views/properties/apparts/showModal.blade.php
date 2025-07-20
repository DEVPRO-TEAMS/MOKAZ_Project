<!-- MODAL Bootstrap simplifiée -->
<div class="modal fade" id="showApartmentModal{{ $apartement->apartement_code }}" tabindex="-1">
  <div class="modal-dialog modal-lg modal-dialog-scrollable">
    <div class="modal-content">
      
      <!-- Header -->
      <div class="modal-header bg-light">
        <h5 class="modal-title">
          <i class="bi bi-building"></i> Appartement Moderne 
          <span class="badge bg-secondary">APT-001</span>
        </h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      
      <!-- Body -->
      <div class="modal-body">
        
        <!-- Image principale -->
        <div class="position-relative">
          <img src="https://images.unsplash.com/photo-1522708323590-d24dbb6b0267?w=800&h=400&fit=crop" class="img-fluid rounded" alt="Appartement">
          <span class="badge bg-success position-absolute top-0 start-0 m-3">
            <i class="bi bi-check-circle"></i> Disponible
          </span>
          <span class="badge bg-danger position-absolute bottom-0 end-0 m-3 fs-6">
            <i class="bi bi-currency-euro"></i> 1 200 €/mois
          </span>
        </div>

        <!-- Infos générales -->
        <div class="row mt-4">
          <div class="col-md-6">
            <h6 class="text-danger"><i class="bi bi-info-circle"></i> Informations générales</h6>
            <ul class="list-group list-group-flush small">
              <li class="list-group-item"><i class="bi bi-house-door"></i> Type : <strong>T3</strong></li>
              <li class="list-group-item"><i class="bi bi-bed"></i> Chambres : <strong>2</strong></li>
              <li class="list-group-item"><i class="bi bi-droplet"></i> Salles de bain : <strong>1</strong></li>
              <li class="list-group-item"><i class="bi bi-geo-alt"></i> Code Propriété : <strong>PROP-001</strong></li>
            </ul>
          </div>
          <div class="col-md-6">
            <h6 class="text-danger"><i class="bi bi-gear"></i> État & Gestion</h6>
            <ul class="list-group list-group-flush small">
              <li class="list-group-item"><i class="bi bi-toggle-on"></i> État : <strong>Actif</strong></li>
              <li class="list-group-item"><i class="bi bi-person-plus"></i> Créé par : <strong>Admin</strong></li>
              <li class="list-group-item"><i class="bi bi-person-gear"></i> MAJ par : <strong>Manager</strong></li>
              <li class="list-group-item"><i class="bi bi-calendar3"></i> Dernière MAJ : <strong>Aujourd'hui</strong></li>
            </ul>
          </div>
        </div>

        <!-- Description -->
        <div class="mt-4">
          <h6 class="text-danger"><i class="bi bi-align-start"></i> Description</h6>
          <p class="text-muted">
            Magnifique appartement moderne situé dans un quartier calme et résidentiel. 
            Entièrement rénové avec des finitions de qualité supérieure. Proche commerces et transports.
          </p>
        </div>

        <!-- Équipements -->
        <div class="mt-4">
          <h6 class="text-danger"><i class="bi bi-star"></i> Équipements & Commodités</h6>
          <div class="row">
            <div class="col-md-4">
              <h6 class="fw-bold small mt-3"><i class="bi bi-shield"></i> Sécurité</h6>
              <span class="badge rounded-pill bg-light text-danger border">Alarme</span>
              <span class="badge rounded-pill bg-light text-danger border">Digicode</span>
              <span class="badge rounded-pill bg-light text-danger border">Interphone</span>
            </div>
            <div class="col-md-4">
              <h6 class="fw-bold small mt-3"><i class="bi bi-bed"></i> Chambre</h6>
              <span class="badge rounded-pill bg-light text-danger border">Placard</span>
              <span class="badge rounded-pill bg-light text-danger border">Climatisation</span>
              <span class="badge rounded-pill bg-light text-danger border">Parquet</span>
            </div>
            <div class="col-md-4">
              <h6 class="fw-bold small mt-3"><i class="bi bi-utensils"></i> Cuisine</h6>
              <span class="badge rounded-pill bg-light text-danger border">Équipée</span>
              <span class="badge rounded-pill bg-light text-danger border">Lave-vaisselle</span>
              <span class="badge rounded-pill bg-light text-danger border">Réfrigérateur</span>
              <span class="badge rounded-pill bg-light text-danger border">Four</span>
            </div>
          </div>
        </div>

        <!-- Vidéo -->
        <div class="mt-4">
          <h6 class="text-danger"><i class="bi bi-camera-video"></i> Visite virtuelle</h6>
          <div class="ratio ratio-16x9 mt-2">
            <iframe src="https://www.youtube.com/embed/dQw4w9WgXcQ" title="Visite virtuelle" allowfullscreen></iframe>
          </div>
        </div>
        
      </div>

      <!-- Footer -->
      <div class="modal-footer">
        <button class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
        <button class="btn btn-danger">Réserver</button>
      </div>

    </div>
  </div>
</div>
