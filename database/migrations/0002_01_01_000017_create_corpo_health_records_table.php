<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Mantiene el nombre de tabla 'corpo_health_records' y la sintaxis de llaves foráneas probada.
     */
    public function up(): void
    {
        Schema::create('corpo_health_records', function (Blueprint $table) {
            $table->id();

            // === RELACIÓN CON MIEMBROS (Sintaxis antigua que funciona) ===
            $table->unsignedBigInteger('member_id');
            // Referencia a 'corpo_members' (Nombre de tabla verificado)
            $table->foreign('member_id')->references('id')->on('corpo_members')->onDelete('cascade'); 
            
            // === NUEVOS CAMPOS MÉDICOS (Estructura mejorada) ===
            $table->string('blood_type', 10)->nullable();
            $table->decimal('height', 5, 2)->nullable();
            $table->decimal('weight', 5, 2)->nullable();
            $table->text('allergies')->nullable();
            $table->text('injuries')->nullable();
            
            // === CAMPOS DE TEXTO ===
            $table->text('medical_conditions')->nullable();
            $table->text('medications')->nullable();
            $table->text('observations')->nullable();
            
            // === AUDITORÍA Y CONTROL DE TIEMPO (Sintaxis antigua que funciona) ===
            $table->timestamps(); 
            $table->softDeletes(); 

            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();

            // Referencia a 'users' (Sintaxis verificada)
            $table->foreign('created_by')->references('id')->on('users')->onDelete('set null')->onUpdate('cascade');
            $table->foreign('updated_by')->references('id')->on('users')->onDelete('set null')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('corpo_health_records');
    }
};