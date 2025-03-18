<?php include 'header.php'; ?>
<div class="container">
    <h2>Lista de Empleados</h2>

    <!-- Formulario de filtrado por fecha con JavaScript -->
    <div class="formulario-filtro">
        <div class="campo">
            <label for="fecha_js">Seleccionar Fecha:</label>
            <input type="date" id="fecha_js" name="fecha_js">
        </div>
        <button type="button" id="btn-filtrar" class="btn-registrar">Filtrar</button>
        <button type="button" id="btn-mostrar-todos" class="btn-registrar" style="margin-left: 10px;">Mostrar Todos</button>
    </div>
    <!--

    <div id="filtro-info" class="filtro-activo" style="margin: 10px 0; padding: 5px; background-color: #f0f0f0; border-radius: 5px; display: none;">
        <p>Filtro activo: Mostrando empleados registrados el <strong id="fecha-seleccionada"></strong></p>
    </div>
    -->

    <!-- Tabla de empleados -->
    <table class="tabla-tareas" id="tabla-empleados">
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Ventas ≤ $300k</th>
                <th>Ventas $300k - $800k</th>
                <th>Ventas > $800k</th>
                <th>Total Ventas</th>
                <th>Bonificación</th>
                <th>Pago Total</th>
                <th>Fecha de Registro</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($empleados)): ?>
                <?php foreach ($empleados as $empleado): ?>
                    <tr class="fila-empleado" data-fecha="<?= date('Y-m-d', strtotime($empleado['fecha_registro'])) ?>">
                        <td><?= htmlspecialchars($empleado['nombre']) ?></td>
                        <td><?= htmlspecialchars($empleado['ventas_menores_300']) ?></td>
                        <td><?= htmlspecialchars($empleado['ventas_300_800']) ?></td>
                        <td><?= htmlspecialchars($empleado['ventas_mayores_800']) ?></td>
                        <td>$<?= number_format($empleado['total_ventas'], 2) ?></td>
                        <td>$<?= number_format($empleado['bonificacion'], 2) ?></td>
                        <td>$<?= number_format($empleado['pago_total'], 2) ?></td>
                        <td><?= date('d/m/Y H:i:s', strtotime($empleado['fecha_registro'])) ?></td>
                        <td>
                            <button class="btn-detalles" 
                                    onclick="window.location.href='index.php?action=verDetalles&id=<?= $empleado['id'] ?>'">
                                Ver Detalles
                            </button>
                            <button class="btn-eliminar" 
                                    onclick="if (confirm('¿Estás seguro de eliminar a <?= htmlspecialchars($empleado['nombre']) ?>?')) { window.location.href='index.php?action=eliminar&id=<?= $empleado['id'] ?>'; }">
                                Eliminar
                            </button>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr id="no-resultados" style="display: none;">
                    <td colspan="9">No se encontraron empleados registrados en la fecha seleccionada.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<!-- Añadir el script JavaScript al final del archivo -->

<?php include 'footer.php'; ?>