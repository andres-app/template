<?php
// Importar los archivos necesarios para la conexión y el modelo de Vehiculo
require_once("../config/conexion.php");
require_once("../models/Vehiculo.php");

// Crear una instancia del modelo Vehiculo
$vehiculo = new Vehiculo();

// Verificar el parámetro 'op' pasado por GET para determinar la operación a realizar
switch ($_GET["op"]) {

    // Caso para listar todos los vehículos
    case "listar":
        // Obtener los datos de los vehículos desde el modelo
        $datos = $vehiculo->get_vehiculos();
        
        // Verificar si hubo algún error al obtener los datos
        if ($datos === false) {
            // Si ocurre un error, devolver un mensaje de error en formato JSON y detener la ejecución
            echo json_encode(["error" => "Error al obtener los vehículos"]);
            exit;
        }

        // Array donde se almacenarán los datos a enviar al DataTable
        $data = array();
        
        // Recorrer los datos obtenidos para formatearlos adecuadamente
        foreach ($datos as $row) {
            // Crear un array temporal para cada fila
            $sub_array = array();
            $sub_array[] = $row["placa"]; // Placa del vehículo
            $sub_array[] = $row["marca"]; // Marca del vehículo
            $sub_array[] = $row["modelo"]; // Modelo del vehículo
            $sub_array[] = $row["anio"]; // Año del vehículo
            $sub_array[] = $row["ultimo_mantenimiento"]; // Último mantenimiento
            $sub_array[] = $row["proximo_mantenimiento"]; // Próximo mantenimiento
            
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
