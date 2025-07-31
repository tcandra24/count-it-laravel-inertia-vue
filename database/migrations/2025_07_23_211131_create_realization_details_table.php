<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('realization_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('realization_id');
            $table->unsignedBigInteger('plan_detail_id')->nullable();
            $table->unsignedBigInteger('unit_id');
            $table->unsignedBigInteger('budget_detail_id');
            $table->decimal('qty', 12, 2)->default(0);
            $table->decimal('price');
            $table->decimal('total');
            $table->text('note')->nullable();
            $table->timestamps();

            $table->foreign('realization_id')->references('id')->on('realizations')->onDelete('cascade');
            $table->foreign('plan_detail_id')->references('id')->on('plan_details');
            $table->foreign('budget_detail_id')->references('id')->on('budget_details');
            $table->foreign('unit_id')->references('id')->on('units');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('realization_details');
    }
};
