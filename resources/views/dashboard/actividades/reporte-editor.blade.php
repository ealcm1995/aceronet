@extends('layouts.app')

@section('content')
<div class="container-fluid py-4">
    <div class="card shadow-sm border-0">
        <div class="card-header bg-white py-3">
            <h5 class="mb-0">Editor de Plantillas de Reportes</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('reporte.update-config') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row g-3">
                    <div class="col-md-6">
                        <div class="form-floating">
                            <input type="text" class="form-control" name="title" value="{{ $reportConfig->title }}" required>
                            <label>Título del Reporte</label>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-floating">
                            <input type="text" class="form-control" name="company_name" value="{{ $reportConfig->company_name }}" required>
                            <label>Nombre de la Empresa</label>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-floating">
                            <input type="text" class="form-control" name="technician" value="{{ $reportConfig->technician }}" required>
                            <label>Técnico Responsable</label>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-floating">
                            <input type="color" class="form-control" name="header_color" value="{{ $reportConfig->header_color }}">
                            <label>Color del Encabezado</label>
                        </div>
                    </div>
                    <div class="col-12">
                        <label>Logo de la Empresa</label>
                        <input type="file" class="form-control" name="logo">
                    </div>
                    <div class="col-12">
                        <label>Campos a mostrar</label>
                        <div class="row g-2">
                            @foreach(['fecha', 'servicio', 'diagnostico', 'sede', 'departamento', 'estado', 'solucion'] as $field)
                            <div class="col-md-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="show_fields[]" value="{{ $field }}"
                                        {{ in_array($field, $reportConfig->show_fields) ? 'checked' : '' }}>
                                    <label class="form-check-label">{{ ucfirst($field) }}</label>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="mt-4">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-2"></i>Guardar Configuración
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection 