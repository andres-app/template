<?php
// Incluir los archivos necesarios para la conexión a la base de datos y el modelo Vehiculo
require_once("../config/conexion.php");
require_once("../models/Vehiculo.php");

// Crear una instancia del modelo Vehiculo
$vehiculo = new Vehiculo();

// Evaluar el valor del parámetro "op" para determinar qué operación realizar
switch ($_GET["op"]) {

    // Caso para listar todos los vehículos
    case "listar":
        // Obtener los datos de los vehículos desde el modelo
        $datos = $vehiculo->get_vehiculos();

        // Verificar si hubo algún error al obtener los datos
        if ($datos === false) {
            // Enviar un mensaje de error en formato JSON
            echo json_encode(["error" => "Error al obtener los vehículos"]);
            exit;
        }

        // Array para almacenar los datos formateados
        $data = array();

        // Recorrer los datos obtenidos y formatearlos para el DataTable
        foreach ($datos as $row) {
            $sub_array = array();
            $sub_array[] = $row["id"]; // ID del vehículo
            $sub_array[] = $row["placa"]; // Placa del vehículo
            $sub_array[] = $row["marca"]; // Marca del vehículo
            $sub_array[] = $row["modelo"]; // Modelo del vehículo
            $sub_array[] = $row["anio"]; // Año del vehículo
            $sub_array[] = $row["ultimo_mantenimiento"]; // Fecha del último mantenimiento
            $sub_array[] = $row["proximo_mantenimiento"]; // Fecha del próximo mantenimiento

            // Botones de acción (editar y eliminar) para cada fila
            $sub_array[] = '
            <button type="button" class="btn btn-soft-info waves-effect waves-light btn-sm" onClick="previsualizar(' . $row["id"] . ')">
                <i class="bx bx-show-alt font-size-16 align-middle"></i>
            </button>
            <button type="button" class="btn btn-soft-warning waves-effect waves-light btn-sm" onClick="editar(' . $row["id"] . ')">
                <i class="bx bx-edit-alt font-size-16 align-middle"></i>
            </button>
            <button type="button" class="btn btn-soft-danger waves-effect waves-light btn-sm" onClick="eliminar(' . $row["id"] . ')">
                <i class="bx bx-trash-alt font-size-16 align-middle"></i>
            </button>';
        

            // Agregar la fila formateada al array de datos
            $data[] = $sub_array;
        }

        // Preparar los resultados en el formato esperado por el DataTable
        $results = array(
            "sEcho" => 1, // Eco de la respuesta para compatibilidad con DataTable
            "iTotalRecords" => count($data), // Total de registros sin filtrar
            "iTotalDisplayRecords" => count($data), // Total de registros filtrados
            "aaData" => $data // Los datos que se mostrarán en la tabla
        );

        // Enviar los resultados como JSON
        header('Content-Type: application/json');
        echo json_encode($results);
        break;

    // Caso para insertar un nuevo vehículo
    case "insertar":
        // Capturar los datos enviados desde el formulario
        $placa = isset($_POST["vehiculo_placa"]) ? $_POST["vehiculo_placa"] : null;
        $marca = isset($_POST["vehiculo_marca"]) ? $_POST["vehiculo_marca"] : null;
        $modelo = isset($_POST["vehiculo_modelo"]) ? $_POST["vehiculo_modelo"] : null;
        $anio = isset($_POST["vehiculo_anio"]) ? $_POST["vehiculo_anio"] : null;
        $color = isset($_POST["vehiculo_color"]) ? $_POST["vehiculo_color"] : null;
        $motor = isset($_POST["vehiculo_motor"]) ? $_POST["vehiculo_motor"] : null;
        $combustible = isset($_POST["vehiculo_combustible"]) ? $_POST["vehiculo_combustible"] : null;
        $tipo = isset($_POST["vehiculo_tipo"]) ? $_POST["vehiculo_tipo"] : null;
        $ultimo_mantenimiento = isset($_POST["vehiculo_ultimo_mantenimiento"]) ? $_POST["vehiculo_ultimo_mantenimiento"] : null;
        $proximo_mantenimiento = isset($_POST["vehiculo_proximo_mantenimiento"]) ? $_POST["vehiculo_proximo_mantenimiento"] : null;
        $poliza = isset($_POST["vehiculo_poliza"]) ? $_POST["vehiculo_poliza"] : null;
        $estado = isset($_POST["vehiculo_estado"]) ? $_POST["vehiculo_estado"] : null;

        // Insertar el nuevo vehículo en la base de datos usando el modelo
        if ($vehiculo->insertar_vehiculo($placa, $marca, $modelo, $anio, $color, $motor, $combustible, $tipo, $ultimo_mantenimiento, $proximo_mantenimiento, $poliza, $estado)) {
            // Enviar un mensaje de éxito si la inserción fue correcta
            echo json_encode(["success" => "Vehículo registrado correctamente."]);
        } else {
            // Enviar un mensaje de error si la inserción falló
            echo json_encode(["error" => "Error al registrar el vehículo."]);
        }
        break;

    // Caso para editar un vehículo existente
    case "editar":
        // Capturar los datos enviados por el formulario
        $id = $_POST["vehiculo_id"];
        $placa = $_POST["vehiculo_placa"];
        $marca = $_POST["vehiculo_marca"];
        $modelo = $_POST["vehiculo_modelo"];
        $anio = $_POST["vehiculo_anio"];
        $color = $_POST["vehiculo_color"];
        $motor = $_POST["vehiculo_motor"];
        $combustible = $_POST["vehiculo_combustible"];
        $tipo_vehiculo = $_POST["vehiculo_tipo"];
        $ultimo_mantenimiento = $_POST["vehiculo_ultimo_mantenimiento"];
        $proximo_mantenimiento = $_POST["vehiculo_proximo_mantenimiento"];
        $poliza = $_POST["vehiculo_poliza"];
        $estado = $_POST["vehiculo_estado"];

        // Llamar al método editar_vehiculo del modelo
        if ($vehiculo->editar_vehiculo($id, $placa, $marca, $modelo, $anio, $color, $motor, $combustible, $tipo_vehiculo, $ultimo_mantenimiento, $proximo_mantenimiento, $poliza, $estado)) {
            echo json_encode(["success" => "Vehículo actualizado correctamente."]);
        } else {
            echo json_encode(["error" => "Error al actualizar el vehículo."]);
        }
        break;

    case "mostrar":
        // Verificar si el ID del vehículo fue recibido
        if (isset($_POST["vehiculo_id"])) {
            // Obtener los datos del vehículo por su ID
            $datos = $vehiculo->get_vehiculo_por_id($_POST["vehiculo_id"]);

            // Verificar si los datos fueron encontrados
            if ($datos) {
                echo json_encode($datos); // Enviar los datos como JSON al frontend
            } else {
                echo json_encode(["error" => "No se encontraron datos para el ID del vehículo."]);
            }
        } else {
            echo json_encode(["error" => "No se proporcionó un ID de vehículo válido."]);
        }
        break;

    case "eliminar":
        if (isset($_POST["vehiculo_id"])) {
            $id = $_POST["vehiculo_id"];

            // Cambiar el estado del vehículo a 0 (Inactivo) en lugar de eliminarlo físicamente
            if ($vehiculo->cambiar_estado($id, 0)) {
                echo json_encode(["success" => "Vehículo eliminado correctamente."]);
            } else {
                echo json_encode(["error" => "Error al eliminar el vehículo."]);
            }
        } else {
            echo json_encode(["error" => "No se proporcionó un ID de vehículo válido."]);
        }
        break;



    // Caso por defecto si la operación no es válida
    default:
        echo json_encode(["error" => "Operación no válida."]);
        break;
}
?>