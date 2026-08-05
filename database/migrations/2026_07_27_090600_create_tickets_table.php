<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tickets', function (Blueprint $table) {
            $table->id();
            
            $table->foreignId('reservation_id')->constrained('reservations')->onDelete('cascade');
            
            // Numéro sans contrainte unique seule
            $table->string('numero', 191);
            
            $table->enum('statut', [
                'en_attente', 'en_file', 'appele', 'en_cours',
                'termine', 'annule', 'no_show', 'retard_decale'
            ])->default('en_attente');
            
            $table->unsignedInteger('position')->nullable();
            $table->unsignedInteger('nombre_retards')->default(0);
            $table->time('heure_estimee')->nullable();
            $table->time('heure_passage')->nullable();
            $table->date('date_file')->nullable();
            
            $table->timestamps();

            // Contrainte unique sur (numero, date_file) pour permettre réutilisation journalière
            $table->unique(['numero', 'date_file']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tickets');
    }
};