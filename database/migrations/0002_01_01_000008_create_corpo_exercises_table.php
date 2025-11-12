<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('corpo_exercises', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->id();
            $table->unsignedBigInteger('muscle_group_id')->nullable();
            $table->foreign('muscle_group_id')->references('id')->on('corpo_muscle_groups')->onDelete('set null');
            $table->unsignedBigInteger('exercise_category_id')->nullable();
            $table->foreign('exercise_category_id')->references('id')->on('corpo_exercise_categories')->onDelete('set null');
            $table->string('name');
            $table->text('description')->nullable();
            $table->string('video_url')->nullable();
            $table->string('video_file')->nullable();
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
        Schema::dropIfExists('corpo_exercises');
    }
};
