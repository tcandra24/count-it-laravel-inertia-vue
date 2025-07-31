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
        Schema::create('budget_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('budget_id');
            $table->string('name', 100);
            $table->double('precentage');
            $table->decimal('nominal', 12, 2);
            $table->timestamps();

            $table->foreign('budget_id')->references('id')->on('budgets')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('budget_details');
    }
};
