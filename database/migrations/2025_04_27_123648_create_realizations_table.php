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
        Schema::create('realizations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('plan_detail_id');
            $table->decimal('qty')->default(0);
            $table->decimal('price');
            $table->decimal('total');
            $table->string('image');
            $table->timestamps();

            $table->foreign('plan_detail_id')->references('id')->on('plan_details');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('realizations');
    }
};
