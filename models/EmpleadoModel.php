<?php
// Importamos la conexión a la base de datos
require_once 'config/Database.php'; 
date_default_timezone_set('America/Bogota');

// Definimos la clase EmpleadoModel, que interactúa con la base de datos
class EmpleadoModel {
    private $db; // Variable privada para almacenar la conexión a la base de datos

    // Constructor: Se ejecuta automáticamente al crear un objeto de esta clase
    public function __construct() {
        $this->db = Database::connect(); // Establece la conexión a la base de datos
    }

    public function registrarEmpleado($nombre, $ventas_menores_300, $ventas_300_800, $ventas_mayores_800, $total_ventas, $bono, $pago_total) {
        // Preparamos la consulta SQL para insertar un nuevo empleado en la tabla 'empleados'.
        $query = $this->db->prepare('INSERT INTO empleados 
            (nombre, ventas_menores_300, ventas_300_800, ventas_mayores_800, total_ventas, bonificacion, pago_total, fecha_registro) 
            VALUES (:nombre, :ventas_menores_300, :ventas_300_800, :ventas_mayores_800, :total_ventas, :bonificacion, :pago_total, :fecha_registro)');
    
        // Obtenemos la fecha y hora actual
        $fecha_registro = date('Y-m-d H:i:s');
    
        // Ejecutamos la consulta enviando los valores con parámetros seguros.
        return $query->execute([
            ':nombre' => $nombre,  // Nombre del empleado.
            ':ventas_menores_300' => $ventas_menores_300,  // Ventas menores a 300.
            ':ventas_300_800' => $ventas_300_800,  // Ventas entre 300 y 800.
            ':ventas_mayores_800' => $ventas_mayores_800,  // Ventas mayores a 800.
            ':total_ventas' => $total_ventas,  // Total de ventas realizadas.
            ':bonificacion' => $bono,  // Bonificación calculada según las ventas.
            ':pago_total' => $pago_total,  // Pago total (ventas + bonificación).
            ':fecha_registro' => $fecha_registro  // Fecha de registro.
        ]);
    }
    public function obtenerEmpleadosPorFecha($fecha) {
        // Aseguramos que la fecha esté en formato YYYY-MM-DD
        $fecha_formateada = date('Y-m-d', strtotime($fecha));
        
        // Usamos LIKE para hacer coincidir el comienzo de la fecha
        $query = "SELECT * FROM empleados WHERE fecha_registro LIKE :fecha_patron";
        $stmt = $this->db->prepare($query);
        $stmt->execute([':fecha_patron' => $fecha_formateada . '%']);
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
      
    

    public function mostrarFormularioAgregarVentas() {
        // Obtener la lista de empleados registrados
        $empleados = $this->model->obtenerEmpleados();
        
        // Pasar los empleados a la vista
        require __DIR__ . '/../views/agregar_ventas.php';
    }
    public function obtenerEmpleadoPorId($id) {
        $query = $this->db->prepare('SELECT * FROM empleados WHERE id = :id');
        $query->execute([':id' => $id]);
        return $query->fetch();
    }
    
    public function actualizarEmpleado($id, $ventas_menores_300, $ventas_300_800, $ventas_mayores_800, $total_ventas, $bonificacion, $pago_total) {
        $query = $this->db->prepare('UPDATE empleados SET 
            ventas_menores_300 = :ventas_menores_300, 
            ventas_300_800 = :ventas_300_800, 
            ventas_mayores_800 = :ventas_mayores_800, 
            total_ventas = :total_ventas, 
            bonificacion = :bonificacion, 
            pago_total = :pago_total 
            WHERE id = :id');
    
        return $query->execute([
            ':ventas_menores_300' => $ventas_menores_300,
            ':ventas_300_800' => $ventas_300_800,
            ':ventas_mayores_800' => $ventas_mayores_800,
            ':total_ventas' => $total_ventas,
            ':bonificacion' => $bonificacion,
            ':pago_total' => $pago_total,
            ':id' => $id
        ]);
    }         
   
    public function obtenerEmpleados() {
        // Ejecutamos una consulta SQL que selecciona todos los empleados
        return $this->db->query('SELECT * FROM empleados')->fetchAll();
    }

      public function eliminarEmpleado($id) {
        // Preparamos la consulta SQL para eliminar al empleado con el ID especificado
        $query = $this->db->prepare("DELETE FROM empleados WHERE id = :id");
        
        // Ejecutamos la consulta con el ID del empleado a eliminar
        $query->execute([':id' => $id]);
    }
}
?>
