<?php
// Primero, incluyo el modelo de empleados para poder usarlo en este controlador.
require_once __DIR__ . '/../models/EmpleadoModel.php';

class EmpleadosController {
    private $model; // Acá voy a guardar la instancia del modelo de empleados.

    // 🔹 Constructor: Se ejecuta cuando creo una instancia de este controlador.
    public function __construct() {
        $this->model = new EmpleadoModel(); // Instancio el modelo para usarlo en los métodos de este controlador.
    }

    // 🔹 Método para mostrar la lista de empleados.
    public function index() {
        $empleados = $this->model->obtenerEmpleados(); // Llamo al modelo para traer los empleados desde la base de datos.
        require __DIR__ . '/../views/tareas.php'; // Muestro la vista 'tareas.php' con la lista de empleados.
    }

    // 🔹 Método para mostrar el formulario de registro.
    public function registrar() {
        // Obtener la lista de empleados registrados
        $empleados = $this->model->obtenerEmpleados();
        
        // Pasar los empleados a la vista
        require __DIR__ . '/../views/registrar.php';
    }

    // 🔹 Método para guardar empleados en la base de datos.
    public function guardar() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['empleados'])) {
            foreach ($_POST['empleados'] as $empleado) {
                $nombre = trim($empleado['nombre']);
                $ventas = $empleado['ventas']; // Array de ventas
    
                // Validar que el nombre no esté vacío
                if (empty($nombre)) {
                    echo "Error: El nombre no puede estar vacío.";
                    return;
                }
    
                // Clasificar las ventas
                $ventas_menores_300 = 0;
                $ventas_300_800 = 0;
                $ventas_mayores_800 = 0;
                $total_ventas = 0;
    
                foreach ($ventas as $venta) {
                    $venta = floatval($venta);
    
                    if ($venta <= 300000) {
                        $ventas_menores_300++;
                    } elseif ($venta > 300000 && $venta < 800000) {
                        $ventas_300_800++;
                    } else {
                        $ventas_mayores_800++;
                    }
    
                    // Sumar al total de ventas
                    $total_ventas += $venta;
                }
    
                // Calcular la bonificación y el pago total
                $bonificacion = 0;
                if ($total_ventas >= 400000 && $total_ventas <= 800000) {
                    $bonificacion = $total_ventas * 0.05;
                } elseif ($total_ventas > 800000) {
                    $bonificacion = $total_ventas * 0.10;
                }
    
                $pago_basico = 500000;
                $pago_total = $pago_basico + $bonificacion;
    
                // Registrar el nuevo empleado
                $this->model->registrarEmpleado(
                    $nombre,
                    $ventas_menores_300,
                    $ventas_300_800,
                    $ventas_mayores_800,
                    $total_ventas,
                    $bonificacion,
                    $pago_total
                );
            }
    
            // Redirigir a la lista de empleados
            header('Location: index.php?action=index');
            exit;
        }
    }

    public function agregarVentas() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['empleado_id']) && isset($_POST['ventas'])) {
            $empleado_id = $_POST['empleado_id'];
            $ventas = $_POST['ventas']; // Array de ventas
    
            // Validar que el empleado exista
            $empleado = $this->model->obtenerEmpleadoPorId($empleado_id);
            if (!$empleado) {
                echo "Error: El empleado no existe.";
                return;
            }
    
            // Clasificar las ventas
            $ventas_menores_300 = $empleado['ventas_menores_300'];
            $ventas_300_800 = $empleado['ventas_300_800'];
            $ventas_mayores_800 = $empleado['ventas_mayores_800'];
            $total_ventas = $empleado['total_ventas'];
    
            foreach ($ventas as $venta) {
                $venta = floatval($venta);
    
                if ($venta <= 300000) {
                    $ventas_menores_300++;
                } elseif ($venta > 300000 && $venta < 800000) {
                    $ventas_300_800++;
                } else {
                    $ventas_mayores_800++;
                }
    
                // Sumar al total de ventas
                $total_ventas += $venta;
            }
    
            // Calcular la bonificación y el pago total
            $bonificacion = 0;
            if ($total_ventas >= 400000 && $total_ventas <= 800000) {
                $bonificacion = $total_ventas * 0.05;
            } elseif ($total_ventas > 800000) {
                $bonificacion = $total_ventas * 0.10;
            }
    
            $pago_basico = 500000;
            $pago_total = $pago_basico + $bonificacion;
    
            // Actualizar el empleado en la base de datos
            $this->model->actualizarEmpleado(
                $empleado_id,
                $ventas_menores_300,
                $ventas_300_800,
                $ventas_mayores_800,
                $total_ventas,
                $bonificacion,
                $pago_total
            );
    
            // Redirigir a la lista de empleados
            header('Location: index.php?action=index');
            exit;
        }
    }

    // 🔹 Método para eliminar un empleado.
    public function eliminar() {
        if (isset($_GET['id'])) { // Verifico si en la URL viene el ID del empleado a eliminar.
            $id = $_GET['id']; // Guardo el ID.

            $empleadoModel = new EmpleadoModel(); // Creo una nueva instancia del modelo.
            $empleadoModel->eliminarEmpleado($id); // Llamo al método que elimina al empleado de la base de datos.

            // 🔹 Redirijo a la lista de empleados.
            header("Location: index.php");
            exit; // IMPORTANTE: Detiene el script para evitar que se ejecuten líneas innecesarias.
        }
    }
    public function filtrarPorFecha() {
        if (isset($_GET['fecha']) && !empty($_GET['fecha'])) {
            $fecha = $_GET['fecha'];
            
            // Obtener empleados filtrados por fecha
            $empleados = $this->model->obtenerEmpleadosPorFecha($fecha);
            
            // Establecer un mensaje si no hay resultados
            if (empty($empleados)) {
                $mensaje = "No se encontraron empleados registrados en la fecha seleccionada.";
            }
            
            // Pasar los empleados filtrados y el mensaje a la vista
            require __DIR__ . '/../views/tareas.php';
        } else {
            // Si no hay fecha, mostrar todos los empleados
            $this->index();
        }
    }   

    // 🔹 Método para ver los detalles de un empleado.
    public function verDetalles() {
        if (isset($_GET['id'])) {
            $id = $_GET['id']; // Obtener el ID del empleado desde la URL.

            // Obtener los detalles del empleado usando el modelo.
            $empleado = $this->model->obtenerEmpleadoPorId($id);

            if ($empleado) {
                // Cargar la vista de detalles.
                require __DIR__ . '/../views/detallesempleado.php';
            } else {
                echo "Empleado no encontrado.";
            }
        } else {
            echo "ID de empleado no proporcionado.";
        }
    }
}
?>