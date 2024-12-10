<?php

namespace App\Http\Controllers;

use App\Models\Actividad;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Barryvdh\DomPDF\Facade\PDF;
use Illuminate\Support\Facades\DB;

class ActividadController extends Controller
{
    public function index()
    {
        $perPage = request('per_page', 10);

        if (request()->has('per_page') && !request()->has('page')) {
            return redirect()->route('actividades.index', ['page' => 1, 'per_page' => $perPage]);
        }

        $query = Actividad::select(
            'actividades.*',
            'sedes.nombre as sede_nombre',
            'responsable.nombre as responsable_nombre'
        )
        ->leftJoin('sedes', 'actividades.sede', '=', 'sedes.id')
        ->leftJoin('responsable', 'actividades.responsable_id', '=', 'responsable.id');

        // Manejar el ordenamiento
        if (request()->has('sort')) {
            $direction = request('direction', 'asc');
            $query->orderBy(request('sort'), $direction);
        } else {
            $query->orderBy('created_at', 'desc'); // Orden por defecto
        }

        $actividades = $query->paginate($perPage)->withQueryString();

        if (!request()->has('page')) {
            $total = $actividades->count();
            $lastPage = ceil($total / $perPage);
            return redirect()->route('actividades.index', [
                'page' => $lastPage,
                'per_page' => $perPage
            ]);
        }

        if ($actividades->count() > 0) {
            Log::info('Datos de actividades:', [
                'primera_actividad' => $actividades->first(),
                'responsable_id' => $actividades->first()->responsable_id,
                'responsable_nombre' => $actividades->first()->responsable_nombre
            ]);

            Log::info('Actividades:', [
                'muestra' => $actividades->first(),
                'responsable' => $actividades->first()->responsable_nombre ?? 'No encontrado'
            ]);
        }

        $usuarios = User::all();
        $servicios = DB::table('servicios')->select('id', 'nombre')->get();
        $sedes = DB::table('sedes')->select('id', 'nombre')->get();
        $departamentos = DB::table('departamentos')->select('id', 'nombre', 'sede_id')->get();
        $responsables = DB::table('responsable')->select('id', 'nombre')->get();

        return view('dashboard.actividades.index', compact(
            'actividades', 
            'usuarios', 
            'servicios', 
            'sedes', 
            'departamentos',
            'responsables'
        ));
    }

