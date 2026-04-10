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
        Schema::create('incidencias', function (Blueprint $table) {
        $table->id();
        
            // Llaves foráneas (Asegúrate que estas tablas ya existan)
            $table->foreignId('sistema_id')->constrained('sistemas')->onDelete('cascade');
            $table->foreignId('tipo_incidencia_id')->constrained('tipo_incidencias')->onDelete('cascade');
            $table->foreignId('area_id')->constrained('areas')->onDelete('cascade');
            
            $table->text('descripcion');
            $table->string('evidencia')->nullable(); 
            $table->text('observaciones')->nullable();
            
            // Esto creará fecha y hora automáticamente
            $table->timestamps(); 
       });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('incidencias');
    }
};
