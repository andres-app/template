<?php

// Clase Vehiculo que hereda de la clase Conectar
class Vehiculo extends Conectar
{
    /**
     * Método para obtener todos los vehículos registrados en la base de datos.
     *
     * @return array Listado de vehículos con sus respectivos datos:
     *               - id: Identificador del vehículo.
     *               - placa: Número de placa del vehículo.
     *               - marca: Marca del vehículo.
     *               - modelo: Modelo del vehículo.
     *               - anio: Año de fabricación del vehículo.
     *               - ultimo_mantenimiento: Fecha del último mantenimiento realizado.
     *               - proximo_mantenimiento: Fecha prevista para el próximo mantenimiento.
     */
    public function get_vehiculos()
    {
        // Establecer la conexión con la base de datos
        $conectar = parent::conexion();

        // Configurar los nombres de los caracteres correctos para evitar problemas con la codificación
        parent::set_names();

        // Definir la consulta SQL para obtener los datos de los vehículos
        $sql = "SELECT 
                    id, 
                    placa, 
                    marca, 
                    modelo, 
                    anio, 
                    ultimo_mantenimiento, 
                    proximo_mantenimiento 
                FROM vehiculos";

        // Preparar la consulta SQL
        $stmt = $conectar->prepare($sql);

        // Ejecutar la consulta SQL
        $stmt->execute();

        // Retornar los resultados como un array asociativo
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>
