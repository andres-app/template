<?php
require_once("../../config/conexion.php");
require_once("../../models/Rol.php");
$rol = new Rol();
$datos = $rol->validar_menu_x_rol($_SESSION["rol_id"], "seguimiento");
if (isset($_SESSION["usu_id"]) and count($datos) > 0) {
    ?>
    <!doctype html>
    <html lang="es">

    <head>
        <title>TEMPLATE</title>
        <?php require_once("../html/head.php") ?>
        <style>
            .iframe-container {
                position: relative;
                width: 100%;
                height: 100vh;
                /* Altura al 100% de la pantalla */
                overflow: hidden;
                /* box-shadow: 0 0 15px rgba(0, 0, 0, 0.2);
                    border-radius: 10px; */
                margin-top: 20px;
            }

            .iframe-container iframe {
                position: absolute;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                /* Asegura que el iframe llene todo el contenedor */
                border: 0;
            }
        </style>
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
                                    <h4 class="mb-sm-0 font-size-18">Seguimiento</h4>
                                </div>
                            </div>

                            <!-- Contenedor del iframe ajustado a la pantalla -->
                            <div class="col-12">
                                <div class="iframe-container">
                                    <iframe src="https://www.example.com" allowFullScreen="true">Sin url</iframe>
                                </div>
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