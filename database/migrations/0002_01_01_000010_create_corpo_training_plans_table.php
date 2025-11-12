<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('corpo_training_plans', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->id();
            $table->unsignedBigInteger('member_id')->nullable();
            $table->foreign('member_id')->references('id')->on('corpo_members')->onDelete('set null');
            $table->unsignedBigInteger('trainer_id')->nullable();
            $table->foreign('trainer_id')->references('id')->on('users')->onDelete('set null');
            $table->string('name');
            $table->enum('user_type',['ninos','adolescentes','adultos','mayores'])->nullable();
            $table->string('goal')->nullable();
            $table->text('notes')->nullable();
            $table->boolean('is_template')->default(false);
            $table->boolean('active')->default(true);
            $table->timestamps();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->foreign('created_by')->references('id')->on('users')->onDelete('set null')->onUpdate('cascade');
            $table->foreign('updated_by')->references('id')->on('users')->onDelete('set null')->onUpdate('cascade');
            $table->softDeletes();

        });
    }

    public function down(): void
    {
        Schema::dropIfExists('corpo_training_plans');
    }
};
