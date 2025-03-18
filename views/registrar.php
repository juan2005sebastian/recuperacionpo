<?php include 'header.php'; ?>
<div class="container">
    <h2>Agregar Ventas</h2>

    <!-- Botones para cambiar entre agregar ventas y agregar nuevos empleados -->
    <div class="campo">
        <button type="button" id="btnAgregarVentas" class="btn-registrar">Agregar Ventas a Empleado Existente</button>
        <button type="button" id="btnNuevoEmpleado" class="btn-registrar">Agregar Nuevo Empleado</button>
    </div>

    <!-- Formulario para agregar ventas a un empleado existente -->
    <form action="index.php?action=agregarVentas" method="POST" id="agregarVentasForm" class="formulario" style="display: none;">
    <h3>Agregar Ventas a Empleado Existente</h3>
    <div class="campo">
        <label for="empleadoExistente">Seleccionar Empleado:</label>
        <select id="empleadoExistente" name="empleado_id" required>
            <option value="">-- Seleccione un empleado --</option>
            <?php if (isset($empleados) && !empty($empleados)): ?>
                <?php foreach ($empleados as $empleado): ?>
                    <option value="<?= $empleado['id'] ?>"><?= htmlspecialchars($empleado['nombre']) ?></option>
                <?php endforeach; ?>
            <?php endif; ?>
        </select>
    </div>

        <!-- Contenedor para agregar múltiples ventas -->
        <div id="ventasContainer">
            <div class="campo">
                <label for="ventas1">Venta 1:</label>
                <input type="number" id="ventas1" name="ventas[]" step="0.01" min="0" required>
            </div>
        </div>

        <!-- Botón para agregar más campos de ventas -->
        <button type="button" id="btnAgregarCampoVenta" class="btn-registrar">Agregar Más Ventas</button>

        <!-- Botón para guardar todas las ventas -->
        <button type="submit" class="btn-registrar">Guardar Ventas</button>
    </form>

    <!-- Formulario para agregar nuevos empleados -->
    <form action="index.php?action=guardar" method="POST" id="nuevoEmpleadoForm" class="formulario" style="display: none;">
        <h3>Agregar Nuevo Empleado</h3>
        <div class="campo">
            <label for="numEmpleados">Número de Empleados a Agregar:</label>
            <input type="number" id="numEmpleados" name="numEmpleados" min="1">
            <button type="button" id="btnGenerarFormularios" class="btn-registrar">Generar Formularios</button>
        </div>

        <!-- Contenedor dinámico para los formularios de nuevos empleados -->
        <div id="empleadosContainer"></div>

        <!-- Botón para enviar el formulario -->
        <button type="submit" class="btn-registrar">Guardar</button>
    </form>
</div>

<?php include 'footer.php'; ?>