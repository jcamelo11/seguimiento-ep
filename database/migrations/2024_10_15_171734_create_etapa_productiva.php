<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('etapa_productiva', function (Blueprint $table) {
            $table->id();
            $table->string('modalidad_etapa');
            $table->date('fecha_inicio');
            $table->date('fecha_final');
            $table->date('fecha_final_prorroga')->nullable();
            $table->string('empresa');
            $table->string('ciudad_practica')->nullable();
            $table->string('estado_etapa_productiva')->nullable();
            $table->string('etapa_de_la_practica')->nullable();
            $table->boolean('patrocinio')->default(false);
            $table->foreignId('aprendiz_id')->constrained('aprendices')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('etapa_productiva');
    }
};
