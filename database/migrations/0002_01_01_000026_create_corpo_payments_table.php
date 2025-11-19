<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('corpo_payments', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->id();
            
            // --- Relaciones Principales ---
            $table->foreignId('member_id')->constrained('corpo_members')->onDelete('cascade');
            $table->foreignId('membership_id')->constrained('corpo_memberships')->onDelete('cascade');
            
            // (NUEVO Y CRÍTICO) "Snapshot" del precio usado en esta factura.
            // Mantiene el historial aunque el precio del plan cambie en el futuro.
            $table->foreignId('plan_price_id')->nullable()->constrained('corpo_plan_prices')->onDelete('set null');

            // --- Desglose Financiero (Inmutabilidad) ---
            
            // (CAMBIO) 'amount' ahora es 'amount_due' (Precio base del plan)
            $table->decimal('amount_due', 10, 2);
            
            // (NUEVO) Descuentos por familia, bonificaciones, etc.
            $table->decimal('discount_amount', 10, 2)->default(0.00);
            
            // (NUEVO) Recargos o intereses por mora
            $table->decimal('late_fee', 10, 2)->default(0.00);

            // (NUEVO) Campo calculado para el total final (depende de tu versión de MySQL/MariaDB)
            // Si usas una versión antigua, este campo debe ser calculado en la lógica de la app.
            // $table->decimal('total_amount', 10, 2)->storedAs('amount_due - discount_amount + late_fee');
            // O, si no usamos storedAs:
            $table->decimal('total_amount', 10, 2); // Este se calculará (due - discount + late_fee) y guardará por la app.


            // --- Período y Vencimientos ---
            $table->date('billing_period_start');
            $table->date('billing_period_end');
            $table->date('due_date')->index()->comment('Fecha de vencimiento');
            
            // (CAMBIO) 'payment_date' es DateTime y nullable (null hasta que se pague)
            $table->dateTime('payment_date')->nullable()->index();

            // (CAMBIO) Estados de la factura
            $table->enum('status', ['pending', 'paid', 'overdue', 'failed', 'cancelled'])->default('pending');
            
            $table->string('payment_method')->nullable();
            $table->text('notes')->nullable();
            
            // --- Tiempos y Auditoría ---
            $table->timestamps();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            
            $table->foreign('created_by')->references('id')->on('users')->onDelete('set null')->onUpdate('cascade');
            $table->foreign('updated_by')->references('id')->on('users')->onDelete('set null')->onUpdate('cascade');
            
            $table->softDeletes();
            
            // Índice clave para buscar morosos
            $table->index(['status', 'due_date']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('corpo_payments');
    }
};