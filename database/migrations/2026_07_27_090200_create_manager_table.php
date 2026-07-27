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
        Schema::create('manager', function (Blueprint $table) {
             $table->id();
            $table->string('nom');
            $table->string('prenom');
            $table->string('age')->nullable();
            $table->string('date_de_naissance');
            $table->string('sex');
            $table->string('email')->unique();
            $table->string('mot_de_passe');
            $table->string('numero')->nullable();

            $table->foreignId('mairie_id')->constrained('mairie')->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('manager');
    }
};
