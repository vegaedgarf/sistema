<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('corpo_routine_day_exercises', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->id();
            $table->unsignedBigInteger('routine_day_id');
            $table->foreign('routine_day_id')->references('id')->on('corpo_routine_days')->onDelete('cascade');
            $table->unsignedBigInteger('exercise_id');
            $table->foreign('exercise_id')->references('id')->on('corpo_exercises')->onDelete('cascade');
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
        Schema::dropIfExists('corpo_routine_day_exercises');
    }
};
