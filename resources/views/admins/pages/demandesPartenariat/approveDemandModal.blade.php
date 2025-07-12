<div class="modal fade" id="approveModal" tabindex="-1" aria-labelledby="approveModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form method="POST" action="">
        @csrf
        <input type="hidden" name="id" id="approve-id">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Approuver la demande</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>Voulez-vous approuver la demande de <strong id="approve-nom"></strong> ?</p>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-success">Approuver</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
            </div>
        </div>
    </form>
  </div>
</div>
