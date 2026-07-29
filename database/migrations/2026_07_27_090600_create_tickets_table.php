<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('tickets', function (Blueprint $table) {
            $table->id();
            $table->string('numero', 191)->unique();
            $table->enum('statut', ['en_attente', 'en_cours', 'termine', 'annule'])->default('en_attente');
            $table->foreignId('superclient_id')->nullable()->constrained('superclients');
            
            // Force exactement la même taille (191) et autorise le NULL
            $table->string('client_mail', 191)->nullable();
            
            $table->foreignId('service_id')->constrained('services');
            $table->timestamps();
        });

        // Écrit explicitement la clé étrangère en dehors pour éviter les conflits de création d'index concurrents
        Schema::table('tickets', function (Blueprint $table) {
            $table->foreign('client_mail')->references('mail')->on('clients')->onDelete('cascade');
        });

        // Votre contrainte d'exclusion intelligente
        DB::statement('ALTER TABLE tickets ADD CONSTRAINT chk_unique_valeur CHECK (superclient_id IS NULL OR client_mail IS NULL)');
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tickets');
    }
};

