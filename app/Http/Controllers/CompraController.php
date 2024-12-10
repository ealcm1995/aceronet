<?php

namespace App\Http\Controllers;

use App\Models\Compra;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class CompraController extends Controller
{
    private $rules = [
        'fecha' => 'required|date',
        'proveedor' => 'required|string',
        'producto' => 'required|string',
        'cantidad' => 'required|integer|min:1',
        'precio_unitario' => 'required|numeric|min:0',
        'total' => 'required|numeric|min:0',
        'estado' => 'required|in:pendiente,en_proceso,completado',
        'observaciones' => 'nullable|string'
    ];

    public function index()
    {
        $compras = Compra::paginate(10);
        return view('dashboard.compras.index', compact('compras'));
    }

    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate($this->rules);
            $compra = Compra::create($validatedData);
            
            return response()->json([
                'success' => true,
                'message' => 'Compra registrada exitosamente',
                'data' => $compra
            ], 201);
        } catch (\Exception $e) {
            Log::error('Error al crear compra:', ['error' => $e->getMessage()]);
            return response()->json([
                'success' => false,
                'message' => 'Error al registrar la compra: ' . $e->getMessage()
            ], 500);
        }
    }

    public function update(Request $request, Compra $compra)
    {
        try {
            $validatedData = $request->validate($this->rules);
            $compra->update($validatedData);
            
            return response()->json([
                'success' => true,
                'message' => 'Compra actualizada exitosamente',
                'data' => $compra
            ]);
        } catch (\Exception $e) {
            Log::error('Error al actualizar compra:', [
                'id' => $compra->id,
                'error' => $e->getMessage()
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'Error al actualizar la compra: ' . $e->getMessage()
            ], 500);
        }
    }

    public function destroy(Compra $compra)
    {
        try {
            $compra->delete();
            return response()->json([
                'success' => true,
                'message' => 'Compra eliminada correctamente'
            ]);
        } catch (\Exception $e) {
            Log::error('Error al eliminar compra:', [
                'id' => $compra->id,
                'error' => $e->getMessage()
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'Error al eliminar la compra'
            ], 500);
        }
    }
} 