<?php include 'header.php'; ?>
<div class="container">
    <h2>Detalles del Empleado</h2>
    <div class="detalles-empleado">
        <p><strong>Nombre:</strong> <?= htmlspecialchars($empleado['nombre']) ?></p>
        
        <p><strong>Ventas Unitarias:</strong></p>
        <ul>
            <?php if (!empty($ventas_unitarias)): ?>
                <?php foreach ($ventas_unitarias as $venta): ?>
                    <li>$<?= number_format(floatval($venta), 2) ?></li>
                <?php endforeach; ?>
            <?php else: ?>
                <li>No hay ventas unitarias registradas.</li>
            <?php endif; ?>
        </ul>
        
        <p>
            <strong>Ventas menores a $300k:</strong> <?= $ventas_menores_300 ?> 
            <strong>Total:</strong> $<?= number_format($total_ventas_menores_300, 2) ?>
            <strong>Bonificación 3%:</strong> $<?= number_format($bonificacion_menores_300, 2) ?>
        </p>
        
        <p>
            <strong>Ventas entre $300k - $800k:</strong> <?= $ventas_300_800 ?> 
            <strong>Total:</strong> $<?= number_format($total_ventas_300_800, 2) ?>
            <strong>Bonificación 5%:</strong> $<?= number_format($bonificacion_300_800, 2) ?>
        </p>
        
        <p>
            <strong>Ventas mayores $800k:</strong> <?= $ventas_mayores_800 ?> 
            <strong>Total:</strong> $<?= number_format($total_ventas_mayores_800, 2) ?>
            <strong>Bonificación 10%:</strong> $<?= number_format($bonificacion_mayores_800, 2) ?>
        </p>
        <p><strong>Total Ventas:</strong> $<?= number_format($total_ventas, 2) ?></p>
        <p><strong>Bonificación Total:</strong> $<?= number_format($bonificacion, 2) ?></p>
        <p><strong>Pago Inicial:</strong> $<?= number_format($pago_basico, 2) ?></p>
        <p><strong>Pago Total (Inicial + Bonificación):</strong> $<?= number_format($pago_total, 2) ?></p>
        <p><strong>Fecha de Registro:</strong> <?= date('d/m/Y H:i:s', strtotime($empleado['fecha_registro'])) ?></p>
    </div>
    <button class="btn-registrar" onclick="window.location.href='index.php'">Volver a la Lista</button>
</div>
<?php include 'footer.php'; ?>