    public function store(Request $request)
    {
        try {
            Log::info('Datos recibidos:', $request->all());
            
            $validatedData = $request->validate([
                'fecha' => 'required|date',
                'estado' => 'required|string',
                'servicio' => 'required|string',
                'sede' => 'required',
                'departamento' => 'required|string',
                'responsable_id' => 'required',
                'diagnostico' => 'required|string',
                'descripcion' => 'required|string',
                'solucion' => 'nullable|string'
            ]);

            $validatedData['solucion'] = $validatedData['solucion'] ?? ' ';

            Log::info('Datos validados:', $validatedData);

            $actividad = Actividad::create($validatedData);
            
            Log::info('Actividad creada:', ['id' => $actividad->id]);
            
            return response()->json([
                'success' => true,
                'message' => 'Actividad creada exitosamente',
                'data' => $actividad
            ]);
        } catch (\Exception $e) {
            Log::error('Error al crear actividad:', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'Error al crear la actividad: ' . $e->getMessage()
            ], 500);
        }
    }

    public function destroy(Actividad $actividad)
    {
        try {
            Log::info('Iniciando eliminación de actividad', ['id' => $actividad->id]);
            
            if (!$actividad->exists) {
                Log::error('Actividad no existe', ['id' => $actividad->id]);
                return response()->json([
                    'success' => false,
                    'message' => 'Actividad no encontrada'
                ], 404);
            }

            $actividad->delete();
            Log::info('Actividad eliminada correctamente', ['id' => $actividad->id]);

            return response()->json([
                'success' => true,
                'message' => 'Actividad eliminada correctamente'
            ]);

        } catch (\Exception $e) {
            Log::error('Error al eliminar actividad: ' . $e->getMessage(), ['id' => $actividad->id]);
            
            return response()->json([
                'success' => false,
                'message' => 'Error al eliminar la actividad'
            ], 500);
        }
    }

    public function update(Request $request, Actividad $actividad)
    {
        try {
            Log::info('Iniciando actualización de actividad', [
                'id' => $actividad->id,
                'datos_recibidos' => $request->all()
            ]);

            $validatedData = $request->validate([
                'fecha' => 'required|date',
                'estado' => 'required|string',
                'servicio' => 'required|string',
                'sede' => 'required',
                'departamento' => 'required|string',
                'responsable_id' => 'required',
                'diagnostico' => 'required|string',
                'descripcion' => 'required|string',
                'solucion' => 'nullable|string'
            ]);

            $validatedData['solucion'] = $validatedData['solucion'] ?? ' ';

            Log::info('Datos validados:', $validatedData);

            $actividad->fill($validatedData);
            $actividad->save();

            Log::info('Actividad actualizada correctamente', [
                'id' => $actividad->id,
                'datos_actualizados' => $actividad->toArray()
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Actividad actualizada correctamente',
                'data' => $actividad
            ]);

        } catch (\Exception $e) {
            Log::error('Error al actualizar actividad:', [
                'id' => $actividad->id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'request_data' => $request->all()
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'Error al actualizar la actividad: ' . $e->getMessage()
            ], 500);
        }
    }

    public function generatePdf(Actividad $actividad)
    {
        $pdf = PDF::loadView('dashboard.actividades.pdf.servicio-tecnico', compact('actividad'));
        
        return $pdf->stream('servicio-tecnico-' . $actividad->id . '.pdf');
    }

    public function getDepartamentosPorSede($sede_id)
    {
        try {
            $departamentos = DB::table('departamentos')
                ->where('sede_id', $sede_id)
                ->get();
            
            Log::info('Departamentos encontrados:', [
                'sede_id' => $sede_id,
                'count' => $departamentos->count(),
                'departamentos' => $departamentos
            ]);
            
            return response()->json([
                'success' => true,
                'data' => $departamentos
            ]);
        } catch (\Exception $e) {
            Log::error('Error:', ['message' => $e->getMessage()]);
            return response()->json([
                'success' => false,
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function edit(Actividad $actividad)
    {
        // Obtener datos para los desplegables
        $servicios = DB::table('servicios')->select('id', 'nombre')->get();
        $sedes = DB::table('sedes')->select('id', 'nombre')->get();
        $departamentos = DB::table('departamentos')
            ->select('id', 'nombre')
            ->orderBy('nombre')
            ->get();
        $responsables = DB::table('responsable')
            ->select('id', 'nombre')
            ->get();

        return view('dashboard.actividades.partials.edit-form', compact(
            'actividad',
            'servicios',
            'sedes',
            'departamentos',
            'responsables'
        ));
    }

    public function generarReporte(Request $request)
    {
        $fechaInicio = $request->fechaInicio;
        $fechaFin = $request->fechaFin;

        $query = Actividad::select(
            'actividades.*',
            'sedes.nombre as sede_nombre',
            'responsable.nombre as responsable_nombre'
        )
        ->leftJoin('sedes', 'actividades.sede', '=', 'sedes.id')
        ->leftJoin('responsable', 'actividades.responsable_id', '=', 'responsable.id')
        ->whereBetween('fecha', [$fechaInicio, $fechaFin]);

        // Aplicar filtro por estado si se especifica
        if ($request->has('estado') && $request->estado !== '') {
            $query->where('estado', $request->estado);
        }

        $actividades = $query->orderBy('fecha', 'desc')->get();

        $pdf = PDF::loadView('dashboard.actividades.reporte', compact('actividades', 'fechaInicio', 'fechaFin'))
            ->setPaper('a4')
            ->setOptions([
                'isPhpEnabled' => true,
                'isHtml5ParserEnabled' => true,
                'isRemoteEnabled' => true,
                'images' => false
            ]);
        
        return $pdf->stream('reporte-actividades.pdf');
    }

    public function reporteEditor()
    {
        // Obtener la configuración actual del reporte
        $config = DB::table('report_config')->first();
        
        $reportConfig = $config ? (object)[
            'title' => $config->title,
            'company_name' => $config->company_name,
            'technician' => $config->technician,
            'logo' => $config->logo,
            'header_color' => $config->header_color,
            'show_fields' => json_decode($config->show_fields, true) ?? ['fecha', 'servicio', 'diagnostico', 'sede', 'departamento', 'estado']
        ] : (object)[
            'title' => 'Informe de Servicios Destacados',
            'company_name' => 'GLOBAL ACERO 26, C.A.',
            'technician' => 'Edward Centeno',
            'logo' => null,
            'header_color' => '#2e2e30',
            'show_fields' => ['fecha', 'servicio', 'diagnostico', 'sede', 'departamento', 'estado']
        ];

        return view('dashboard.actividades.reporte-editor', compact('reportConfig'));
    }

    public function updateReporteConfig(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string',
            'company_name' => 'required|string',
            'technician' => 'required|string',
            'logo' => 'nullable|image',
            'header_color' => 'required|string',
            'show_fields' => 'required|array'
        ]);

        // Convertir show_fields a JSON antes de guardar
        $validated['show_fields'] = json_encode($validated['show_fields']);

        // Guardar la configuración
        DB::table('report_config')->updateOrInsert(
            ['id' => 1],
            $validated
        );

        return redirect()->back()->with('success', 'Configuración actualizada');
    }
}