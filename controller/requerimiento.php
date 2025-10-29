<?php
require_once("../config/conexion.php");
require_once("../models/Requerimiento.php");

// Instancia del modelo
$requerimiento = new Requerimiento();

// Evaluar la operación enviada por AJAX
switch ($_GET["op"]) {

    // 🧾 LISTAR TODOS LOS REQUERIMIENTOS
    case "listar":
        $datos = $requerimiento->get_requerimientos();

        if ($datos === false) {
            echo json_encode(["error" => "Error al obtener los requerimientos"]);
            exit;
        }

        $data = array();

        foreach ($datos as $row) {
            $sub_array = array();
            $sub_array[] = $row["id_requerimiento"];
            $sub_array[] = $row["codigo"];
            $sub_array[] = $row["nombre"];
            $sub_array[] = $row["tipo"];
            $sub_array[] = $row["prioridad"];
            $sub_array[] = $row["estado_validacion"];
            $sub_array[] = $row["version"];
            $sub_array[] = $row["fecha_creacion"];

            // Botones de acción
            $sub_array[] = '
                <button type="button" class="btn btn-soft-warning btn-sm" onClick="editar(' . $row["id_requerimiento"] . ')">
                    <i class="bx bx-edit-alt font-size-16 align-middle"></i>
                </button>
                <button type="button" class="btn btn-soft-danger btn-sm" onClick="eliminar(' . $row["id_requerimiento"] . ')">
                    <i class="bx bx-trash-alt font-size-16 align-middle"></i>
                </button>
            ';

            $data[] = $sub_array;
        }

        $results = array(
            "sEcho" => 1,
            "iTotalRecords" => count($data),
            "iTotalDisplayRecords" => count($data),
            "aaData" => $data
        );

        header('Content-Type: application/json');
        echo json_encode($results);
        break;

    // 💾 GUARDAR O EDITAR REQUERIMIENTO
    case "guardar":
        $id = isset($_POST["id_requerimiento"]) ? intval($_POST["id_requerimiento"]) : 0;
        $codigo = trim($_POST["codigo"]);
        $nombre = trim($_POST["nombre"]);
        $tipo = trim($_POST["tipo"]);
        $prioridad = trim($_POST["prioridad"]);
        $estado_validacion = trim($_POST["estado_validacion"]);
        $version = trim($_POST["version"]);
        $funcionalidad = trim($_POST["funcionalidad"]);

        if ($id > 0) {
            // Editar
            $ok = $requerimiento->editar_requerimiento($id, $codigo, $nombre, $tipo, $prioridad, $estado_validacion, $version, $funcionalidad);
            echo json_encode(["success" => $ok ? "Requerimiento actualizado correctamente." : "Error al actualizar."]);
        } else {
            // Insertar nuevo
            $ok = $requerimiento->insertar_requerimiento($codigo, $nombre, $tipo, $prioridad, $estado_validacion, $version, $funcionalidad);
            echo json_encode(["success" => $ok ? "Requerimiento registrado correctamente." : "Error al registrar."]);
        }
        break;

    // 🔍 MOSTRAR UN REQUERIMIENTO
    case "mostrar":
        if (isset($_POST["id"])) {
            $datos = $requerimiento->get_requerimiento_por_id($_POST["id"]);
            echo json_encode($datos);
        } else {
            echo json_encode(["error" => "ID no proporcionado"]);
        }
        break;

    // ❌ ELIMINAR (cambio de estado lógico)
    case "eliminar":
        if (isset($_POST["id"])) {
            $ok = $requerimiento->cambiar_estado($_POST["id"], 0);
            echo json_encode(["success" => $ok ? "Requerimiento eliminado correctamente." : "Error al eliminar el registro."]);
        } else {
            echo json_encode(["error" => "ID no proporcionado"]);
        }
        break;

    default:
        echo json_encode(["error" => "Operación no válida"]);
        break;
}
?>
