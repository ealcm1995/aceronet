<div class="modal fade" id="filterModal" tabindex="-1" aria-labelledby="filterModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="filterModalLabel">
                    <i class="fas fa-filter me-2"></i>Filtrar Actividades
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="filterForm" class="row g-3">
                    <div class="col-12">
                        <div class="form-floating">
                            <select class="form-select" id="estadoFilter" name="estado">
                                <option value="">Todos los estados</option>
                                <option value="pendiente">PENDIENTE</option>
                                <option value="en_proceso">EN PROCESO</option>
                                <option value="completado">COMPLETADO</option>
                            </select>
                            <label for="estadoFilter">Estado</label>
                        </div>
                    </div>

                    <div class="col-12">
                        <h6 class="mb-3">Rango de Fechas</h6>
                        <div class="row g-2">
                            <div class="col-6">
                                <div class="form-floating">
                                    <input type="date" class="form-control" id="fechaInicio" name="fechaInicio">
                                    <label for="fechaInicio">Fecha Inicio</label>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-floating">
                                    <input type="date" class="form-control" id="fechaFin" name="fechaFin">
                                    <label for="fechaFin">Fecha Fin</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" onclick="resetFilters()">
                    <i class="fas fa-undo me-2"></i>Resetear
                </button>
                <button type="button" class="btn btn-primary" onclick="aplicarFiltros()">
                    <i class="fas fa-check me-2"></i>Aplicar
                </button>
            </div>
        </div>
    </div>
</div>

<script>
function aplicarFiltros() {
    const estado = document.getElementById('estadoFilter').value;
    const fechaInicio = document.getElementById('fechaInicio').value;
    const fechaFin = document.getElementById('fechaFin').value;
    let contadorVisible = 0;
    
    document.querySelectorAll('table tbody tr').forEach(row => {
        const estadoCell = row.querySelector('td[data-estado]');
        const fechaCell = row.querySelector('td:first-child'); // Primera columna con la fecha
        if (!estadoCell || !fechaCell) return;
        
        const estadoRow = estadoCell.getAttribute('data-estado');
        const fecha = convertirFechaAISO(fechaCell.textContent.trim());
        
        let mostrarPorEstado = estado === '' || estadoRow === estado;
        let mostrarPorFecha = true;

        if (fechaInicio && fechaFin) {
            mostrarPorFecha = fecha >= fechaInicio && fecha <= fechaFin;
        } else if (fechaInicio) {
            mostrarPorFecha = fecha >= fechaInicio;
        } else if (fechaFin) {
            mostrarPorFecha = fecha <= fechaFin;
        }
        
        if (mostrarPorEstado && mostrarPorFecha) {
            row.style.display = '';
            contadorVisible++;
        } else {
            row.style.display = 'none';
        }
    });

    // Mostrar mensaje si no hay resultados
    const emptyMessage = document.querySelector('.empty-message');
    if (emptyMessage) {
        emptyMessage.style.display = contadorVisible === 0 ? '' : 'none';
    }

    // Cerrar el modal
    const modal = bootstrap.Modal.getInstance(document.getElementById('filterModal'));
    modal.hide();
}

function resetFilters() {
    document.getElementById('estadoFilter').value = '';
    document.getElementById('fechaInicio').value = '';
    document.getElementById('fechaFin').value = '';
    
    document.querySelectorAll('table tbody tr').forEach(row => {
        row.style.display = '';
    });

    const emptyMessage = document.querySelector('.empty-message');
    if (emptyMessage) {
        emptyMessage.style.display = 'none';
    }
}

// Función auxiliar para convertir fecha dd/mm/yyyy a formato ISO yyyy-mm-dd
function convertirFechaAISO(fecha) {
    const partes = fecha.split('/');
    return `${partes[2]}-${partes[1]}-${partes[0]}`;
}

// Mantener los filtros después de recargar
document.addEventListener('DOMContentLoaded', function() {
    const urlParams = new URLSearchParams(window.location.search);
    const estado = urlParams.get('estado');
    const fechaInicio = urlParams.get('fechaInicio');
    const fechaFin = urlParams.get('fechaFin');
    
    if (estado) document.getElementById('estadoFilter').value = estado;
    if (fechaInicio) document.getElementById('fechaInicio').value = fechaInicio;
    if (fechaFin) document.getElementById('fechaFin').value = fechaFin;
    
    if (estado || fechaInicio || fechaFin) {
        aplicarFiltros();
    }
});
</script>
