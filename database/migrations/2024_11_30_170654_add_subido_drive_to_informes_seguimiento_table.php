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
        Schema::table('informes_seguimiento', function (Blueprint $table) {
            $table->boolean('subido_drive')->default(false)->after('observaciones');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('informes_seguimiento', function (Blueprint $table) {
            $table->dropColumn('subido_drive');
        });
    }
};
