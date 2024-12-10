<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('sedes', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->timestamps();
        });

        // Insertar datos iniciales
        DB::table('sedes')->insert([
            ['nombre' => 'SEDE PRINCIPAL'],
            ['nombre' => 'SEDE SECUNDARIA'],
        ]);
    }

    public function down()
    {
        Schema::dropIfExists('sedes');
    }
}; 