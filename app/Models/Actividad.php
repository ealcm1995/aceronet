<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Support\Facades\Log;

class Actividad extends Model
{
    use HasFactory;

    protected $table = 'actividades';

    protected $fillable = [
        'fecha',
        'estado',
        'servicio',
        'sede',
        'departamento',
        'responsable_id',
        'diagnostico',
        'descripcion',
        'solucion'
    ];

    protected $casts = [
        'fecha' => 'date:Y-m-d'
    ];

    /**
     * Obtiene el usuario responsable de la actividad
     */
    public function responsable()
    {
        return $this->belongsTo('App\Models\Responsable', 'responsable_id');
    }

    public function delete()
    {
        try {
            return parent::delete();
        } catch (\Exception $e) {
            Log::error('Error al eliminar actividad: ' . $e->getMessage());
            throw $e;
        }
    }
} 