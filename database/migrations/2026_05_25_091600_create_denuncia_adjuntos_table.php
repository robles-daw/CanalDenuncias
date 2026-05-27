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
        Schema::create('denuncia_adjuntos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('denuncia_id')->constrained()->cascadeOnUpdate()->cascadeOnDelete();
            $table->string('nombre_original');
            $table->string('ruta_archivo');
            $table->string('mime_type', 120)->nullable();
            $table->unsignedBigInteger('tamano_bytes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('denuncia_adjuntos');
    }
};
