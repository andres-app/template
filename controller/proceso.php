<?php
require_once("../models/Proceso.php");

$proceso = new Proceso();

switch ($_GET["op"]) {
    case "listar":
        // Obtener todos los procesos
        $procesos = $proceso->obtenerProcesos();
        echo json_encode($procesos);
        break;

    case "listarEventos":
        // Verificar si se ha proporcionado un ID de proceso
        if (isset($_GET['id'])) {
            $proceso_id = intval($_GET['id']);
            $eventos = $proceso->obtenerEventosProceso($proceso_id);
            echo json_encode($eventos);
        } else {
            echo json_encode(["error" => "No se ha proporcionado un ID de proceso."]);
        }
        break;

    default:
        echo json_encode(["error" => "Operación no válida."]);
        break;
}
