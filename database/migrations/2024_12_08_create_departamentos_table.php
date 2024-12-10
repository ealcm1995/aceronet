<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('departamentos', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->foreignId('sede_id')->constrained('sedes');
            $table->timestamps();
        });

        // Insertar datos iniciales
        DB::table('departamentos')->insert([
            ['nombre' => 'SISTEMAS', 'sede_id' => 1],
            ['nombre' => 'ADMINISTRACIÓN', 'sede_id' => 1],
        ]);
    }

    public function down()
    {
        Schema::dropIfExists('departamentos');
    }
}; 