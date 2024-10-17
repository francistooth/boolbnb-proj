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

        Schema::create('apartments', function (Blueprint $table) {
            $table->id();
            $table->string('title', 100);
            $table->string('slug', 150)->unique();
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');
            $table->text('description');
            $table->unsignedTinyInteger('room')->default(1);
            $table->unsignedTinyInteger('bed')->default(1);
            $table->unsignedTinyInteger('bathroom');
            $table->unsignedSmallInteger('sqm')->default(10);
            $table->string('address');
            $table->string('coordinate');
            $table->string('img_path')->nullable();
            $table->string('img_name')->nullable();
            $table->boolean('is_visible');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('apartments');
    }
};
