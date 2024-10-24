<?php
// Clase Vehiculo que extiende de la clase Conectar, para manejar operaciones con la base de datos.
class Vehiculo extends Conectar {

    /**
     * Método para obtener todos los vehículos registrados en la base de datos.
     * 
     * @return array Listado de vehículos con los siguientes datos:
     *               - id: Identificador del vehículo.
     *               - placa: Número de placa del vehículo.
     *               - marca: Marca del vehículo.
     *               - modelo: Modelo del vehículo.
     *               - anio: Año de fabricación del vehículo.
     *               - ultimo_mantenimiento: Fecha del último mantenimiento realizado.
     *               - proximo_mantenimiento: Fecha prevista para el próximo mantenimiento.
     */
    public function get_vehiculos() {
        $conectar = parent::conexion();
        parent::set_names();
    
        // Ordenar los vehículos por 'id' de forma descendente para que el último registro aparezca primero
        $sql = "SELECT id, placa, marca, modelo, anio, color, motor, combustible, tipo_vehiculo, ultimo_mantenimiento, proximo_mantenimiento, poliza, estado 
                FROM vehiculos";
    
        $stmt = $conectar->prepare($sql);
        $stmt->execute();
    
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
     * @param string $tipo_vehiculo Tipo de vehículo.
     * @param string $ultimo_mantenimiento Fecha del último mantenimiento.
     * @param string $proximo_mantenimiento Fecha del próximo mantenimiento.
     * @param string $poliza Número de póliza del vehículo.
     * @param int $estado Estado del vehículo (Activo o Inactivo).
     * 
     * @return bool True si la inserción fue exitosa, false en caso de error.
     */
    public function insertar_vehiculo($placa, $marca, $modelo, $anio, $color, $motor, $combustible, $tipo_vehiculo, $ultimo_mantenimiento, $proximo_mantenimiento, $poliza, $estado) {
        // Establecer la conexión con la base de datos
        $conectar = parent::conexion();
        parent::set_names();
    
        // Consulta SQL para insertar un nuevo vehículo en la base de datos
        $sql = "INSERT INTO vehiculos (placa, marca, modelo, anio, color, motor, combustible, tipo_vehiculo, ultimo_mantenimiento, proximo_mantenimiento, poliza, estado) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        
        // Preparar la consulta
        $stmt = $conectar->prepare($sql);
    
        // Ejecutar la consulta y manejar posibles errores
        if ($stmt->execute([$placa, $marca, $modelo, $anio, $color, $motor, $combustible, $tipo_vehiculo, $ultimo_mantenimiento, $proximo_mantenimiento, $poliza, $estado])) {
            // Si la consulta fue exitosa, retornar true
            return true;
        } else {
            // Si ocurre un error, capturarlo y registrarlo en los logs de PHP
            $error = $stmt->errorInfo();
            error_log("Error en la consulta: " . $error[2]);
            // Retornar false si hay un error en la inserción
            return false;
        }
    }
    
}
?>
