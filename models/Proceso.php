<?php
require_once("../config/conexion.php");

class Proceso extends Conectar {
    // Constructor opcional, no es necesario si la conexión ya está gestionada por la clase padre
    
    // Función para obtener todos los procesos
    public function obtenerProcesos() {
        $sql = "SELECT id, sinad, direc, grupo, obtencion, nombre, estado_actual, fecha_inicio FROM procesos";
        $stmt = $this->conexion()->prepare($sql);  // Utiliza el método de conexión heredado
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Función para obtener eventos de un proceso específico
    public function obtenerEventosProceso($proceso_id) {
        $sql = "SELECT descripcion_evento, fecha_evento, tipo_evento FROM eventos WHERE proceso_id = ?";
        $stmt = $this->conexion()->prepare($sql);
        $stmt->bindValue(1, $proceso_id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
