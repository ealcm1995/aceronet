import './bootstrap';

document.addEventListener('DOMContentLoaded', function() {
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl)
    })

    document.querySelectorAll('.delete-form').forEach(form => {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            if (confirm('¿Está seguro de que desea eliminar esta actividad?')) {
                this.submit();
            }
        });
    });
});

function eliminarActividad(id) {
    if (!confirm('¿Está seguro de que desea eliminar esta actividad?')) {
        return;
    }

    fetch(`/actividades/${id}`, {
        method: 'DELETE',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Accept': 'application/json',
            'Content-Type': 'application/json'
        },
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            const row = document.querySelector(`tr[data-actividad-id="${id}"]`);
            if (row) {
                row.remove();
                alert('Actividad eliminada con éxito');
            }
        } else {
            throw new Error(data.message || 'Error al eliminar la actividad');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Error al eliminar la actividad: ' + error.message);
    });
}

function createActividad(event) {
    event.preventDefault();
    
    const form = event.target;
    const formData = new FormData(form);
    const data = {};
    
    // Convertir FormData a objeto y mostrar los datos que se envían
    formData.forEach((value, key) => {
        data[key] = value;
        console.log(`${key}: ${value}`); // Para depuración
    });
    
    fetch('/actividades', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Accept': 'application/json',
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(data)
    })
    .then(response => {
        if (!response.ok) {
            return response.json().then(err => Promise.reject(err));
        }
        return response.json();
    })
    .then(data => {
        console.log('Respuesta del servidor:', data); // Para depuración
        if (data.success) {
            // Cerrar el modal
            const modal = document.querySelector('#createActividadModal');
            const modalInstance = bootstrap.Modal.getInstance(modal);
            modalInstance.hide();
            
            // Recargar la página o actualizar la tabla
            window.location.reload();
        } else {
            throw new Error(data.message || 'Error al crear la actividad');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Error al crear la actividad: ' + (error.message || 'Error desconocido'));
    });
}

function createActividadRow(actividad) {
    const row = document.createElement('tr');
    row.dataset.actividadId = actividad.id;
    
    row.innerHTML = `
        <td class="text-center align-middle">${formatDate(actividad.fecha)}</td>
        <td class="text-center align-middle">${actividad.servicio}</td>
        <td class="text-center align-middle">${actividad.sede}</td>
        <td class="text-center align-middle">${actividad.responsable?.name || 'Sin asignar'}</td>
        <td class="text-center align-middle">
            <span class="badge bg-${getEstadoClass(actividad.estado)}">${formatEstado(actividad.estado)}</span>
        </td>
        <td class="text-center align-middle">
            <div class="d-flex align-items-center justify-content-center gap-3">
                <button type="button" class="action-btn view-btn me-2" data-bs-toggle="modal" 
                        data-bs-target="#detalleModal${actividad.id}" title="Ver Detalles">
                    <i class="fas fa-eye"></i>
                </button>
                <button type="button" class="action-btn edit-btn me-2" data-bs-toggle="modal"
                        data-bs-target="#editarModal${actividad.id}" title="Editar">
                    <i class="fas fa-edit"></i>
                </button>
                <button type="button" class="action-btn delete-btn" 
                        onclick="eliminarActividad(${actividad.id})" title="Eliminar">
                    <i class="fas fa-trash"></i>
                </button>
            </div>
        </td>
    `;
    
    return row;
}

function formatDate(date) {
    return new Date(date).toLocaleDateString('es-ES');
}

function getEstadoClass(estado) {
    const classes = {
        'pendiente': 'warning',
        'en_proceso': 'info',
        'completado': 'success'
    };
    return classes[estado] || 'secondary';
}

function formatEstado(estado) {
    const estados = {
        'pendiente': 'Pendiente',
        'en_proceso': 'En Proceso',
        'completado': 'Completado'
    };
    return estados[estado] || estado;
}

