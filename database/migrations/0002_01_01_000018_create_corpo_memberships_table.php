<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('corpo_memberships', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->id();

            // --- Relaciones principales (Foreign Keys) ---
            
            // Relación con el miembro (CorpoMember)
            $table->unsignedBigInteger('member_id');
            $table->foreign('member_id')->references('id')->on('corpo_members')->onDelete('cascade'); 
            
            // Relación con el precio o plan (MembershipPrice)
            // Asumo que esta tabla ya existe o la estás creando en otra migración.
            $table->unsignedBigInteger('membership_price_id')->nullable();
            $table->foreign('membership_price_id')->references('id')->on('corpo_membership_prices')->onDelete('set null');

            // --- Datos de la Membresía ---
            $table->date('start_date');
            $table->date('end_date');
            $table->string('status')->default('active')->comment('e.g., active, expired, pending');
            $table->decimal('total_amount', 10, 2);
            $table->string('payment_method')->nullable();
            $table->text('notes')->nullable();

            // --- Tiempos y Auditoría ---
            $table->timestamps();
            $table->softDeletes();
            
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();

            $table->foreign('created_by')->references('id')->on('users')->onDelete('set null')->onUpdate('cascade');
            $table->foreign('updated_by')->references('id')->on('users')->onDelete('set null')->onUpdate('cascade');

            // --- Índice Único (Opcional, pero recomendado) ---
            // Puedes añadir una restricción para que un miembro no tenga dos membresías que empiecen el mismo día.
            $table->unique(['member_id', 'start_date']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('corpo_memberships');
    }
};
