<?php
class Vehiculo extends Conectar
{
    public function get_vehiculos()
    {
        $conectar = parent::conexion();
        parent::set_names();


        $sql = "SELECT id, placa, marca, modelo, anio FROM vehiculos";
        $stmt = $conectar->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);  // Asegúrate de que se estén devolviendo los datos correctamente
    }


    public function insert_vehiculo($vehiculo_placa, $vehiculo_marca, $vehiculo_modelo, $vehiculo_anio)
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "INSERT INTO tm_vehiculo (vehiculo_placa, vehiculo_marca, vehiculo_modelo, vehiculo_anio) VALUES (?,?,?,?)";
        $sql = $conectar->prepare($sql);
        $sql->bindValue(1, $vehiculo_placa);
        $sql->bindValue(2, $vehiculo_marca);
        $sql->bindValue(3, $vehiculo_modelo);
        $sql->bindValue(4, $vehiculo_anio);
        $sql->execute();
    }

    public function update_vehiculo($vehiculo_id, $vehiculo_placa, $vehiculo_marca, $vehiculo_modelo, $vehiculo_anio)
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "UPDATE tm_vehiculo SET vehiculo_placa=?, vehiculo_marca=?, vehiculo_modelo=?, vehiculo_anio=?, fech_modi=NOW() WHERE vehiculo_id=?";
        $sql = $conectar->prepare($sql);
        $sql->bindValue(1, $vehiculo_placa);
        $sql->bindValue(2, $vehiculo_marca);
        $sql->bindValue(3, $vehiculo_modelo);
        $sql->bindValue(4, $vehiculo_anio);
        $sql->bindValue(5, $vehiculo_id);
        $sql->execute();
    }

    public function get_vehiculo_x_id($vehiculo_id)
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "SELECT * FROM tm_vehiculo WHERE vehiculo_id=?";
        $sql = $conectar->prepare($sql);
        $sql->bindValue(1, $vehiculo_id);
        $sql->execute();
        return $sql->fetchAll();
    }

    public function eliminar_vehiculo($vehiculo_id)
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "UPDATE tm_vehiculo SET est=0, fech_elim=NOW() WHERE vehiculo_id=?";
        $sql = $conectar->prepare($sql);
        $sql->bindValue(1, $vehiculo_id);
        $sql->execute();
    }
}
?>