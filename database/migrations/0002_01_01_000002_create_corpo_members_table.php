<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('corpo_members', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->id();
            
            // ✅ Campos de datos en inglés
            $table->string('first_name');
            $table->string('last_name');
            $table->string('dni')->unique();
            
            // ✅ CORRECCIÓN: fecha_nacimiento -> birth_date
            $table->date('birth_date')->nullable(); 
            
            // ✅ CORRECCIÓN: direccion -> address, telefono -> phone
            $table->string('address')->nullable(); 
            $table->string('phone')->nullable(); 
            
            $table->string('email')->nullable();
            
            // ✅ Campo de Observaciones añadido (text para notas largas)
            $table->text('observations')->nullable(); 
            
            $table->enum('status',['activo','inactivo','suspendido'])->default('activo');
            
            // ✅ Campos de fechas en inglés
            $table->date('joined_at')->nullable();
            $table->date('membership_expires_at')->nullable();
            
            // Relaciones de trazabilidad (Audit fields)
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
            
            $table->timestamps();
            
            // Trazabilidad de creación/actualización
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->foreign('created_by')->references('id')->on('users')->onDelete('set null')->onUpdate('cascade');
            $table->foreign('updated_by')->references('id')->on('users')->onDelete('set null')->onUpdate('cascade');
            
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('corpo_members');
    }
};
