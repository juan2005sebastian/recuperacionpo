<?php
require_once 'config/Database.php';
date_default_timezone_set('America/Bogota');

class EmpleadoModel {
    private $db;

    public function __construct() {
        $this->db = Database::connect();
    }

    public function registrarEmpleado($nombre, $ventas_menores_300, $ventas_300_800, $ventas_mayores_800, $total_ventas, $bonificacion, $pago_total, $venta_unitaria = null) {
        $query = $this->db->prepare('INSERT INTO empleados 
            (nombre, ventas_menores_300, ventas_300_800, ventas_mayores_800, total_ventas, bonificacion, pago_total, venta_unitaria, fecha_registro) 
            VALUES (:nombre, :ventas_menores_300, :ventas_300_800, :ventas_mayores_800, :total_ventas, :bonificacion, :pago_total, :venta_unitaria, :fecha_registro)');

        $fecha_registro = date('Y-m-d H:i:s');

        return $query->execute([
            ':nombre' => $nombre,
            ':ventas_menores_300' => $ventas_menores_300,
            ':ventas_300_800' => $ventas_300_800,
            ':ventas_mayores_800' => $ventas_mayores_800,
            ':total_ventas' => $total_ventas,
            ':bonificacion' => $bonificacion,
            ':pago_total' => $pago_total,
            ':venta_unitaria' => $venta_unitaria,
            ':fecha_registro' => $fecha_registro
        ]);
    }

    public function obtenerEmpleadosPorFecha($fecha) {
        $fecha_formateada = date('Y-m-d', strtotime($fecha));
        $query = "SELECT * FROM empleados WHERE fecha_registro LIKE :fecha_patron";
        $stmt = $this->db->prepare($query);
        $stmt->execute([':fecha_patron' => $fecha_formateada . '%']);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function obtenerTotalVentasPorCategoria($empleado_id) {
        $query = $this->db->prepare('
            SELECT 
                SUM(CASE WHEN categoria = "menor_300" THEN monto ELSE 0 END) as total_ventas_menores_300,
                SUM(CASE WHEN categoria = "entre_300_800" THEN monto ELSE 0 END) as total_ventas_300_800,
                SUM(CASE WHEN categoria = "mayor_800" THEN monto ELSE 0 END) as total_ventas_mayores_800,
                SUM(monto) as total_ventas
            FROM ventas 
            WHERE empleado_id = :empleado_id
        ');
        $query->execute([':empleado_id' => $empleado_id]);
        return $query->fetch(PDO::FETCH_ASSOC);
    }

    public function actualizarVentasUnitarias($id, $venta_unitaria) {
        $query = $this->db->prepare('UPDATE empleados SET 
            venta_unitaria = :venta_unitaria 
            WHERE id = :id');

        return $query->execute([
            ':venta_unitaria' => $venta_unitaria,
            ':id' => $id
        ]);
    }

    public function mostrarFormularioAgregarVentas() {
        $empleados = $this->model->obtenerEmpleados();
        require __DIR__ . '/../views/agregar_ventas.php';
    }

    public function obtenerEmpleadoPorId($id) {
        $query = $this->db->prepare('SELECT * FROM empleados WHERE id = :id');
        $query->execute([':id' => $id]);
        return $query->fetch();
    }

    public function actualizarEmpleado($id, $ventas_menores_300, $ventas_300_800, $ventas_mayores_800, $total_ventas, $bonificacion, $pago_total, $venta_unitaria) {
        $query = $this->db->prepare('UPDATE empleados SET 
            ventas_menores_300 = :ventas_menores_300, 
            ventas_300_800 = :ventas_300_800, 
            ventas_mayores_800 = :ventas_mayores_800, 
            total_ventas = :total_ventas, 
            bonificacion = :bonificacion, 
            pago_total = :pago_total,
            venta_unitaria = :venta_unitaria 
            WHERE id = :id');

        return $query->execute([
            ':ventas_menores_300' => $ventas_menores_300,
            ':ventas_300_800' => $ventas_300_800,
            ':ventas_mayores_800' => $ventas_mayores_800,
            ':total_ventas' => $total_ventas,
            ':bonificacion' => $bonificacion,
            ':pago_total' => $pago_total,
            ':venta_unitaria' => $venta_unitaria,
            ':id' => $id
        ]);
    }

    public function obtenerEmpleados() {
        return $this->db->query('SELECT * FROM empleados')->fetchAll();
    }

    public function eliminarEmpleado($id) {
        $query = $this->db->prepare("DELETE FROM empleados WHERE id = :id");
        $query->execute([':id' => $id]);
    }
}
?>