@if(isset($actividad))
<div class="container-fluid p-0">
    <!-- Encabezado con estado -->
    <div class="modal-header border-0 pb-0">
        <div class="w-100">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="modal-title fw-bold" style="color: #2e2e30;">
                    Detalles de la Actividad #{{ $actividad->id }}
                </h5>
                @switch($actividad->estado)
                    @case('pendiente')
                        <span class="badge bg-warning px-3 py-2">Pendiente</span>
                        @break
                    @case('en_proceso')
                        <span class="badge bg-info px-3 py-2">En Proceso</span>
                        @break
                    @case('completado')
                        <span class="badge bg-success px-3 py-2">Completado</span>
                        @break
                    @default
                        <span class="badge bg-secondary px-3 py-2">Desconocido</span>
                @endswitch
            </div>
        </div>
    </div>

    <div class="modal-body pt-0">
        <div class="row g-3">
            <!-- Fila 1: Información básica -->
            <div class="col-md-3">
                <div class="detail-item">
                    <small class="text-muted d-block mb-1"><i class="fas fa-calendar-alt me-2"></i>Fecha</small>
                    <span class="fs-6">{{ \Carbon\Carbon::parse($actividad->fecha)->format('d/m/Y') }}</span>
                </div>
            </div>
            <div class="col-md-3">
                <div class="detail-item">
                    <small class="text-muted d-block mb-1"><i class="fas fa-cogs me-2"></i>Servicio</small>
                    <span class="fs-6">{{ $actividad->servicio }}</span>
                </div>
            </div>
            <div class="col-md-3">
                <div class="detail-item">
                    <small class="text-muted d-block mb-1"><i class="fas fa-building me-2"></i>Sede</small>
                    <span class="fs-6">{{ $actividad->sede_nombre }}</span>
                </div>
            </div>
            <div class="col-md-3">
                <div class="detail-item">
                    <small class="text-muted d-block mb-1"><i class="fas fa-sitemap me-2"></i>Departamento</small>
                    <span class="fs-6">{{ $actividad->departamento }}</span>
                </div>
            </div>

            <!-- Fila 2: Responsable y Diagnóstico -->
            <div class="col-md-6">
                <div class="detail-item">
                    <small class="text-muted d-block mb-1"><i class="fas fa-user me-2"></i>Responsable</small>
                    <span class="fs-6">{{ $actividad->responsable_nombre }}</span>
                </div>
            </div>
            <div class="col-md-6">
                <div class="detail-item">
                    <small class="text-muted d-block mb-1"><i class="fas fa-stethoscope me-2"></i>Diagnóstico</small>
                    <span class="fs-6">{{ $actividad->diagnostico }}</span>
                </div>
            </div>

            <!-- Fila 3: Descripción y Solución -->
            <div class="col-md-6">
                <div class="detail-item h-100">
                    <small class="text-muted d-block mb-2"><i class="fas fa-align-left me-2"></i>Descripción</small>
                    <p class="mb-0 fs-6">{{ $actividad->descripcion }}</p>
                </div>
            </div>
            @if($actividad->solucion)
            <div class="col-md-6">
                <div class="detail-item h-100">
                    <small class="text-muted d-block mb-2"><i class="fas fa-check-circle me-2"></i>Solución</small>
                    <p class="mb-0 fs-6">{{ $actividad->solucion }}</p>
                </div>
            </div>
            @endif

            <!-- Fila 4: Información del Sistema -->
            <div class="col-md-6">
                <small class="text-muted">
                    <i class="fas fa-clock me-1"></i>
                    Creado: {{ $actividad->created_at->format('d/m/Y H:i:s') }}
                </small>
            </div>
            <div class="col-md-6 text-md-end">
                <small class="text-muted">
                    <i class="fas fa-clock me-1"></i>
                    Actualizado: {{ $actividad->updated_at->format('d/m/Y H:i:s') }}
                </small>
            </div>
        </div>
    </div>

    <!-- Footer con botón de impresión -->
    <div class="modal-footer border-0 pt-0">
        <a href="{{ route('actividades.pdf', $actividad->id) }}" 
           class="btn btn-primary px-4 rounded-pill" 
           target="_blank">
            <i class="fas fa-print me-2"></i>
            Imprimir Formato
        </a>
    </div>
</div>

<style>
.modal-content {
    border: none;
    border-radius: 12px;
}
.detail-item {
    background-color: #f8f9fa;
    padding: 15px;
    border-radius: 8px;
    height: 100%;
    transition: all 0.2s ease;
}
.detail-item:hover {
    background-color: #f0f1f2;
}
.badge {
    font-weight: 500;
    border-radius: 6px;
}
.text-muted {
    color: #6c757d !important;
}
/* Asegurar que el modal tenga el mismo ancho que el de creación */
.modal-lg {
    max-width: 1000px !important;
}
</style>
@endif 