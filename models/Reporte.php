<?php
class Reporte extends Conectar {

    /* ============================================================
       REPORTE 1: TRAZABILIDAD DETALLADA
       (Requisito → Requerimiento → Caso de prueba)
    ============================================================ */
    public function reporte_trazabilidad() {
        $conectar = parent::conexion();
        parent::set_names();

        $sql = "SELECT 
                    r.codigo AS codigo_requisito,
                    r.nombre AS nombre_requisito,
                    rq.codigo AS codigo_requerimiento,
                    rq.nombre AS nombre_requerimiento,
                    cp.codigo AS codigo_caso_prueba,
                    cp.nombre AS nombre_caso_prueba,
                    cp.estado_ejecucion,
                    cp.resultado
                FROM requisito r
                LEFT JOIN requerimiento rq ON rq.id_requisito = r.id_requisito
                LEFT JOIN caso_prueba cp ON cp.id_requerimiento = rq.id_requerimiento
                ORDER BY r.codigo, rq.codigo, cp.codigo";

        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $sql->fetchAll(PDO::FETCH_ASSOC);
    }

    /* ============================================================
       REPORTE 2: COBERTURA POR REQUISITO
       (Cantidad de requerimientos y casos asociados)
    ============================================================ */
    public function reporte_cobertura() {
        $conectar = parent::conexion();
        parent::set_names();

        $sql = "SELECT 
                    r.codigo AS codigo_requisito,
                    r.nombre AS nombre_requisito,
                    COUNT(DISTINCT rq.id_requerimiento) AS total_requerimientos,
                    COUNT(DISTINCT cp.id_caso) AS total_casos_prueba
                FROM requisito r
                LEFT JOIN requerimiento rq ON rq.id_requisito = r.id_requisito AND rq.estado = 1
                LEFT JOIN caso_prueba cp ON cp.id_requerimiento = rq.id_requerimiento AND cp.estado = 1
                GROUP BY r.codigo, r.nombre
                ORDER BY r.codigo";

        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $sql->fetchAll(PDO::FETCH_ASSOC);
    }

    /* ============================================================
       REPORTE 3: CASOS POR REQUERIMIENTO
       (Total de CP agrupado por requerimiento)
    ============================================================ */
    public function reporte_casos_por_requerimiento() {
        $conectar = parent::conexion();
        parent::set_names();

        $sql = "SELECT 
                    rq.codigo AS codigo_requerimiento,
                    rq.nombre AS nombre_requerimiento,
                    COUNT(cp.id_caso) AS total_casos
                FROM requerimiento rq
                LEFT JOIN caso_prueba cp ON cp.id_requerimiento = rq.id_requerimiento
                GROUP BY rq.codigo, rq.nombre
                ORDER BY rq.codigo";

        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $sql->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>
