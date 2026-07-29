<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use PharIo\Manifest\Email;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('clients', function (Blueprint $table) {
            // Force la colonne mail en texte de taille 191 et crée l'index unique indispensable
            $table->string('mail', 191)->unique();
            
            // Vos autres colonnes existantes (nom, prenom...)
            // ...
            $table->timestamps();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clients');
    }
};
