<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
<link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet">

<div class="container-fluid p-4">
    <form id="editForm{{ $actividad->id }}" onsubmit="updateActividad(event, {{ $actividad->id }})">
        @csrf
        @method('PUT')
        <div class="row g-3">
            <!-- Primera fila -->
            <div class="col-md-6">
                <div class="form-floating">
                    <input type="date" 
                           class="form-control" 
                           id="fecha" 
                           name="fecha" 
                           value="{{ date('Y-m-d', strtotime($actividad->fecha)) }}" 
                           required>
                    <label for="fecha"><i class="fas fa-calendar-alt"></i> Fecha</label>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-floating">
                    <select class="form-select" id="estado" name="estado" required>
                        <option value="" disabled>Seleccione el estatus</option>
                        <option value="pendiente" {{ $actividad->estado == 'pendiente' ? 'selected' : '' }}>PENDIENTE</option>
                        <option value="en_proceso" {{ $actividad->estado == 'en_proceso' ? 'selected' : '' }}>EN PROCESO</option>
                        <option value="completado" {{ $actividad->estado == 'completado' ? 'selected' : '' }}>COMPLETADO</option>
                    </select>
                    <label for="estado"><i class="fas fa-tasks"></i> Estado</label>
                </div>
            </div>

            <!-- Segunda fila -->
            <div class="col-md-4">
                <div class="form-floating">
                    <select class="form-select" id="servicio" name="servicio" required>
                        <option value="" disabled>Seleccione un servicio</option>
                        @foreach($servicios as $servicio)
                            <option value="{{ $servicio->nombre }}" {{ $actividad->servicio == $servicio->nombre ? 'selected' : '' }}>
                                {{ $servicio->nombre }}
                            </option>
                        @endforeach
                    </select>
                    <label for="servicio"><i class="fas fa-cogs"></i> Servicio</label>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-floating">
                    <select class="form-select" id="sede" name="sede" required>
                        <option value="" disabled>Seleccione la sede</option>
                        @foreach($sedes as $sede)
                            <!-- Debug: Actividad sede = {{ $actividad->sede }} -->
                            <option value="{{ $sede->id }}" {{ $actividad->sede == $sede->id ? 'selected' : '' }}>
                                {{ $sede->nombre }}
                            </option>
                        @endforeach
                    </select>
                    <label for="sede"><i class="fas fa-building"></i> Sede</label>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-floating">
                    <select class="form-select" id="departamento" name="departamento" required>
                        <option value="" disabled>Seleccione un departamento</option>
                        @foreach($departamentos as $departamento)
                            <option value="{{ $departamento->nombre }}" {{ $actividad->departamento == $departamento->nombre ? 'selected' : '' }}>
                                {{ $departamento->nombre }}
                            </option>
                        @endforeach
                    </select>
                    <label for="departamento"><i class="fas fa-sitemap"></i> Departamento</label>
                </div>
            </div>

            <!-- Tercera fila -->
            <div class="col-md-6">
                <div class="form-floating">
                    <select class="form-select" id="responsable_id" name="responsable_id" required>
                        <option value="" disabled>Seleccione un responsable</option>
                        @foreach($responsables as $responsable)
                            <option value="{{ $responsable->id }}" {{ $actividad->responsable_id == $responsable->id ? 'selected' : '' }}>
                                {{ $responsable->nombre }}
                            </option>
                        @endforeach
                    </select>
                    <label for="responsable_id"><i class="fas fa-user"></i> Responsable</label>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-floating mb-2">
                    <input type="text" class="form-control form-control-sm" id="diagnostico" name="diagnostico" value="{{ $actividad->diagnostico }}" required>
                    <label for="diagnostico"><i class="fas fa-stethoscope"></i> Diagnóstico</label>
                </div>
            </div>

            <!-- Descripción a ancho completo -->
            <div class="col-12">
                <div class="form-floating">
                    <textarea class="form-control" id="descripcion" name="descripcion" style="height: 120px" required>{{ $actividad->descripcion }}</textarea>
                    <label for="descripcion"><i class="fas fa-align-left"></i> Descripción</label>
                </div>
            </div>

            <!-- Después del campo de descripción y antes del footer del modal -->
            <div class="col-12 mt-3">
                <div class="form-floating">
                    <textarea class="form-control" 
                              id="solucion" 
                              name="solucion" 
                              style="height: 120px">{{ $actividad->solucion }}</textarea>
                    <label for="solucion">
                        <i class="fas fa-check-circle"></i> Solución
                    </label>
                </div>
            </div>
        </div>

        <div class="modal-footer pt-4">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                <i class="fas fa-times"></i> Cancelar
            </button>
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save"></i> Guardar Cambios
            </button>
        </div>
    </form>
</div>

<script>
function updateActividad(event, id) {
    event.preventDefault();
    
    const formData = new FormData(document.getElementById('editForm' + id));
    formData.append('_method', 'PUT');
    
    fetch('{{ url("/") }}/actividades/' + id, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Accept': 'application/json'
        },
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            document.querySelector(`#editModal${id}`).querySelector('[data-bs-dismiss="modal"]').click();
            toastr.success('Actividad actualizada');
            setTimeout(() => window.location.reload(), 500);
        } else {
            toastr.error('No se pudo actualizar la actividad');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        toastr.error('Error al actualizar');
    });
}
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<script>
// Agregar evento al campo solución
document.addEventListener('DOMContentLoaded', function() {
    const solucionTextarea = document.getElementById('solucion');
    const estadoSelect = document.getElementById('estado');
    const estadoOriginal = estadoSelect.value; // Guardar el estado original

    solucionTextarea.addEventListener('input', function() {
        // Si se escribe algo en el campo solución
        if (this.value.trim() !== '') {
            // Cambiar el estado a completado
            estadoSelect.value = 'completado';
        } else {
            // Si el campo está vacío, volver al estado original
            estadoSelect.value = estadoOriginal;
        }
        // Opcional: Disparar un evento change para actualizar cualquier listener
        estadoSelect.dispatchEvent(new Event('change'));
    });
});
</script>
