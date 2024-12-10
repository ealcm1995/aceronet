<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

abstract class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    protected function handleDelete($model, $message = 'Elemento eliminado correctamente')
    {
        try {
            Log::info('Iniciando eliminación', ['id' => $model->id]);
            
            if (!$model->exists) {
                Log::error('Elemento no existe', ['id' => $model->id]);
                return response()->json([
                    'success' => false,
                    'message' => 'Elemento no encontrado'
                ], 404);
            }

            DB::beginTransaction();
            $deleted = $model->delete();
            
            if (!$deleted) {
                DB::rollBack();
                Log::error('No se pudo eliminar', ['id' => $model->id]);
                return response()->json([
                    'success' => false,
                    'message' => 'No se pudo eliminar'
                ], 500);
            }

            DB::commit();
            Log::info('Elemento eliminado correctamente', ['id' => $model->id]);

            return response()->json([
                'success' => true,
                'message' => $message
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error al eliminar: ' . $e->getMessage(), ['id' => $model->id]);
            
            return response()->json([
                'success' => false,
                'message' => 'Error al eliminar'
            ], 500);
        }
    }
}
