<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('servicios', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->timestamps();
        });

        // Insertar datos iniciales
        DB::table('servicios')->insert([
            ['nombre' => 'HARDWARE'],
            ['nombre' => 'SOFTWARE'],
            ['nombre' => 'RED'],
        ]);
    }

    public function down()
    {
        Schema::dropIfExists('servicios');
    }
}; 