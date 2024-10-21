<!-- view/procesos/index.php -->
<?php
require_once("../../config/conexion.php");
require_once("../../models/Rol.php");
$rol = new Rol();
$datos = $rol->validar_menu_x_rol($_SESSION["rol_id"], "procesos");

if (isset($_SESSION["usu_id"]) && count($datos) > 0) {
    ?>
    <!doctype html>
    <html lang="es">

    <head>
        <title>TEMPLATE | Procesos</title>
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
                                    <h4 class="mb-sm-0 font-size-18">Procesos</h4>

                                    <div class="page-title-right">
                                        <ol class="breadcrumb m-0">
                                            <li class="breadcrumb-item"><a href="javascript: void(0);">Pages</a></li>
                                            <li class="breadcrumb-item active">Procesos</li>
                                        </ol>
                                    </div>

                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <div class="card">
                                        <div class="card-body">
                                            <h4 class="card-title">Procesos de Compra</h4>

                                            <!-- Contenedor con clase table-responsive para habilitar el scroll horizontal -->
                                            <div class="table-responsive">
                                                <table id="datatable-buttons"
                                                    class="table table-bordered dt-responsive nowrap w-100">
                                                    <thead>
                                                        <tr>
                                                            <th>Número de SINAD</th>
                                                            <th>Dirección</th>
                                                            <th>Grupo</th>
                                                            <th>Obtención</th>
                                                            <th>Nombre</th>
                                                            <th>Estado Actual</th>
                                                            <th>Fecha de Inicio</th>
                                                            <th>Acciones</th> <!-- Nueva columna para las acciones -->
                                                        </tr>
                                                    </thead>
                                                    <tbody id="procesos-table-body">
                                                        <!-- Aquí se llenarán los procesos -->
                                                    </tbody>
                                                </table>
                                            </div> <!-- End table-responsive -->
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
    // Realizar la llamada al servidor para obtener los procesos
    fetch("../../controller/proceso.php?op=listar")
        .then(response => {
            // Verificar si la respuesta es correcta
            if (!response.ok) {
                throw new Error('Error en la respuesta del servidor');
            }
            return response.json(); // Convertir la respuesta a JSON
        })
        .then(data => {
            // Aquí cargamos los datos en la tabla
            const tableBody = document.getElementById("procesos-table-body");
            let rows = "";

            if (data.length > 0) {
                // Iterar sobre cada proceso en los datos
                data.forEach(proceso => {
                    rows += `
                        <tr>
                            <td>${proceso.sinad || 'No disponible'}</td>
                            <td>${proceso.direc || 'No disponible'}</td>
                            <td>${proceso.grupo || 'No disponible'}</td>
                            <td>${proceso.obtencion || 'No disponible'}</td>
                            <td>${proceso.nombre || 'No disponible'}</td>
                            <td>${proceso.estado_actual || 'Sin estado'}</td>
                            <td>${proceso.fecha_inicio || 'No disponible'}</td>
                            <td><a href="timeline.php?id=${proceso.id}" class="btn btn-primary btn-sm">Ver Timeline</a></td>
                        </tr>
                    `;
                });
            } else {
                // Si no hay datos, mostrar un mensaje
                rows = '<tr><td colspan="8">No hay procesos disponibles</td></tr>';
            }

            // Insertar las filas generadas en el cuerpo de la tabla
            tableBody.innerHTML = rows;
        })
        .catch(error => {
            // Capturar y mostrar errores en la consola
            console.error('Error al cargar los procesos:', error);
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