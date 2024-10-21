<?php
require_once("../../config/conexion.php");
require_once("../../models/Rol.php");
$rol = new Rol();
$datos = $rol->validar_menu_x_rol($_SESSION["rol_id"], "procesos");

if (isset($_SESSION["usu_id"]) && count($datos) > 0) {
    if (!isset($_GET['id'])) {
        echo "No se ha proporcionado un ID de proceso.";
        exit;
    }
    
    $proceso_id = $_GET['id'];
    ?>
    <!doctype html>
    <html lang="es">

    <head>
        <title>TEMPLATE | Timeline</title>
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
                                    <h4 class="mb-sm-0 font-size-18">Timeline</h4>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h4 class="card-title">Eventos del Proceso</h4>
                                    </div>

                                    <div class="card-body">
                                        <div class="row justify-content-center">
                                            <div class="col-xl-10">
                                                <div class="timeline">
                                                    <div class="timeline-container" id="timeline-container">
                                                        <!-- Aquí se mostrarán los eventos dinámicamente -->
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
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

        <script>
       document.addEventListener("DOMContentLoaded", function () {
    const timelineContainer = document.getElementById("timeline-container");
    const procesoId = <?php echo json_encode($proceso_id); ?>;

    fetch(`../../controller/proceso.php?op=listarEventos&id=${procesoId}`)
        .then(response => response.json())
        .then(data => {
            let timelineHtml = `<div class="timeline-end"><p>Inicio</p></div><div class="timeline-continue">`;
            let counter = 0;

            data.forEach(evento => {
                const sideClass = (counter % 2 === 0) ? 'timeline-right' : 'timeline-left';

                // Parseamos la fecha evitando la conversión automática de zonas horarias
                const fecha = new Date(evento.fecha_evento + 'T00:00:00');
                const dia = fecha.getUTCDate();  // Usar getUTCDate para evitar ajustes automáticos
                const mes = fecha.toLocaleString('es-ES', { month: 'long' });

                timelineHtml += `
                    <div class="row ${sideClass}">
                        <div class="col-md-6 ${sideClass === 'timeline-right' ? 'order-md-2' : ''}">
                            <div class="timeline-box">
                                <div class="timeline-date bg-primary text-center rounded">
                                    <h3 class="text-white mb-0">${dia}</h3>
                                    <p class="mb-0 text-white-50">${mes}</p>
                                </div>
                                <div class="event-content">
                                    <div class="timeline-text">
                                        <h3 class="font-size-18">${evento.tipo_evento}</h3>
                                        <p class="mb-0 mt-2 pt-1 text-muted">${evento.descripcion_evento}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 ${sideClass === 'timeline-right' ? '' : 'order-md-2'}">
                            <div class="timeline-icon">
                                <i class="bx bx-briefcase-alt-2 text-primary h2 mb-0"></i>
                            </div>
                        </div>
                    </div>
                `;
                counter++;
            });

            timelineHtml += `<div class="timeline-start"><p>Fin</p></div></div>`;
            timelineContainer.innerHTML = timelineHtml;
        })
        .catch(error => {
            console.error('Error al cargar el timeline:', error);
        });
});

        </script>
    </body>

    </html>
    <?php
} else {
    header("Location:" . Conectar::ruta() . "index.php");
}
?>
