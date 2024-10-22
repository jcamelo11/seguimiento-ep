<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('instructores_seguimiento', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nombre');
            $table->string('apellidos');
            $table->string('telefono')->nullable();
            $table->string('correo')->unique();
            $table->string('profesion')->nullable();
            $table->string('area')->nullable();
            $table->string('tipo_contrato')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('instructores_seguimiento');
    }
};
