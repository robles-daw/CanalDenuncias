<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (! Schema::hasColumn('empresas', 'email')) {
            Schema::table('empresas', function (Blueprint $table) {
                $table->string('email')->nullable()->after('nombre');
            });
        }

        if (! Schema::hasColumn('empresas', 'logo')) {
            Schema::table('empresas', function (Blueprint $table) {
                $table->string('logo')->nullable()->after('dominio');
            });
        }

        if (! Schema::hasColumn('empresas', 'pdf_normativa')) {
            Schema::table('empresas', function (Blueprint $table) {
                $table->string('pdf_normativa')->nullable()->after('logo');
            });
        }

        if (Schema::hasColumn('empresas', 'pdf')) {
            DB::statement('UPDATE empresas SET pdf_normativa = pdf WHERE pdf_normativa IS NULL AND pdf IS NOT NULL');
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasColumn('empresas', 'pdf_normativa')) {
            Schema::table('empresas', function (Blueprint $table) {
                $table->dropColumn('pdf_normativa');
            });
        }

        if (Schema::hasColumn('empresas', 'email')) {
            Schema::table('empresas', function (Blueprint $table) {
                $table->dropColumn('email');
            });
        }

        if (Schema::hasColumn('empresas', 'logo')) {
            Schema::table('empresas', function (Blueprint $table) {
                $table->dropColumn('logo');
            });
        }
    }
};
