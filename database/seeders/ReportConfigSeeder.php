<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ReportConfigSeeder extends Seeder
{
    public function run()
    {
        DB::table('report_config')->insert([
            'title' => 'Informe de Servicios Destacados',
            'company_name' => 'GLOBAL ACERO 26, C.A.',
            'technician' => 'Edward Centeno',
            'header_color' => '#2e2e30',
            'show_fields' => json_encode(['fecha', 'servicio', 'diagnostico', 'sede', 'departamento', 'estado']),
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }
} 