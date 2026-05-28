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
        Schema::table('empresas', function (Blueprint $table) {
            $table->text('politica_privacidad_url')->nullable()->after('color_inputs');
            $table->text('politica_cookies_url')->nullable()->after('politica_privacidad_url');
            $table->text('aviso_legal_url')->nullable()->after('politica_cookies_url');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('empresas', function (Blueprint $table) {
            $table->dropColumn([
                'politica_privacidad_url',
                'politica_cookies_url',
                'aviso_legal_url',
            ]);
        });
    }
};
