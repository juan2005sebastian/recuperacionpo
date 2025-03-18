<?php include 'header.php'; ?>

<div class="container">
    <?php
    // Obtener el nombre del empleado
    $empleado = $this->model->obtenerEmpleadoPorId($_GET['id']);
    
    // Determinar el título según la categoría
    $titulo_categoria = '';
    switch ($_GET['categoria']) {
        case 'menor_300':
            $titulo_categoria = 'menores a $300,000';
            break;
        case 'entre_300_800':
            $titulo_categoria = 'entre $300,000 y $800,000';
            break;
        case 'mayor_800':
            $titulo_categoria = 'mayores a $800,000';
            break;
    }
    ?>
    
    <h2>Ventas <?php echo $titulo_categoria; ?> de <?php echo htmlspecialchars($empleado['nombre']); ?></h2>
    
    <div class="tabla-ventas">
        <?php if (empty($ventas)): ?>
            <p>No hay ventas registradas en esta categoría.</p>
        <?php else: ?>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Monto</th>
                        <th>Fecha</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($ventas as $venta): ?>
                        <tr>
                            <td><?php echo $venta['id']; ?></td>
                            <td>$<?php echo number_format($venta['monto'], 2); ?></td>
                            <td><?php echo date('d/m/Y H:i:s', strtotime($venta['fecha_registro'])); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>
    
    <div class="botones-accion">
        <a href="index.php?action=verDetalles&id=<?php echo $_GET['id']; ?>" class="btn btn-primary">Volver a Detalles</a>
        <a href="index.php?action=index" class="btn btn-secondary">Volver a la Lista</a>
    </div>
</div>

<?php include 'footer.php'; ?>