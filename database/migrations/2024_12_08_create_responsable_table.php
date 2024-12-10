<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('responsable', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->timestamps();
        });

        // Insertar datos iniciales
        DB::table('responsable')->insert([
            ['nombre' => 'Edward Centeno'],
        ]);
    }

    public function down()
    {
        Schema::dropIfExists('responsable');
    }
}; 