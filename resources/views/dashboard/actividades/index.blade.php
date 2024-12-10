@extends('layouts.app')

@section('title', 'Planificación de Actividades')

@section('content')
    <div class="container-fluid py-4 px-4" style="background-color: #f5f5f5;">
        <!-- Componente de Filtros -->
        <div class="mb-5">
            @include('dashboard.actividades.partials.filters')
        </div>

        <!-- Tabla de Actividades -->
        <div class="card shadow-sm border-0 rounded-3">
            <div class="card-header bg-white py-3 border-0">
                <div class="d-flex justify-content-between align-items-center px-3">
                    <h5 class="mb-0 fw-bold" style="color: #2e2e30; font-size: 1.1rem;">Lista de Actividades</h5>
                    <div class="d-flex gap-2">
                        <button class="btn btn-outline-secondary btn-sm rounded-pill px-3 py-1" data-bs-toggle="modal" data-bs-target="#filterModal">
                            <i class="fas fa-filter me-1"></i>Filtros
                        </button>
                        
                        <button class="btn btn-outline-secondary btn-sm rounded-pill px-3 py-1" data-bs-toggle="modal" data-bs-target="#reporteModal">
                            <i class="fas fa-chart-bar me-1"></i>Reporte
                        </button>
                        
                        <button type="button" class="btn btn-primary btn-sm rounded-pill px-3 py-1" data-bs-toggle="modal" data-bs-target="#createActividadModal">
                            <i class="fas fa-plus me-1"></i>Nueva Actividad
                        </button>
                    </div>
                </div>
            </div>
            
            <div class="card-body px-4 py-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <style>
                            .table {
                                border-collapse: separate;
                                border-spacing: 0 6px;
                                margin-top: -6px;
                            }
                            .table thead th {
                                border: none;
                                font-weight: 600;
                                color: #6c757d;
                                font-size: 0.85rem;
                                text-transform: uppercase;
                                letter-spacing: 0.3px;
                                padding: 12px 8px;
                            }
                            .table tbody tr {
                                background: white;
                                box-shadow: 0 1px 2px rgba(0,0,0,0.03);
                                transition: all 0.2s ease;
                                border-radius: 8px;
                            }
                            .table tbody tr:hover {
                                background-color: #f8f9fa;
                                transform: translateY(-1px);
                                box-shadow: 0 2px 4px rgba(0,0,0,0.05);
                            }
                            .table td {
                                border: none;
                                padding: 10px 8px;
                                font-size: 0.9rem;
                                color: #444;
                            }
                            .badge {
                                font-weight: 500;
                                padding: 4px 10px;
                                border-radius: 4px;
                                font-size: 0.75rem;
                            }
                            .btn-icon {
                                width: 28px;
                                height: 28px;
                                padding: 0;
                                display: inline-flex;
                                align-items: center;
                                justify-content: center;
                                border-radius: 6px;
                                transition: all 0.2s;
                            }
                            .btn-icon:hover {
                                transform: translateY(-1px);
                            }
                        </style>
                        @include('dashboard.actividades.partials.table-header')
                        <tbody>
                            @forelse($actividades as $actividad)
                                @include('dashboard.actividades.partials.table-row', ['actividad' => $actividad])
                            @empty
                                @include('dashboard.actividades.partials.empty-state')
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Reemplazar el div de paginación actual -->
        <div class="d-flex justify-content-between align-items-center mt-4">
            <!-- Selector de registros por página (izquierda) -->
            <div class="pagination-select">
                <select class="form-select form-select-sm" id="perPage" onchange="changePerPage(this.value)">
                    <option value="10" {{ request('per_page') == 10 ? 'selected' : '' }}>10 registros</option>
                    <option value="30" {{ request('per_page') == 30 ? 'selected' : '' }}>30 registros</option>
                    <option value="50" {{ request('per_page') == 50 ? 'selected' : '' }}>50 registros</option>
                    <option value="100" {{ request('per_page') == 100 ? 'selected' : '' }}>100 registros</option>
                </select>
            </div>

            <!-- Paginación (centro) -->
            <nav class="pagination-nav">
                <ul class="pagination mb-0">
                    <!-- Previous Page Link -->
                    @if ($actividades->onFirstPage())
                        <li class="page-item disabled">
                            <span class="page-link">Anterior</span>
                        </li>
                    @else
                        <li class="page-item">
                            <a class="page-link" href="{{ $actividades->previousPageUrl() }}">Anterior</a>
                        </li>
                    @endif

                    <!-- Pagination Elements -->
                    @foreach ($actividades->getUrlRange(1, $actividades->lastPage()) as $page => $url)
                        @if ($page == $actividades->currentPage())
                            <li class="page-item active">
                                <span class="page-link">{{ $page }}</span>
                            </li>
                        @else
                            <li class="page-item">
                                <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                            </li>
                        @endif
                    @endforeach

                    <!-- Next Page Link -->
                    @if ($actividades->hasMorePages())
                        <li class="page-item">
                            <a class="page-link" href="{{ $actividades->nextPageUrl() }}">Siguiente</a>
                        </li>
                    @else
                        <li class="page-item disabled">
                            <span class="page-link">Siguiente</span>
                        </li>
                    @endif
                </ul>
            </nav>

            <!-- Contador de registros (derecha) -->
            <div class="pagination-info-container">
                <div class="pagination-info">
                    Mostrando {{ $actividades->firstItem() ?? 0 }} - {{ $actividades->lastItem() ?? 0 }} 
                    de {{ $actividades->total() }} registros
                </div>
            </div>
        </div>
    </div>

    <!-- Modal de Creación -->
    <div class="modal fade" id="createActividadModal" tabindex="-1" aria-labelledby="createActividadModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createActividadModalLabel">Nueva Actividad</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    @include('dashboard.actividades.partials.create-modal')
                </div>
            </div>
        </div>
    </div>

    <!-- Modal de Reporte -->
    <div class="modal fade" id="reporteModal" tabindex="-1" aria-labelledby="reporteModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="reporteModalLabel">
                        <i class="fas fa-chart-bar me-2"></i>Generar Reporte
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="reporteForm" class="row g-3">
                        <!-- Selector de Estado -->
                        <div class="col-12 mb-3">
                            <div class="form-floating">
                                <select class="form-select" id="estadoReporte" name="estado">
                                    <option value="">Todos los estados</option>
                                    <option value="pendiente">Pendiente</option>
                                    <option value="en_proceso">En Proceso</option>
                                    <option value="completado">Completado</option>
                                </select>
                                <label for="estadoReporte">Filtrar por Estado</label>
                            </div>
                        </div>
                        
                        <!-- Fechas -->
                        <div class="col-md-6">
                            <div class="form-floating">
                                <input type="date" class="form-control" id="fechaInicio" name="fechaInicio" required>
                                <label for="fechaInicio">Fecha Inicio</label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-floating">
                                <input type="date" class="form-control" id="fechaFin" name="fechaFin" required>
                                <label for="fechaFin">Fecha Fin</label>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times me-2"></i>Cerrar
                    </button>
                    <button type="button" class="btn btn-primary" onclick="generarReporte()">
                        <i class="fas fa-file-download me-2"></i>Generar Reporte
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
    function generarReporte() {
        const fechaInicio = document.querySelector('#reporteForm [name="fechaInicio"]').value;
        const fechaFin = document.querySelector('#reporteForm [name="fechaFin"]').value;
        const estado = document.querySelector('#reporteForm [name="estado"]').value;
        
        // Debug para ver los valores
        console.log('Fechas seleccionadas:', { fechaInicio, fechaFin, estado });
        
        if (!fechaInicio || !fechaFin) {
            toastr.error('Por favor seleccione ambas fechas');
            return;
        }

        // Cerrar el modal
        const modal = bootstrap.Modal.getInstance(document.getElementById('reporteModal'));
        if (modal) {
            modal.hide();
        }

        // Construir la URL con los parámetros
        let url = `{{ route('actividades.reporte') }}?fechaInicio=${fechaInicio}&fechaFin=${fechaFin}`;
        if (estado) {
            url += `&estado=${estado}`;
        }

        // Debug para ver la URL final
        console.log('URL generada:', url);

        // Abrir en nueva pestaña
        window.open(url, '_blank');
    }

    function changePerPage(value) {
        const url = new URL(window.location.href);
        url.searchParams.set('per_page', value);
        window.location.href = url.toString();
    }
    </script>
