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
        Schema::create('instructor_historials', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('aprendiz_id');
            $table->unsignedBigInteger('instructor_seguimiento_id');
            $table->date('fecha_asignacion');
            

            $table->foreign('aprendiz_id')->references('id')->on('aprendices')->onDelete('cascade');
            $table->foreign('instructor_seguimiento_id')->references('id')->on('instructores_seguimiento')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('instructor_historials');
    }
};
