<?php
    require_once("../../config/conexion.php");
    require_once("../../models/Rol.php");
    $rol = new Rol();
    $datos = $rol->validar_menu_x_rol($_SESSION["rol_id"],"vehiculos");
    
    if(isset($_SESSION["usu_id"]) and count($datos)>0){
?>
<!doctype html>
<html lang="es">
    <head>
        <title> Mnt.Vehículo DIGESE</title>
        <?php require_once("../html/head.php")?>
    </head>

    <body>

        <div id="layout-wrapper">

            <?php require_once("../html/header.php")?>

            <?php require_once("../html/menu.php")?>

            <div class="main-content">

                <div class="page-content">
                    <div class="container-fluid">

                        <div class="row">
                            <div class="col-12">
                                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                                    <h4 class="mb-sm-0 font-size-18">Lista de Vehículos</h4>

                                    <div class="page-title-right">
                                        <ol class="breadcrumb m-0">
                                            <li class="breadcrumb-item"><a href="javascript: void(0);">Pages</a></li>
                                            <li class="breadcrumb-item active">Starter Page</li>
                                        </ol>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="card">
                                        <div class="card-header">
                                            <h4 class="card-title">Vehículo</h4>
                                            <p class="card-title-desc">(*) Vista para Registrar, Modificar, Listar y Eliminar. </p>
                                        </div>

                                        <div class="card-body">
                                            <button type="button" id="btnnuevo" class="btn btn-primary waves-effect waves-light">Nuevo Registro</button>
                                            <br>
                                            <br>
                                            <table id="listado_table" class="table table-bordered dt-responsive  nowrap w-100">
                                                <thead>
                                                    <tr>
                                                        <th>Placa</th>
                                                        <th>Marca</th>
                                                        <th>Modelo</th>
                                                        <th>Año</th>
                                                        <th>Acciones</th>
                                                    </tr>
                                                </thead>

                                                <tbody>

                                                </tbody>
                                            </table>
                                        </div>

                                    </div>
                                </div>
                            </div>
                            
                        </div>

                    </div>
                </div>

                <?php require_once("../html/footer.php")?>

            </div>

        </div>

        <?php require_once("modal_vehiculo.php")?>

        <?php require_once("../html/sidebar.php")?>

        <div class="rightbar-overlay"></div>

        <?php require_once("../html/js.php")?>

        <script type="text/javascript" src="vehiculo.js"></script>

    </body>
</html>
<?php
  }else{
    header("Location:".Conectar::ruta()."index.php");
  }
?>

<div id="mnt_modal" class="modal fade" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form method="post" id="mnt_form">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="myModalLabel"></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="vehiculo_id" name="vehiculo_id">

                    <div class="mb-3">
                        <label for="form-label" class="form-label">Placa (*)</label>
                        <input class="form-control" type="text" name="vehiculo_placa" id="vehiculo_placa" required>
                    </div>

                    <div class="mb-3">
                        <label for="form-label" class="form-label">Marca (*)</label>
                        <input class="form-control" type="text" name="vehiculo_marca" id="vehiculo_marca" required>
                    </div>

                    <div class="mb-3">
                        <label for="form-label" class="form-label">Modelo (*)</label>
                        <input class="form-control" type="text" name="vehiculo_modelo" id="vehiculo_modelo" required>
                    </div>

                    <div class="mb-3">
                        <label for="form-label" class="form-label">Año (*)</label>
                        <input class="form-control" type="number" name="vehiculo_anio" id="vehiculo_anio" required>
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