@endsection

<style>
.pagination-nav {
    background: white;
    padding: 0.5rem;
    border-radius: 8px;
    box-shadow: 0 1px 3px rgba(0,0,0,0.1);
}

.pagination {
    display: flex;
    gap: 4px;
    margin: 0;
}

.page-item {
    margin: 0;
}

.page-link {
    min-width: 36px;
    height: 36px;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 0 12px;
    border: none;
    border-radius: 6px;
    color: #6c757d;
    font-size: 14px;
    font-weight: 500;
    transition: all 0.2s;
}

.page-item.active .page-link {
    background-color: #0d6efd;
    color: white;
    box-shadow: 0 2px 4px rgba(13, 110, 253, 0.2);
}

.page-link:hover:not(.disabled) {
    background-color: #e9ecef;
    color: #0d6efd;
}

.page-item.disabled .page-link {
    color: #adb5bd;
    pointer-events: none;
    background-color: transparent;
}

.pagination-info {
    color: #6c757d;
    font-size: 13px;
    padding-bottom: 8px;
    border-bottom: 1px solid #eee;
}

.pagination-select {
    background: white;
    padding: 6px;
    border-radius: 8px;
    box-shadow: 0 1px 3px rgba(0,0,0,0.1);
}

.pagination-select .form-select {
    border: none;
    width: auto;
    padding: 4px 32px 4px 12px;
    font-size: 13px;
    color: #666;
    cursor: pointer;
    background-color: transparent;
}

.pagination-select .form-select:focus {
    box-shadow: none;
    border: none;
}

.pagination-nav {
    background: white;
    padding: 0.5rem 1rem;
    border-radius: 8px;
    box-shadow: 0 1px 3px rgba(0,0,0,0.1);
    margin: 0 15px;  /* Espacio a los lados */
}

.pagination-info-container {
    background: white;
    padding: 8px 16px;
    border-radius: 8px;
    box-shadow: 0 1px 3px rgba(0,0,0,0.1);
}

.pagination-info {
    color: #6c757d;
    font-size: 13px;
    white-space: nowrap;
}
</style> 