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
        Schema::create('programa_formacion', function (Blueprint $table) {
            $table->id();
            $table->string('nombre_programa');
            $table->string('ficha');
            $table->string('nivel_formacion')->nullable();
            $table->string('modalidad')->nullable();
            $table->string('estado_formacion')->nullable();
            $table->string('municipio_ficha')->nullable();
            $table->string('lider_programa')->nullable();
            $table->date('fecha_final')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('programa_formacion');
    }
};
