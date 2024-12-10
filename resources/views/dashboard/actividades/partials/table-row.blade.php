<style>
.btn-icon {
    transition: all 0.3s ease;
    display: inline-flex;
    align-items: center;
    justify-content: center;
}

.btn-icon:hover {
    transform: translateY(-2px);
    box-shadow: 0 2px 5px rgba(0,0,0,0.2);
}

.btn-icon i {
    font-size: 14px;
}

.btn-outline-info:hover {
    background-color: #0dcaf0;
    color: white;
}

.btn-outline-primary:hover {
    background-color: #0d6efd;
    color: white;
}

.btn-outline-danger:hover {
    background-color: #dc3545;
    color: white;
}
</style>

{{-- Tabla de Actividades --}}
<tr data-actividad-id="{{ $actividad->id }}">
    <td class="text-center align-middle">
        {{ \Carbon\Carbon::parse($actividad->fecha)->format('d/m/Y') }}
    </td>
    <td class="text-center align-middle">{{ $actividad->servicio }}</td>
    <td class="text-center align-middle">
        <span class="text-truncate d-inline-block" style="max-width: 200px;" title="{{ $actividad->diagnostico }}">
            {{ $actividad->diagnostico }}
        </span>
    </td>
    <td class="text-center align-middle">
        {{ $actividad->sede_nombre }}
    </td>
    <td class="text-center align-middle">
        {{ $actividad->departamento }}
    </td>
    <td class="text-center align-middle">
        {{ $actividad->responsable_nombre ?? 'Sin asignar' }}
    </td>
    <td class="text-center align-middle" data-estado="{{ $actividad->estado }}">
        @switch($actividad->estado)
            @case('pendiente')
                <span class="badge bg-warning">Pendiente</span>
                @break
            @case('en_proceso')
                <span class="badge bg-info">En Proceso</span>
                @break
            @case('completado')
                <span class="badge bg-success">Completado</span>
                @break
            @default
                <span class="badge bg-secondary">Desconocido</span>
        @endswitch
    </td>
    <td class="text-center align-middle">
        <div class="d-flex align-items-center justify-content-center gap-2">
            <button type="button"
                    class="btn btn-icon btn-outline-info btn-sm rounded-circle"
                    data-bs-toggle="modal"
                    data-bs-target="#detalleModal{{ $actividad->id }}"
                    title="Ver Detalles"
                    style="width: 32px; height: 32px; padding: 0;">
                <i class="fas fa-eye"></i>
            </button>

            <button type="button"
                    class="btn btn-icon btn-outline-primary btn-sm rounded-circle"
                    data-bs-toggle="modal"
                    data-bs-target="#editModal{{ $actividad->id }}"
                    title="Editar"
                    style="width: 32px; height: 32px; padding: 0;">
                <i class="fas fa-edit"></i>
            </button>

            <button type="button"
                    class="btn btn-icon btn-outline-danger btn-sm rounded-circle"
                    onclick="window.eliminarActividad({{ $actividad->id }})"
                    title="Eliminar"
                    style="width: 32px; height: 32px; padding: 0;">
                <i class="fas fa-trash"></i>
            </button>
        </div>
    </td>
</tr> 

{{-- Modal para Ver Detalles --}}
<div class="modal fade" id="detalleModal{{ $actividad->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg" style="max-width: 1000px;">
        <div class="modal-content">
            <div class="modal-body p-0">
                @include('dashboard.actividades.partials.detalle-modal', ['actividad' => $actividad])
            </div>
        </div>
    </div>
</div>

{{-- Modal para Editar --}}
<div class="modal fade" id="editModal{{ $actividad->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Editar Actividad</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                @include('dashboard.actividades.partials.edit-form', ['actividad' => $actividad])
            </div>
        </div>
    </div>
</div>

