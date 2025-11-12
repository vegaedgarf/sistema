<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('corpo_membership_combinations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('membership_price_id')->constrained('corpo_membership_prices')->onDelete('cascade');
            $table->foreignId('activity_id')->constrained('corpo_activities')->onDelete('cascade');
            $table->integer('times_per_week')->default(1);
            $table->timestamps();
        });
    }




    public function down(): void
    {
        Schema::dropIfExists('corpo_membership_combinations');
    }







};
