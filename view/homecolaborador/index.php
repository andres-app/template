<?php
require_once("../../config/conexion.php");
require_once("../../models/Vehiculo.php");
require_once("../../models/Rol.php");

$rol = new Rol();
$datos = $rol->validar_menu_x_rol($_SESSION["rol_id"], "iniciocolaborador");

if (isset($_SESSION["usu_id"]) && count($datos) > 0) {
    // Crear instancia del modelo Vehículo
    $vehiculo = new Vehiculo();
    
    // Obtener vehículos con próximos mantenimientos
    $total_vehiculos = $vehiculo->get_total_vehiculos();
    $proximos_mantenimientos = $vehiculo->get_proximos_mantenimientos();
    ?>
    <!doctype html>
    <html lang="es">

    <head>
        <title> Inicio TEMPLATE</title>
        <?php require_once("../html/head.php") ?>
    </head>

    <body>

        <div id="layout-wrapper">

            <?php require_once("../html/header.php") ?>

            <?php require_once("../html/menu.php") ?>

            <div class="main-content">

                <div class="page-content">
                    <div class="container-fluid">

                        <!-- Título de la página -->
                        <div class="row">
                            <div class="col-12">
                                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                                    <h4 class="mb-sm-0 font-size-18">DASHBOARD</h4>
                                </div>
                            </div>
                        </div>
                
                        <div class="row">
                    <!-- Card para el total de vehículos -->
                    <div class="col-xl-3">
                        <div class="card text-center">
                            <div class="card-header bg-primary text-white">
                                <h5 class="my-0 text-white">
                                    <i class="mdi mdi-car-multiple me-2 text-white"></i>Total de Vehículos
                                </h5>
                            </div>
                            <div class="card-body">
                                <h3 class="card-title"><?= $total_vehiculos; ?></h3>
                            </div>
                        </div>
                    </div>
                    </div>
                        <!-- Tarjeta para mostrar los próximos mantenimientos -->
                        <div class="row">
                            <div class="col-xl-4">
                                <div class="card">
                                    <div class="card-header align-items-center d-flex">
                                        <h4 class="card-title mb-0 flex-grow-1">Próximos Mantenimientos</h4>
                                    </div>
                                    <div class="card-body px-0">
                                        <div class="px-3" data-simplebar="" style="max-height: 352px;">
                                            <ul class="list-unstyled activity-wid mb-0">
                                                <?php
                                                if (count($proximos_mantenimientos) > 0) {
                                                    foreach ($proximos_mantenimientos as $mantenimiento) {
                                                        ?>
                                                        <li class="activity-list activity-border">
                                                            <div class="activity-icon avatar-md">
                                                                <span class="avatar-title bg-soft-warning text-warning rounded-circle">
                                                                    <i class="bx bx-wrench font-size-24"></i>
                                                                </span>
                                                            </div>
                                                            <div class="timeline-list-item">
                                                                <div class="d-flex">
                                                                    <div class="flex-grow-1 overflow-hidden me-4">
                                                                        <h5 class="font-size-14 mb-1"><?= $mantenimiento['placa']; ?></h5>
                                                                        <p class="text-truncate text-muted font-size-13"><?= $mantenimiento['fecha_proximo_mantenimiento']; ?></p>
                                                                    </div>
                                                                    <div class="flex-shrink-0 text-end me-3">
                                                                        <h6 class="mb-1">Vehículo: <?= $mantenimiento['marca'] . " " . $mantenimiento['modelo']; ?></h6>
                                                                        <div class="font-size-13">Año: <?= $mantenimiento['anio']; ?></div>
                                                                    </div>
                                                                </div>
                                                            </div> 
                                                        </li>
                                                        <?php
                                                    }
                                                } else {
                                                    ?>
                                                    <li class="activity-list activity-border">
                                                        <div class="activity-icon avatar-md">
                                                            <span class="avatar-title bg-soft-primary text-primary rounded-circle">
                                                                <i class="bx bx-wrench font-size-24"></i>
                                                            </span>
                                                        </div>
                                                        <div class="timeline-list-item">
                                                            <div class="d-flex">
                                                                <div class="flex-grow-1 overflow-hidden me-4">
                                                                    <h5 class="font-size-14 mb-1">No hay mantenimientos próximos</h5>
                                                                </div>
                                                            </div>
                                                        </div> 
                                                    </li>
                                                    <?php
                                                }
                                                ?>
                                            </ul>
                                        </div>    
                                    </div>
                                    <!-- end card body -->
                                </div>
                                <!-- end card -->
                            </div>
                        </div>

                    </div>
                </div>

                <?php require_once("../html/footer.php") ?>

            </div>

        </div>

        <?php require_once("../html/sidebar.php") ?>

        <div class="rightbar-overlay"></div>

        <?php require_once("../html/js.php") ?>

    </body>

    </html>
    <?php
} else {
    header("Location:" . Conectar::ruta() . "index.php");
}
?>
