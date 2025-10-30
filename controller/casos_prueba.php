<?php
require_once("../config/conexion.php");
require_once("../models/Casos_prueba.php");

$caso = new Casos_prueba();

switch ($_GET["op"]) {

    // 🧾 LISTAR CASOS DE PRUEBA
    case "listar":
        $datos = $caso->get_casos();
    
        if ($datos === false) {
            echo json_encode(["error" => "Error al obtener los casos de prueba"]);
            exit;
        }
    
        $data = array();
    
        foreach ($datos as $row) {
            $sub_array = array();
            $sub_array[] = $row["id_caso"];               // 0 - ID
            $sub_array[] = $row["codigo"];                // 1 - Código
            $sub_array[] = $row["nombre"];                // 2 - Nombre del caso
            $sub_array[] = $row["requerimiento"];         // 3 - Requerimiento asociado
            $sub_array[] = $row["tipo_prueba"];           // 4 - Tipo de prueba
            $sub_array[] = $row["resultado_esperado"];    // 5 - Resultado esperado
            $sub_array[] = $row["estado_ejecucion"];      // 6 - Estado
            $sub_array[] = $row["version"];               // 7 - Versión
            $sub_array[] = $row["fecha_creacion"];        // 8 - Fecha creación
            $sub_array[] = '                             // 9 - Botones de acción
                <button type="button" class="btn btn-soft-warning btn-sm" onClick="editar(' . $row["id_caso"] . ')">
                    <i class="bx bx-edit-alt font-size-16 align-middle"></i>
                </button>
                <button type="button" class="btn btn-soft-danger btn-sm" onClick="eliminar(' . $row["id_caso"] . ')">
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
    

    // 💾 GUARDAR / EDITAR CASO
    case "guardar":
        $id = isset($_POST["id_caso"]) ? intval($_POST["id_caso"]) : 0;
        $codigo = trim($_POST["codigo"]);
        $nombre = trim($_POST["nombre"]);
        $version = trim($_POST["version"]);
        $elaborado_por = trim($_POST["elaborado_por"]);
        $especialidad_id = intval($_POST["especialidad_id"]);
        $id_requerimiento = intval($_POST["id_requerimiento"]);
        $estado_ejecucion = trim($_POST["estado_ejecucion"]);
        $resultado = trim($_POST["resultado"]);
        $fecha_ejecucion = $_POST["fecha_ejecucion"];
        $observaciones = trim($_POST["observaciones"]);

        if ($id > 0) {
            $ok = $caso->editar_caso($id, $codigo, $nombre, $version, $elaborado_por, $especialidad_id, $id_requerimiento, $estado_ejecucion, $resultado, $fecha_ejecucion, $observaciones);
            echo json_encode(["success" => $ok ? "Caso de prueba actualizado correctamente." : "Error al actualizar el caso de prueba."]);
        } else {
            $ok = $caso->insertar_caso($codigo, $nombre, $version, $elaborado_por, $especialidad_id, $id_requerimiento, $estado_ejecucion, $resultado, $fecha_ejecucion, $observaciones);
            echo json_encode(["success" => $ok ? "Caso de prueba registrado correctamente." : "Error al registrar el caso de prueba."]);
        }
        break;

    // 🔍 MOSTRAR
    case "mostrar":
        if (isset($_POST["id"])) {
            $datos = $caso->get_caso_por_id($_POST["id"]);
            echo json_encode($datos);
        } else {
            echo json_encode(["error" => "ID no proporcionado."]);
        }
        break;

    // ❌ ELIMINAR (estado lógico)
    case "eliminar":
        if (isset($_POST["id"])) {
            $ok = $caso->cambiar_estado($_POST["id"], 0);
            echo json_encode(["success" => $ok ? "Caso de prueba eliminado correctamente." : "Error al eliminar el caso de prueba."]);
        } else {
            echo json_encode(["error" => "ID no proporcionado."]);
        }
        break;

    default:
        echo json_encode(["error" => "Operación no válida"]);
        break;
}
?>
