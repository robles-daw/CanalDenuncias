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
        Schema::table('denuncias', function (Blueprint $table) {
            $table->index(['empresa_id', 'codigo_seguimiento'], 'denuncias_empresa_codigo_index');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('denuncias', function (Blueprint $table) {
            $table->dropIndex('denuncias_empresa_codigo_index');
        });
    }
};
