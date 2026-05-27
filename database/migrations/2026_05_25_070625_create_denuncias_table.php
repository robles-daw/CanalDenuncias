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
        Schema::create('denuncias', function (Blueprint $table) {
            $table->id();
            $table->foreignId('empresa_id')->constrained()->cascadeOnUpdate()->restrictOnDelete();
            $table->foreignId('causa_denuncia_id')->constrained('causa_denuncias')->cascadeOnUpdate()->restrictOnDelete();
            $table->string('codigo_seguimiento', 40)->unique();
            $table->string('estado', 30)->default('pendiente')->index();
            $table->string('gravedad', 20)->default('media')->index();
            $table->longText('descripcion_hechos');
            $table->date('fecha_hechos')->nullable();
            $table->boolean('sigue_ocurriendo')->nullable();
            $table->boolean('riesgo_inmediato')->default(false);
            $table->boolean('anonima')->default(true);
            $table->string('nombre_denunciante')->nullable();
            $table->string('email_denunciante')->nullable();
            $table->string('telefono_denunciante', 30)->nullable();
            $table->boolean('acepta_politica_privacidad');
            $table->boolean('declara_veracidad');
            $table->ipAddress('ip_origen')->nullable();
            $table->text('user_agent')->nullable();
            $table->json('metadatos')->nullable();
            $table->timestamp('fecha_recepcion')->useCurrent();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('denuncias');
    }
};
