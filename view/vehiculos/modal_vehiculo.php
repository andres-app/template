<div id="mnt_modal" class="modal fade" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form method="post" id="mnt_form">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="myModalLabel">Registro de Vehículo</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="vehiculo_id" name="vehiculo_id">

                    <div class="mb-3">
                        <label for="vehiculo_placa" class="form-label">Placa (*)</label>
                        <input class="form-control" type="text" name="vehiculo_placa" id="vehiculo_placa" required>
                    </div>

                    <div class="mb-3">
                        <label for="vehiculo_marca" class="form-label">Marca (*)</label>
                        <input class="form-control" type="text" name="vehiculo_marca" id="vehiculo_marca" required>
                    </div>

                    <div class="mb-3">
                        <label for="vehiculo_modelo" class="form-label">Modelo (*)</label>
                        <input class="form-control" type="text" name="vehiculo_modelo" id="vehiculo_modelo" required>
                    </div>

                    <div class="mb-3">
                        <label for="vehiculo_anio" class="form-label">Año (*)</label>
                        <input class="form-control" type="number" name="vehiculo_anio" id="vehiculo_anio" required>
                    </div>

                    <div class="mb-3">
                        <label for="vehiculo_color" class="form-label">Color</label>
                        <input class="form-control" type="text" name="vehiculo_color" id="vehiculo_color">
                    </div>

                    <div class="mb-3">
                        <label for="vehiculo_motor" class="form-label">Motor</label>
                        <input class="form-control" type="text" name="vehiculo_motor" id="vehiculo_motor">
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary waves-effect" data-bs-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-primary waves-effect waves-light">Guardar</button>
                </div>
            </div>
        </form>
    </div>
</div>
