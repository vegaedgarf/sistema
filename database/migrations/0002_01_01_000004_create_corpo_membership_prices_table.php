<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('corpo_membership_prices', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->id();

            // Relación con actividad
            $table->unsignedBigInteger('activity_id')->nullable();
            $table->foreign('activity_id')->references('id')->on('corpo_activities')->onDelete('set null');

            // Nombre o tipo de plan (por ejemplo: 1x/semana, 2x/semana, ilimitado, etc.)
            $table->string('plan_type')->nullable();

            // Precio y vigencia
            $table->decimal('price', 10, 2);
            $table->date('valid_from');
            $table->date('valid_to')->nullable();

            // Estado (opcional, útil si querés inactivar un plan sin borrarlo)
            $table->boolean('active')->default(true);
            $table->unique(['activity_id', 'valid_from']);


            $table->timestamps();
            $table->softDeletes();


            // Auditoría
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->foreign('created_by')->references('id')->on('users')->onDelete('set null')->onUpdate('cascade');
            $table->foreign('updated_by')->references('id')->on('users')->onDelete('set null')->onUpdate('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('corpo_membership_prices');
    }
};
