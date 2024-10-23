<?php
    // Requerimos los archivos necesarios para la conexión y el modelo de Rol
    require_once("../../config/conexion.php");
    require_once("../../models/Rol.php");

    // Crear una instancia de Rol para validar permisos
    $rol = new Rol();

    // Validar si el rol del usuario tiene acceso al módulo de "vehículos"
    $datos = $rol->validar_menu_x_rol($_SESSION["rol_id"], "vehiculos");

    // Verificar si el usuario está autenticado y si tiene permisos para acceder al módulo
    if (isset($_SESSION["usu_id"]) && count($datos) > 0) {
?>

<!doctype html>
<html lang="es">
    <head>
        <!-- Título de la página -->
        <title>Mnt.Vehículo DIGESE</title>
        
        <!-- Incluir los archivos del head -->
        <?php require_once("../html/head.php") ?>
    </head>

    <body>

        <div id="layout-wrapper">

            <!-- Incluir el header -->
            <?php require_once("../html/header.php") ?>

            <!-- Incluir el menú de navegación -->
            <?php require_once("../html/menu.php") ?>

            <div class="main-content">

                <div class="page-content">
                    <div class="container-fluid">

                        <!-- Título y breadcrumb de la página -->
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
                        </div>

                        <!-- Sección principal de la página -->
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h4 class="card-title">Vehículo</h4>
                                        <p class="card-title-desc">(*) Vista para Registrar, Modificar, Listar y Eliminar.</p>
                                    </div>

                                    <div class="card-body">
                                        <!-- Botón para agregar un nuevo vehículo -->
                                        <button type="button" id="btnnuevo" class="btn btn-primary waves-effect waves-light">
                                            Nuevo Registro
                                        </button>
                                        <br><br>

                                        <!-- Tabla para listar los vehículos -->
                                        <table id="listado_table" class="table table-bordered dt-responsive nowrap w-100">
                                            <thead>
                                                <tr>
                                                    <th>Placa</th>
                                                    <th>Marca</th>
                                                    <th>Modelo</th>
                                                    <th>Año</th>
                                                    <th>Último Mantenimiento</th>
                                                    <th>Próximo Mantenimiento</th>
                                                    <th>Acciones</th>
                                                </tr>
                                            </thead>

                                            <tbody>
                                                <!-- Aquí se llenará la tabla con los datos -->
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                    </div> <!-- Container-fluid -->
                </div> <!-- Page-content -->

                <!-- Incluir el footer -->
                <?php require_once("../html/footer.php") ?>

            </div> <!-- Main-content -->

        </div> <!-- Layout-wrapper -->

        <!-- Incluir el modal para el formulario de vehículo -->
        <?php require_once("modal_vehiculo.php") ?>

        <!-- Incluir la barra lateral -->
        <?php require_once("../html/sidebar.php") ?>

        <div class="rightbar-overlay"></div>

        <!-- Incluir los scripts JS -->
        <?php require_once("../html/js.php") ?>

        <!-- Incluir el script de la página para manejar los vehículos -->
        <script type="text/javascript" src="vehiculo.js"></script>

    </body>
</html>

<?php
    } else {
        // Redirigir al usuario al inicio de sesión si no tiene acceso o no está autenticado
        header("Location:" . Conectar::ruta() . "index.php");
    }
?>
