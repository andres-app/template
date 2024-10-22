<div id="mnt_modal" class="modal fade" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form method="post" id="mnt_form">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="myModalLabel"></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="proceso_id" name="proceso_id">

                    <div class="mb-3">
                        <label class="form-label">Nombre del Proceso (*)</label>
                        <input class="form-control" type="text" name="proceso_nombre" id="proceso_nombre" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Descripción (*)</label>
                        <textarea class="form-control" name="proceso_descripcion" id="proceso_descripcion" required></textarea>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-primary">Guardar</button>
                </div>
            </div>
        </form>
    </div>
</div>
