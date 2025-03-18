document.addEventListener('DOMContentLoaded', function() {
    // Referencias a elementos del DOM
    const btnFiltrar = document.getElementById('btn-filtrar');
    const btnMostrarTodos = document.getElementById('btn-mostrar-todos');
    const inputFecha = document.getElementById('fecha_js');
    const filtroInfo = document.getElementById('filtro-info');
    const fechaSeleccionada = document.getElementById('fecha-seleccionada');
    const filas = document.querySelectorAll('.fila-empleado');
    const noResultados = document.getElementById('no-resultados');
    
    // Función para formatear la fecha en formato dd/mm/yyyy
    function formatearFecha(fecha) {
        const f = new Date(fecha);
        const dia = f.getDate().toString().padStart(2, '0');
        const mes = (f.getMonth() + 1).toString().padStart(2, '0');
        const anio = f.getFullYear();
        return `${dia}/${mes}/${anio}`;
    }
    
    // Función para filtrar las filas por fecha
    function filtrarPorFecha() {
        const fecha = inputFecha.value;
        if (!fecha) {
            alert('Por favor, selecciona una fecha');
            return;
        }
        
        let hayResultados = false;
        
        // Recorrer todas las filas y mostrar/ocultar según la fecha
        filas.forEach(fila => {
            const fechaFila = fila.getAttribute('data-fecha');
            if (fechaFila === fecha) {
                fila.style.display = '';
                hayResultados = true;
            } else {
                fila.style.display = 'none';
            }
        });
        
        // Mostrar mensaje si no hay resultados
        if (!hayResultados && noResultados) {
            noResultados.style.display = '';
        } else if (noResultados) {
            noResultados.style.display = 'none';
        }
        
        // Mostrar información del filtro activo
        fechaSeleccionada.textContent = formatearFecha(fecha);
        filtroInfo.style.display = 'block';
    }
    
    // Función para mostrar todas las filas
    function mostrarTodos() {
        filas.forEach(fila => {
            fila.style.display = '';
        });
        
        if (noResultados) {
            noResultados.style.display = 'none';
        }
        
        filtroInfo.style.display = 'none';
        inputFecha.value = '';
    }
    
    // Asignar eventos a los botones
    btnFiltrar.addEventListener('click', filtrarPorFecha);
    btnMostrarTodos.addEventListener('click', mostrarTodos);
    
    // También filtrar al presionar Enter en el campo de fecha
    inputFecha.addEventListener('keyup', function(event) {
        if (event.key === 'Enter') {
            filtrarPorFecha();
        }
    });
});