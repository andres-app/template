<?php
require_once("../../config/conexion.php");
require_once("../../models/Requerimiento.php");
require_once("../../models/Rol.php");

$rol = new Rol();
$datos = $rol->validar_menu_x_rol($_SESSION["rol_id"], "iniciocolaborador");

if (isset($_SESSION["usu_id"]) && count($datos) > 0) {

    $requerimiento = new Requerimiento();
    $data_total = $requerimiento->get_total_requerimientos();
    $total_requerimientos = isset($data_total["total"]) ? (int)$data_total["total"] : 0;
?>
<!doctype html>
<html lang="es">
<head>
    <title>Análisis de Casos por Requerimiento</title>
    <?php require_once("../html/head.php") ?>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body>
<div id="layout-wrapper">
    <?php require_once("../html/header.php") ?>
    <?php require_once("../html/menu.php") ?>

    <div class="main-content">
        <div class="page-content">
            <div class="container-fluid">

                <h4 class="mb-4 text-center">Análisis de Casos por Requerimiento</h4>

                <div class="row mb-4">
                    <!-- Total Requerimientos -->
                    <div class="col-md-4">
                        <div class="card text-center">
                            <div class="card-body">
                                <h6 class="text-muted">Total Requerimientos</h6>
                                <h2 class="fw-bold"><?= $total_requerimientos; ?></h2>
                            </div>
                        </div>
                    </div>

                    <!-- Total Casos de Prueba (maqueta) -->
                    <div class="col-md-4">
                        <div class="card text-center">
                            <div class="card-body">
                                <h6 class="text-muted">Total Casos de Prueba</h6>
                                <h2 class="fw-bold">280</h2>
                            </div>
                        </div>
                    </div>

                    <!-- Porcentaje Ejecutado (maqueta) -->
                    <div class="col-md-4">
                        <div class="card text-center">
                            <div class="card-body">
                                <h6 class="text-muted">% Casos Ejecutados</h6>
                                <h2 class="fw-bold text-success">65%</h2>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <!-- Seguimiento por Órgano Jurisdiccional -->
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-header text-center">Seguimiento por Órgano Jurisdiccional</div>
                            <div class="card-body">
                                <canvas id="chartJurisdiccion"></canvas>
                            </div>
                        </div>
                    </div>

                    <!-- Seguimiento por Especialidad -->
                    <div class="col-md-8">
                        <div class="card">
                            <div class="card-header text-center">Seguimiento por Especialidad</div>
                            <div class="card-body">
                                <canvas id="chartEspecialidad"></canvas>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row mt-4">
                    <!-- Línea de tiempo de ejecución -->
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header text-center">Línea de Tiempo de Ejecución</div>
                            <div class="card-body">
                                <canvas id="chartLineaTiempo"></canvas>
                            </div>
                        </div>
                    </div>

                    <!-- Avance por Requerimiento -->
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header text-center">Avance por Requerimiento</div>
                            <div class="card-body">
                                <canvas id="chartAvance"></canvas>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row mt-4">
                    <!-- Tabla Detallada -->
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header text-center">Tabla Detallada de Seguimiento</div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-sm table-bordered align-middle">
                                        <thead class="table-light">
                                            <tr>
                                                <th>Código Requerimiento</th>
                                                <th>Nombre Requerimiento</th>
                                                <th>Código Caso de Prueba</th>
                                                <th>Estado</th>
                                                <th>Fecha</th>
                                                <th>Observaciones</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr><td>3.2.1.2</td><td>Registro</td><td>PR-001</td><td>PENDIENTE</td><td>12/01</td><td>En revisión</td></tr>
                                            <tr><td>3.2.1.3</td><td>Consultas</td><td>PR-002</td><td>EN EJECUCIÓN</td><td>13/01</td><td>Pruebas en curso</td></tr>
                                            <tr><td>3.2.1.5</td><td>Gestión</td><td>PR-003</td><td>APROBADO</td><td>14/01</td><td>Validado</td></tr>
                                        </tbody>
                                    </table>
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

<!-- ========== Chart.js Scripts ========== -->
<!-- Colores actualizados: fríos, sutiles y con degradado -->
<script>
const gradient = (ctx, color1, color2) => {
    const gradient = ctx.createLinearGradient(0, 0, 0, 300);
    gradient.addColorStop(0, color1);
    gradient.addColorStop(1, color2);
    return gradient;
};

const ctxJur = document.getElementById('chartJurisdiccion').getContext('2d');
new Chart(ctxJur, {
    type: 'doughnut',
    data: {
        labels: ['Laboral', 'Familiar', 'Civil'],
        datasets: [{
            data: [40, 35, 25],
            backgroundColor: [
                gradient(ctxJur, '#9cc3d5ff', '#b9d9ebff'),
                gradient(ctxJur, '#a7c7e7', '#d4e7f5'),
                gradient(ctxJur, '#bcd4e6', '#e4f0f6')
            ],
            borderWidth: 0
        }]
    },
    options: {
        plugins: {
            legend: { position: 'bottom', labels: { color: '#4b5563' } }
        },
        cutout: '70%',
        responsive: true
    }
});

const ctxEsp = document.getElementById('chartEspecialidad').getContext('2d');
new Chart(ctxEsp, {
    type: 'bar',
    data: {
        labels: ['Laboral', 'Familiar', 'Civil'],
        datasets: [
            { label: 'Aprobado', data: [20, 15, 10], backgroundColor: gradient(ctxEsp, '#91bad6', '#b9d9eb') },
            { label: 'En Ejecución', data: [15, 10, 8], backgroundColor: gradient(ctxEsp, '#a5c8dd', '#d4e7f5') },
            { label: 'Pendiente', data: [5, 10, 7], backgroundColor: gradient(ctxEsp, '#d2e3ee', '#edf4fa') }
        ]
    },
    options: {
        plugins: {
            legend: { position: 'bottom', labels: { color: '#4b5563' } }
        },
        scales: {
            x: { stacked: true, grid: { display: false }, ticks: { color: '#6b7280' } },
            y: { stacked: true, ticks: { color: '#6b7280' } }
        },
        responsive: true
    }
});

const ctxLinea = document.getElementById('chartLineaTiempo').getContext('2d');
new Chart(ctxLinea, {
    type: 'line',
    data: {
        labels: ['1-Jul', '1-Ago', '1-Sep', '1-Oct', '1-Nov', '1-Dic'],
        datasets: [{
            label: 'Requerimientos',
            data: [10, 25, 40, 55, 75, 100],
            borderColor: '#7faac8',
            backgroundColor: 'rgba(127, 170, 200, 0.2)',
            fill: true,
            tension: 0.4,
            pointRadius: 4,
            pointBackgroundColor: '#4b9cd3'
        }]
    },
    options: {
        plugins: { legend: { display: false } },
        scales: {
            x: { ticks: { color: '#6b7280' } },
            y: { ticks: { color: '#6b7280' } }
        },
        responsive: true
    }
});

const ctxAvance = document.getElementById('chartAvance').getContext('2d');
new Chart(ctxAvance, {
    type: 'bar',
    data: {
        labels: ['Startvi', 'Consultas', 'Registro'],
        datasets: [
            { label: 'Aprobado', data: [5, 8, 6], backgroundColor: gradient(ctxAvance, '#9ec5d3', '#cfe5f3') },
            { label: 'En Ejecución', data: [10, 7, 8], backgroundColor: gradient(ctxAvance, '#b2d3e0', '#e0f1f8') },
            { label: 'Pendiente', data: [3, 5, 2], backgroundColor: gradient(ctxAvance, '#dce9f2', '#f1f7fa') }
        ]
    },
    options: {
        plugins: {
            legend: { position: 'bottom', labels: { color: '#4b5563' } }
        },
        scales: {
            x: { stacked: true, grid: { display: false }, ticks: { color: '#6b7280' } },
            y: { stacked: true, ticks: { color: '#6b7280' } }
        },
        responsive: true
    }
});
</script>


</body>
</html>
<?php
} else {
    header("Location:" . Conectar::ruta() . "index.php");
}
?>
