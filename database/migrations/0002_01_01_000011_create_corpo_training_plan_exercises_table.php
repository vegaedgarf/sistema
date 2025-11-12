<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('corpo_training_plan_exercises', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->id();
            $table->unsignedBigInteger('training_plan_id');
            $table->foreign('training_plan_id')->references('id')->on('corpo_training_plans')->onDelete('cascade');
            $table->unsignedBigInteger('exercise_id')->nullable();
            $table->foreign('exercise_id')->references('id')->on('corpo_exercises')->onDelete('set null');
            $table->integer('day')->nullable();
            $table->string('exercise_name')->nullable();
            $table->integer('series')->nullable();
            $table->integer('repetitions')->nullable();
            $table->decimal('weight',6,2)->nullable();
            $table->integer('rest_seconds')->nullable();
            $table->text('notes')->nullable();
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
        Schema::dropIfExists('corpo_training_plan_exercises');
    }
};
