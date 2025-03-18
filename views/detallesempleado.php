<?php include 'header.php'; ?>
<div class="container">
    <h2>Detalles del Empleado</h2>
    <div class="detalles-empleado">
        <p><strong>Nombre:</strong> <?= htmlspecialchars($empleado['nombre']) ?></p>
        
        <!-- Ventas menores a $300k -->
        <p>
            <strong>Ventas menores $300k:</strong> <?= $empleado['ventas_menores_300'] ?> ventas
            
        </p>
        
        <!-- Ventas entre $300k y $800k -->
        <p>
            <strong>Ventas entre $300k - $800k:</strong> <?= $empleado['ventas_300_800'] ?> ventas
           
        </p>
        
        <!-- Ventas mayores a $800k -->
        <p>
            <strong>Ventas mayores $800k:</strong> <?= $empleado['ventas_mayores_800'] ?> ventas
            
        </p>
        
        <p><strong>Total Ventas:</strong> $<?= number_format($empleado['total_ventas'], 2) ?></p>
        <p><strong>Bonificación:</strong> $<?= number_format($empleado['bonificacion'], 2) ?></p>
        <p><strong>Pago Inicial:</strong> $<?= number_format(500000, 2) ?></p>
        <p><strong>Pago Total (Inicial + Bonificación):</strong> $<?= number_format($empleado['pago_total'], 2) ?></p>
        <p><strong>Fecha de Registro:</strong> <?= date('d/m/Y H:i:s', strtotime($empleado['fecha_registro'])) ?></p>
    </div>
    <button class="btn-registrar" onclick="window.location.href='index.php'">Volver a la Lista</button>
</div>
<?php include 'footer.php'; ?>