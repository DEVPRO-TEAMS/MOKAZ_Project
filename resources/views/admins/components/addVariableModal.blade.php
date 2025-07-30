<!-- Modal d'ajout -->
<div class="modal fade" id="addVariableModal" tabindex="-1" aria-labelledby="addVariableModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-light" id="addVariableModalLabel">
                    <i class="bi bi-plus-circle me-2 text-light"></i>Nouvelle Variable
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form  method="POST" action="{{ route('setting.storeVariable') }}" class="submitForm">
                @csrf
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-sm-12 col-md-12">
                            <label for="add_libelle" class="form-label">Libellé <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="add_libelle" name="libelle" required>
                            <div class="invalid-feedback"></div>
                        </div>
                        <div class="col-md-6">
                            <label for="add_type" class="form-label">Type <span class="text-danger">*</span></label>
                            <select class="form-select" id="add_type" name="type" required>
                                <option value="" disabled>Sélectionner un type</option>
                                <option value="commodity">Commodité</option>
                                <option value="type_of_property">Type de bien</option>
                                <option value="type_of_appart">Type d'appart</option>
                                <option value="autre">Autre</option>
                            </select>
                            <div class="invalid-feedback"></div>
                        </div>
                        <div class="col-md-6">
                            <label for="add_category" class="form-label">Catégorie <span class="text-danger">*</span></label>
                            <select class="form-select" id="add_category" name="category" required>
                                <option value="" disabled>Sélectionner une catégorie</option>
                                <option value="config">Configuration</option>
                                <option value="system">Système</option>
                                <option value="user">Utilisateur</option>
                                <option value="business">Business</option>
                            </select>
                            <div class="invalid-feedback"></div>
                        </div>
                        <div class="col-12">
                            <label for="add_description" class="form-label">Description</label>
                            <textarea class="form-control" id="add_description" name="description" rows="3" maxlength="500"></textarea>
                            <div class="form-text">Maximum 500 caractères</div>
                            <div class="invalid-feedback"></div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                    <button type="submit" class="btn btn-success">
                        <span class="spinner-border spinner-border-sm d-none me-2" role="status"></span>
                        <i class="bi bi-check-circle me-2"></i>Créer
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>