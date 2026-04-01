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
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('logo')->nullable();
            $table->string('name')->nullable();
            $table->string('slogan')->nullable();

            // Stockage JSON pour la flexibilité
            $table->json('phones')->nullable(); // Ex: ["+237...", "+237..."]
            $table->json('socials')->nullable(); // Ex: {"facebook": "url", "twitter": "url"}

            $table->string('email')->nullable();
            $table->string('adresse')->nullable();
            $table->string('bp')->nullable();
            $table->string('horaire')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};
