<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

<div class="container-fluid p-4">
    <form id="createActividadForm" onsubmit="createActividad(event)">
        @csrf
        <input type="hidden" name="solucion" value=" ">
        <div class="row g-3">
            <!-- Primera fila -->
            <div class="col-md-6">
                <div class="form-floating">
                    <input type="date" class="form-control" id="fecha" name="fecha" required>
                    <label for="fecha"><i class="fas fa-calendar-alt"></i> Fecha</label>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-floating">
                    <select class="form-select" id="estado" name="estado" required>
                        <option value="" disabled selected>Seleccione el estatus</option>
                        <option value="pendiente">PENDIENTE</option>
                        <option value="en_proceso">EN PROCESO</option>
                        <option value="completado">COMPLETADO</option>
                    </select>
                    <label for="estado"><i class="fas fa-tasks"></i> Estado</label>
                </div>
            </div>

            <!-- Segunda fila -->
            <div class="col-md-4">
                <div class="form-floating">
                    <select class="form-select" id="servicio" name="servicio" required>
                        <option value="" disabled selected>Seleccione un servicio</option>
                        @foreach($servicios as $servicio)
                            <option value="{{ $servicio->nombre }}">{{ $servicio->nombre }}</option>
                        @endforeach
                    </select>
                    <label for="servicio"><i class="fas fa-cogs"></i> Servicio</label>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-floating">
                    <select class="form-select" id="sede" name="sede" required onchange="updateDepartments()">
                        <option value="" disabled selected>Seleccione la sede</option>
                        @foreach($sedes as $sede)
                            <option value="{{ $sede->id }}">{{ $sede->nombre }}</option>
                        @endforeach
                    </select>
                    <label for="sede"><i class="fas fa-building"></i> Sede</label>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-floating">
                    <select class="form-select" id="departamento" name="departamento" required>
                        <option value="" disabled selected>Seleccione un departamento</option>
                        @foreach($departamentos as $departamento)
                            <option value="{{ $departamento->nombre }}">{{ $departamento->nombre }}</option>
                        @endforeach
                    </select>
                    <label for="departamento"><i class="fas fa-sitemap"></i> Departamento</label>
                </div>
            </div>

            <!-- Tercera fila -->
            <div class="col-md-6">
                <div class="form-floating">
                    <select class="form-select" id="responsable_id" name="responsable_id" required>
                        <option value="" disabled selected>Seleccione un responsable</option>
                        @foreach($responsables as $responsable)
                            <option value="{{ $responsable->id }}">{{ $responsable->nombre }}</option>
                        @endforeach
                    </select>
                    <label for="responsable_id"><i class="fas fa-user"></i> Responsable</label>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-floating">
                    <input type="text" class="form-control" id="diagnostico" name="diagnostico" required>
                    <label for="diagnostico"><i class="fas fa-stethoscope"></i> Diagnóstico</label>
                </div>
            </div>

            <!-- Descripción a ancho completo -->
            <div class="col-12">
                <div class="form-floating">
                    <textarea class="form-control" id="descripcion" name="descripcion" style="height: 120px" required></textarea>
                    <label for="descripcion"><i class="fas fa-align-left"></i> Descripción</label>
                </div>
            </div>
        </div>

        <div class="modal-footer pt-4">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                <i class="fas fa-times"></i> Cerrar
            </button>
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save"></i> Guardar
            </button>
        </div>
    </form>
</div>

<script>
function createActividad(event) {
    event.preventDefault();
    
    const formData = new FormData(document.getElementById('createActividadForm'));
    
    fetch('{{ route("actividades.store") }}', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Accept': 'application/json'
        },
        body: formData
    })
    .then(response => {
        if (!response.ok) {
            return response.json().then(err => Promise.reject(err));
        }
        return response.json();
    })
    .then(data => {
        if (data.success) {
            document.querySelector('[data-bs-dismiss="modal"]').click();
            toastr.success('Actividad creada');
            setTimeout(() => window.location.reload(), 500);
        } else {
            toastr.error(data.message || 'No se pudo crear la actividad');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        toastr.error(error.message || 'Error al crear la actividad');
    });
}
</script>
