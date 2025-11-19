<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('corpo_plan_prices', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->id();
            
            // Relación con el Plan
            $table->foreignId('plan_id')->constrained('corpo_plans')->onDelete('cascade');
            
            // Datos del Precio
            $table->decimal('price', 10, 2);
            $table->decimal('tax_rate', 5, 2)->default(0.00);
            
            // --- Historial de Precios (Inmutabilidad) ---
            $table->date('valid_from');
            $table->date('valid_to')->nullable(); // NULL significa que es el precio actual
            
            $table->timestamps();
            
            // Índice para buscar el precio de un plan en una fecha determinada
            $table->index(['plan_id', 'valid_from', 'valid_to']);
        });
    }
    
    public function down(): void {
        Schema::dropIfExists('corpo_plan_prices');
    }
};
