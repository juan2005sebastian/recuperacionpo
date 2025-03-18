// Declara contadorVentas como variable global al principio del archivo
let contadorVentas = 1;

document.addEventListener("DOMContentLoaded", function () {
    console.log("✅ DOM completamente cargado");

    // Referencias a los elementos del DOM
    const btnAgregarVentas = document.getElementById('btnAgregarVentas');
    const btnNuevoEmpleado = document.getElementById('btnNuevoEmpleado');
    const agregarVentasForm = document.getElementById('agregarVentasForm');
    const nuevoEmpleadoForm = document.getElementById('nuevoEmpleadoForm');
    const btnAgregarCampoVenta = document.getElementById('btnAgregarCampoVenta');
    const btnGenerarFormularios = document.getElementById('btnGenerarFormularios');
    const empleadoExistenteSelect = document.getElementById('empleadoExistente');
    const numEmpleadosInput = document.getElementById('numEmpleados');
    const empleadosContainer = document.getElementById('empleadosContainer');
    const ventasContainer = document.getElementById('ventasContainer');

    // Mostrar el formulario para agregar ventas a empleados existentes
    if (btnAgregarVentas) {
        btnAgregarVentas.addEventListener('click', mostrarAgregarVentas);
    }

    // Mostrar el formulario para agregar nuevos empleados
    if (btnNuevoEmpleado) {
        btnNuevoEmpleado.addEventListener('click', mostrarNuevoEmpleado);
    }

    // Agregar más campos de ventas
    if (btnAgregarCampoVenta) {
        btnAgregarCampoVenta.addEventListener('click', agregarCampoVenta);
    }

    // Generar formularios dinámicamente
    if (btnGenerarFormularios) {
        btnGenerarFormularios.addEventListener('click', generarFormularios);
    }

    // Cambiar entre formularios al seleccionar un empleado existente
    if (empleadoExistenteSelect) {
        empleadoExistenteSelect.addEventListener('change', function() {
            const nuevoEmpleadoContainer = document.getElementById('nuevoEmpleadoContainer');
            const numEmpleadosInput = document.getElementById('numEmpleados');

            // Verifica si los elementos existen antes de intentar modificarlos
            if (this.value === 'nuevo' && nuevoEmpleadoContainer) {
                nuevoEmpleadoContainer.style.display = 'block';
                if (numEmpleadosInput) {
                    numEmpleadosInput.setAttribute('required', true);
                }
            } else if (nuevoEmpleadoContainer) {
                nuevoEmpleadoContainer.style.display = 'none';
                if (numEmpleadosInput) {
                    numEmpleadosInput.removeAttribute('required');
                }
            }
        });
    }
});

// Función para mostrar el formulario de agregar ventas
function mostrarAgregarVentas() {
    const agregarVentasForm = document.getElementById('agregarVentasForm');
    const nuevoEmpleadoForm = document.getElementById('nuevoEmpleadoForm');
    
    if (agregarVentasForm) agregarVentasForm.style.display = 'block';
    if (nuevoEmpleadoForm) nuevoEmpleadoForm.style.display = 'none';
}

// Función para mostrar el formulario de agregar nuevos empleados
function mostrarNuevoEmpleado() {
    const agregarVentasForm = document.getElementById('agregarVentasForm');
    const nuevoEmpleadoForm = document.getElementById('nuevoEmpleadoForm');
    
    if (nuevoEmpleadoForm) nuevoEmpleadoForm.style.display = 'block';
    if (agregarVentasForm) agregarVentasForm.style.display = 'none';
}

// Función para agregar más campos de ventas
function agregarCampoVenta() {
    // Asegúrate de que contadorVentas existe y está accesible aquí
    contadorVentas++;
    const ventasContainer = document.getElementById('ventasContainer');
    if (ventasContainer) {
        const nuevoCampo = document.createElement('div');
        nuevoCampo.classList.add('campo');
        nuevoCampo.innerHTML = `
            <label for="ventas${contadorVentas}">Venta ${contadorVentas}:</label>
            <input type="number" id="ventas${contadorVentas}" name="ventas[]" step="0.01" min="0" required>
        `;
        ventasContainer.appendChild(nuevoCampo);
    }
}

// Función para generar formularios dinámicamente
function generarFormularios() {
    const numEmpleadosInput = document.getElementById('numEmpleados');
    const empleadosContainer = document.getElementById('empleadosContainer');
    
    if (!numEmpleadosInput || !empleadosContainer) return;
    
    const numEmpleados = numEmpleadosInput.value;
    empleadosContainer.innerHTML = ''; // Limpiar el contenedor

    for (let i = 1; i <= numEmpleados; i++) {
        empleadosContainer.innerHTML += `
            <div class="campo">
                <h4>Empleado ${i}</h4>
                <label for="nombre${i}">Nombre:</label>
                <input type="text" id="nombre${i}" name="empleados[${i}][nombre]" required>
                
                <label>Ventas:</label>
                <div id="ventasContainer${i}" class="ventas-container">
                    <input type="number" name="empleados[${i}][ventas][]" step="0.01" min="0" required>
                </div>
                <button type="button" onclick="agregarVenta(${i})" class="btn-registrar">Agregar Venta</button>
            </div>
        `;
    }
}

// Función para agregar más campos de ventas para un empleado específico
function agregarVenta(empleadoId) {
    const ventasContainer = document.getElementById(`ventasContainer${empleadoId}`);
    if (!ventasContainer) return;
    
    const nuevoCampo = document.createElement('input');
    nuevoCampo.type = 'number';
    nuevoCampo.name = `empleados[${empleadoId}][ventas][]`;
    nuevoCampo.step = '0.01';
    nuevoCampo.min = '0';
    nuevoCampo.required = true;
    ventasContainer.appendChild(nuevoCampo);
}

// filtro
