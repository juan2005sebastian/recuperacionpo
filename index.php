<?php
header('Content-Type: text/html; charset=UTF-8');
mb_internal_encoding('UTF-8');
ini_set('default_charset', 'UTF-8');

// Importamos el controlador de empleados, que maneja la lógica del negocio
require 'controllers/EmpleadosController.php';

// Creamos una instancia del controlador
$controller = new EmpleadosController();

$action = isset($_GET['action']) ? $_GET['action'] : 'index';

// Utilizamos un switch para determinar qué acción ejecutar según el valor de 'action'
switch ($action) {
    case 'index':
        // Muestra la lista de empleados o la página principal
        $controller->index();
        break;
    case 'registrar':
        // Muestra el formulario de registro de empleados
        $controller->registrar();
        break;
    case 'guardar':
        // Guarda los datos de un nuevo empleado en la base de datos
        $controller->guardar();
        break;
    case 'agregarVentas':
        // Agrega ventas a un empleado existente
        $controller->agregarVentas();
        break;
    case 'verDetalles': // Nueva acción para ver detalles
        $controller->verDetalles();
        break;
    case 'verVentas': // Nueva acción
        $controller->verVentas();
        break;
    default:
        // Si la acción no coincide con ninguna opción, se carga la página principal por defecto
        $controller->index();
        break;
}

// Verificamos si la acción es 'eliminar' en la URL
if (isset($_GET['action']) && $_GET['action'] == 'eliminar') {
    // Se vuelve a crear la instancia del controlador (esto puede optimizarse, pero funciona)
    $controller = new EmpleadosController();
    
    // Se llama al método eliminar() para borrar un empleado según su ID
    $controller->eliminar();
}
?>