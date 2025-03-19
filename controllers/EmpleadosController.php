<?php
require_once __DIR__ . '/../models/EmpleadoModel.php';

class EmpleadosController {
    private $model;

    public function __construct() {
        $this->model = new EmpleadoModel();
    }

    public function index() {
        $empleados = $this->model->obtenerEmpleados();
        require __DIR__ . '/../views/tareas.php';
    }

    public function registrar() {
        $empleados = $this->model->obtenerEmpleados();
        require __DIR__ . '/../views/registrar.php';
    }

    private function calcularDatosVentas($ventas) {
        $ventas_menores_300 = 0;
        $ventas_300_800 = 0;
        $ventas_mayores_800 = 0;
        $total_ventas_menores_300 = 0;
        $total_ventas_300_800 = 0;
        $total_ventas_mayores_800 = 0;
        $total_ventas = 0;

        foreach ($ventas as $venta) {
            $venta = floatval($venta);

            if ($venta <= 300000) {
                $ventas_menores_300++;
                $total_ventas_menores_300 += $venta;
            } elseif ($venta > 300000 && $venta < 800000) {
                $ventas_300_800++;
                $total_ventas_300_800 += $venta;
            } else {
                $ventas_mayores_800++;
                $total_ventas_mayores_800 += $venta;
            }

            $total_ventas += $venta;
        }

        // Calcular bonificaciones
        $bonificacion_menores_300 = $total_ventas_menores_300 * 0.03;
        $bonificacion_300_800 = $total_ventas_300_800 * 0.05;
        $bonificacion_mayores_800 = $total_ventas_mayores_800 * 0.10;

        // Bonificación total
        $bonificacion = $bonificacion_menores_300 + $bonificacion_300_800 + $bonificacion_mayores_800;

        // Pago básico y pago total
        $pago_basico = 500000;
        $pago_total = $pago_basico + $bonificacion;

        return [
            'ventas_menores_300' => $ventas_menores_300,
            'ventas_300_800' => $ventas_300_800,
            'ventas_mayores_800' => $ventas_mayores_800,
            'total_ventas_menores_300' => $total_ventas_menores_300,
            'total_ventas_300_800' => $total_ventas_300_800,
            'total_ventas_mayores_800' => $total_ventas_mayores_800,
            'total_ventas' => $total_ventas,
            'bonificacion' => $bonificacion,
            'pago_total' => $pago_total,
            'bonificacion_300_800' => $bonificacion_300_800,
            'bonificacion_mayores_800' => $bonificacion_mayores_800,
        ];
    }

    public function guardar() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['empleados'])) {
            foreach ($_POST['empleados'] as $empleado) {
                $nombre = trim($empleado['nombre']);
                $ventas = $empleado['ventas'];

                if (empty($nombre)) {
                    echo "Error: El nombre no puede estar vacío.";
                    return;
                }

                $datos_ventas = $this->calcularDatosVentas($ventas);
                $venta_unitaria = json_encode($ventas);

                $this->model->registrarEmpleado(
                    $nombre,
                    $datos_ventas['ventas_menores_300'],
                    $datos_ventas['ventas_300_800'],
                    $datos_ventas['ventas_mayores_800'],
                    $datos_ventas['total_ventas'],
                    $datos_ventas['bonificacion'],
                    $datos_ventas['pago_total'],
                    $venta_unitaria
                );
            }

            header('Location: index.php?action=index');
            exit;
        }
    }

    public function agregarVentas() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['empleado_id']) && isset($_POST['ventas'])) {
            $empleado_id = $_POST['empleado_id'];
            $ventas = $_POST['ventas'];

            $empleado = $this->model->obtenerEmpleadoPorId($empleado_id);
            if (!$empleado) {
                echo "Error: El empleado no existe.";
                return;
            }

            $ventas_unitarias = json_decode($empleado['venta_unitaria'], true) ?? [];

            foreach ($ventas as $venta) {
                $venta = floatval($venta);
                $ventas_unitarias[] = $venta;
            }

            $datos_ventas = $this->calcularDatosVentas($ventas_unitarias);

            $this->model->actualizarEmpleado(
                $empleado_id,
                $datos_ventas['ventas_menores_300'],
                $datos_ventas['ventas_300_800'],
                $datos_ventas['ventas_mayores_800'],
                $datos_ventas['total_ventas'],
                $datos_ventas['bonificacion'],
                $datos_ventas['pago_total'],
                json_encode($ventas_unitarias)
            );

            header('Location: index.php?action=index');
            exit;
        }
    }

    public function eliminar() {
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            $this->model->eliminarEmpleado($id);
            header("Location: index.php");
            exit;
        }
    }

    public function filtrarPorFecha() {
        if (isset($_GET['fecha']) && !empty($_GET['fecha'])) {
            $fecha = $_GET['fecha'];
            $empleados = $this->model->obtenerEmpleadosPorFecha($fecha);

            if (empty($empleados)) {
                $mensaje = "No se encontraron empleados registrados en la fecha seleccionada.";
            }

            require __DIR__ . '/../views/tareas.php';
        } else {
            $this->index();
        }
    }

    public function verDetalles() {
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            $empleado = $this->model->obtenerEmpleadoPorId($id);

            if ($empleado) {
                $ventas_unitarias = json_decode($empleado['venta_unitaria'], true) ?? [];

                $ventas_menores_300 = 0;
                $ventas_300_800 = 0;
                $ventas_mayores_800 = 0;
                $total_ventas_menores_300 = 0;
                $total_ventas_300_800 = 0;
                $total_ventas_mayores_800 = 0;
                $total_ventas = 0;

                foreach ($ventas_unitarias as $venta) {
                    $venta = floatval($venta);

                    if ($venta <= 300000) {
                        $ventas_menores_300++;
                        $total_ventas_menores_300 += $venta;
                    } elseif ($venta > 300000 && $venta < 800000) {
                        $ventas_300_800++;
                        $total_ventas_300_800 += $venta;
                    } else {
                        $ventas_mayores_800++;
                        $total_ventas_mayores_800 += $venta;
                    }

                    $total_ventas += $venta;
                }

                // Calcular bonificaciones
                $bonificacion_menores_300 = $total_ventas_menores_300 * 0.03;
                $bonificacion_300_800 = $total_ventas_300_800 * 0.05;
                $bonificacion_mayores_800 = $total_ventas_mayores_800 * 0.10;

                $bonificacion = $bonificacion_menores_300 + $bonificacion_300_800 + $bonificacion_mayores_800;
                $pago_basico = 500000;
                $pago_total = $pago_basico + $bonificacion;

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