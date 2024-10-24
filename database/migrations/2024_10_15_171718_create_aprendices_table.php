<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('aprendices', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('tipo_documento');
            $table->string('numero_documento')->unique();
            $table->string('nombres');
            $table->string('apellidos');
            $table->string('celular1')->nullable();
            $table->string('celular2')->nullable();
            $table->string('correo_personal')->nullable();
            $table->string('correo_institucional')->nullable();
            $table->string('genero')->nullable();
            $table->string('estado')->nullable();
            $table->string('pruebas_tyt')->nullable();
            $table->foreignId('programa_formacion_id')->nullable()->constrained('programa_formacion')->onDelete('set null');
            $table->unsignedBigInteger('instructor_seguimiento_id')->nullable();
            $table->foreign('instructor_seguimiento_id')->references('id')->on('instructores_seguimiento')->onDelete('set null');
            $table->date('fecha_asignacion')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('aprendices');
    }
};
