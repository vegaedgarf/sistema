<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('corpo_financial_reports', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->id();
            $table->string('year_month')->index();
            $table->integer('total_memberships_paid')->default(0);
            $table->integer('total_memberships_pending')->default(0);
            $table->decimal('total_income',15,2)->default(0);
            $table->boolean('auto_generated')->default(false);
            $table->json('income_by_activity')->nullable();
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
        Schema::dropIfExists('corpo_financial_reports');
    }
};
