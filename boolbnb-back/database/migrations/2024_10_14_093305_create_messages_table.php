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


        Schema::create('messages', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('apartment_id');
            //Ricordarsi di aggiungere nel momento del delete che perderemo tutti i messaggi correlati all'appartamento
            $table->foreign('apartment_id')->references('id')->on('apartments')->cascadeOnDelete();
            $table->string('name');
            $table->string('email');
            $table->text('message');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('messages');
    }
};
