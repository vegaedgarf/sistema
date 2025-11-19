<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('corpo_memberships', function (Blueprint $table) {
            $table->id();
            
            // Relaciones
            $table->foreignId('member_id')->constrained('corpo_members')->onDelete('cascade');
            $table->foreignId('plan_id')->constrained('corpo_plans')->onDelete('restrict'); // No borrar plan si tiene inscripciones
            
            // Fechas del ciclo
            $table->date('start_date');
            $table->date('end_date'); // Vencimiento
            
            // Datos Económicos (Snapshot)
            // Guardamos el precio y descuento AQUI por si cambian en el futuro
            $table->decimal('plan_price_at_purchase', 10, 2)->comment('Precio base del plan al momento de inscribir');
            $table->decimal('discount_applied', 10, 2)->default(0)->comment('Monto descontado (ej. por grupo familiar)');
            $table->decimal('final_price', 10, 2)->comment('Lo que debe pagar el cliente');
            
            // Estado
            $table->enum('status', ['pending', 'active', 'expired', 'cancelled'])->default('pending');
            
            // Auditoría
            $table->foreignId('created_by')->nullable()->constrained('users');
            $table->foreignId('updated_by')->nullable()->constrained('users');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('corpo_memberships');
    }
};