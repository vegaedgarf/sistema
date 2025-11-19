<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('corpo_plan_details', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->id();
            
            // Relación con el Plan (Producto)
            $table->foreignId('plan_id')->constrained('corpo_plans')->onDelete('cascade');
            
            // Relación con la Actividad
            $table->foreignId('activity_id')->constrained('corpo_activities')->onDelete('cascade');
            
            // Frecuencia (nuestro requerimiento)
            $table->tinyInteger('times_per_week')->unsigned()->default(1);
            
            // Clave única para evitar duplicados (ej. Musculación 2x y Musculación 3x en el mismo plan)
            $table->unique(['plan_id', 'activity_id']);
            
            // No usamos timestamps aquí, ya que es una tabla de definición
        });
    }
    
    public function down(): void {
        Schema::dropIfExists('corpo_plan_details');
    }
};
