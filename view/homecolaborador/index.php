<?php
require_once("../../config/conexion.php");
require_once("../../models/Rol.php");
$rol = new Rol();
$datos = $rol->validar_menu_x_rol($_SESSION["rol_id"], "iniciocolaborador");
if (isset($_SESSION["usu_id"]) and count($datos) > 0) {
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

                        <div class="row">
                            <div class="col-12">
                                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                                    <h4 class="mb-sm-0 font-size-18">Inicio Colaborador</h4>


                                </div>
                            </div>

                            <div class="card border border-primary">
                                <div class="card-header bg-transparent border-primary">
                                    <h5 class="my-0 text-primary"><i class="mdi mdi-bullseye-arrow me-3"></i>Estimado colaborador</h5>
                                </div>
                                <div class="card-body">
                                    <h5 class="card-title">¡IMPORTANTE! </h5>
                                    <p class="card-text">Usted únicamente tiene acceso a la información que ha sido específicamente asignada por el equipo de administración del sistema. Es fundamental que toda la información presentada se maneje con el más alto nivel de confidencialidad y responsabilidad. La divulgación de cualquier dato no autorizado puede comprometer la seguridad del sistema y la integridad de los procesos internos. Por ello, se recalca la importancia de no compartir, transferir o difundir la información a terceros, ni dentro ni fuera de la organización, salvo con la debida autorización. La adecuada gestión y resguardo de los datos asegura la confiabilidad del sistema y el cumplimiento de las normativas vigentes en materia de protección de la información..</p>
                                    
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