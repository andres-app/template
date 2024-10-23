<?php
require_once("../config/conexion.php");
require_once("../models/Vehiculo.php");
$vehiculo = new Vehiculo();

switch ($_GET["op"]) {

    // Caso para listar todos los vehículos
    case "listar":
        // Obtener los datos de los vehículos desde el modelo
        $datos = $vehiculo->get_vehiculos();
        
        // Verificar si hubo algún error al obtener los datos
        if ($datos === false) {
            echo json_encode(["error" => "Error al obtener los vehículos"]);
            exit;
        }

        // Array donde se almacenarán los datos a enviar al DataTable
        $data = array();
        
        // Recorrer los datos obtenidos para formatearlos adecuadamente
        foreach ($datos as $row) {
            // Crear un array temporal para cada fila
            $sub_array = array();
            $sub_array[] = $row["placa"];
            $sub_array[] = $row["marca"];
            $sub_array[] = $row["modelo"];
            $sub_array[] = $row["anio"];
            $sub_array[] = $row["ultimo_mantenimiento"];
            $sub_array[] = $row["proximo_mantenimiento"];
            
            // Botones de acción para editar y eliminar el vehículo
            $sub_array[] = '
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
            "sEcho" => 1, // Eco de la respuesta (para compatibilidad con DataTable)
            "iTotalRecords" => count($data), // Total de registros sin filtrar
            "iTotalDisplayRecords" => count($data), // Total de registros para mostrar
            "aaData" => $data // Datos que se mostrarán en el DataTable
        );
        
        // Enviar los resultados como JSON
        header('Content-Type: application/json');
        echo json_encode($results);
        break;

// Caso para insertar un nuevo vehículo
case "insertar":
    // Capturar los datos enviados por el formulario
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

    // Depurar los datos antes de la inserción
    var_dump($_POST); // Verifica que los datos lleguen correctamente desde el formulario

    // Insertar nuevo vehículo
    if ($vehiculo->insertar_vehiculo($placa, $marca, $modelo, $anio, $color, $motor, $combustible, $tipo, $ultimo_mantenimiento, $proximo_mantenimiento, $poliza, $estado)) {
        echo json_encode(["success" => "Vehículo registrado correctamente."]);
    } else {
        echo json_encode(["error" => "Error al registrar el vehículo."]);
    }
    break;


        // Otros casos para manejar distintas operaciones como mostrar, eliminar, etc.
        case "mostrar":
            // Código para mostrar un vehículo (por implementar)
            break;
    
        case "eliminar":
            // Código para eliminar un vehículo (por implementar)
            break;

        // Caso por defecto si la operación solicitada no es válida
        default:
            echo json_encode(["error" => "Operación no válida."]);
            break;
    }
?>
