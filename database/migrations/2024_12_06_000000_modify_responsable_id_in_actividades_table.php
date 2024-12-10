<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('actividades', function (Blueprint $table) {
            $table->foreignId('responsable_id')->nullable()->change();
        });
    }

    public function down()
    {
        Schema::table('actividades', function (Blueprint $table) {
            $table->foreignId('responsable_id')->nullable(false)->change();
        });
    }
}; 