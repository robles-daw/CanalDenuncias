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
            $table->string('password')->nullable()->after('email');
            $table->string('color_principal', 20)->default('#b24a1b')->after('pdf_normativa');
            $table->string('color_secundario', 20)->nullable()->after('color_principal');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('empresas', function (Blueprint $table) {
            $table->dropColumn([
                'password',
                'color_principal',
                'color_secundario',
            ]);
        });
    }
};
