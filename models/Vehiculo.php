<?php
// Clase Vehiculo que hereda de la clase Conectar
class Vehiculo extends Conectar {

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
    public function get_vehiculos() {
        // Establecer la conexión con la base de datos
        $conectar = parent::conexion();
        parent::set_names();

        // Definir la consulta SQL para obtener los datos de los vehículos
        $sql = "SELECT id, placa, marca, modelo, anio, ultimo_mantenimiento, proximo_mantenimiento 
                FROM vehiculos";

        // Preparar la consulta SQL
        $stmt = $conectar->prepare($sql);

        // Ejecutar la consulta SQL
        $stmt->execute();

        // Retornar los resultados como un array asociativo
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Método para insertar un nuevo vehículo en la base de datos.
     *
     * @param string $placa Placa del vehículo.
     * @param string $marca Marca del vehículo.
     * @param string $modelo Modelo del vehículo.
     * @param int $anio Año de fabricación del vehículo.
     * @param string $color Color del vehículo.
     * @param string $motor Tipo de motor del vehículo.
     * @param string $combustible Tipo de combustible (Gasolina, Diesel, etc.).
     * @param string $tipo Tipo de vehículo.
     * @param string $ultimo_mantenimiento Fecha del último mantenimiento.
     * @param string $proximo_mantenimiento Fecha del próximo mantenimiento.
     * @param string $poliza Número de póliza del vehículo.
     * @param int $estado Estado del vehículo (Activo o Inactivo).
     */
    public function insertar_vehiculo($placa, $marca, $modelo, $anio, $color, $motor, $combustible, $tipo_vehiculo, $ultimo_mantenimiento, $proximo_mantenimiento, $poliza, $estado) {
        $conectar = parent::conexion();
        parent::set_names();
    
        // Actualiza el nombre de la columna "tipo" a "tipo_vehiculo"
        $sql = "INSERT INTO vehiculos (placa, marca, modelo, anio, color, motor, combustible, tipo_vehiculo, ultimo_mantenimiento, proximo_mantenimiento, poliza, estado) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        
        // Preparar la consulta SQL
        $stmt = $conectar->prepare($sql);
    
        // Ejecutar la consulta y manejar posibles errores
        if ($stmt->execute([$placa, $marca, $modelo, $anio, $color, $motor, $combustible, $tipo_vehiculo, $ultimo_mantenimiento, $proximo_mantenimiento, $poliza, $estado])) {
            return true;  // Si la consulta se ejecuta correctamente
        } else {
            // Si hay un error en la consulta, capturarlo y registrarlo
            $error = $stmt->errorInfo();
            error_log("Error en la consulta: " . $error[2]);  // Muestra el error en los logs de PHP
            return false;  // Retornar false si falla
        }
    }
    
}
?>
