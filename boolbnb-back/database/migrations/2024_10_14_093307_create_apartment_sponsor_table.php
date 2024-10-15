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

        Schema::create('apartment_sponsor', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('apartment_id');
            $table->foreign('apartment_id')->references('id')->on('apartments')->cascadeOnDelete();
            $table->unsignedBigInteger('sponsor_id');
            $table->foreign('sponsor_id')->references('id')->on('sponsors')->cascadeOnDelete();
            $table->dateTime('ending_date');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('apartment_sponsor');
    }
};
