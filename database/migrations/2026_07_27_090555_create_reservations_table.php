<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('reservations', function (Blueprint $table) {
            $table->id();
            
            // Clés étrangères
            $table->foreignId('service_id')->constrained('services')->onDelete('cascade');
            $table->foreignId('superclient_id')->nullable()->constrained('superclients')->onDelete('set null');
            
            // Infos du client (invité)
            $table->string('client_mail', 191)->nullable();
            
            // Infos de réservation
            $table->date('date')->nullable();
            $table->time('heure_souhaite')->nullable();
            $table->integer('nombre_tickets')->default(1);
            $table->text('commentaire')->nullable();
            $table->enum('statut', ['en_attente', 'confirmée', 'annulée'])->default('en_attente');
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reservations');
    }
};