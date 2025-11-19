<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('corpo_family_group_members', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->id();
            
            $table->foreignId('family_group_id')->constrained('corpo_family_groups')->onDelete('cascade');
            $table->foreignId('member_id')->constrained('corpo_members')->onDelete('cascade');
            
            // --- EL HISTORIAL ---
            $table->date('start_date');
            $table->date('end_date')->nullable()->comment('NULL = membresía activa');
            
            $table->timestamps();

            // Un miembro no puede tener dos membresías activas al mismo tiempo
            // (Esto es complejo de implementar en DB, lo haremos en la lógica de la app)
        });
    }
    
    public function down(): void {
        Schema::dropIfExists('corpo_family_group_members');
    }
};