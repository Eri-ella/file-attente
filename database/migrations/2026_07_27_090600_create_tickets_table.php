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

            // --- NOUVEAUTÉS intégrées ici ---
            $table->foreignId('reservation_id')->nullable()->constrained('reservations')->onDelete('cascade');
            $table->string('numero', 191)->unique();
            $table->enum('statut', ['en_attente', 'en_file', 'appele', 'en_cours', 'termine', 'annule', 'no_show'])->default('en_attente');
            $table->unsignedInteger('position')->nullable();
            $table->time('heure_estimee')->nullable();
            $table->time('heure_passage')->nullable();
            $table->date('date_file')->nullable();
            // ---------------------------------

            $table->foreignId('superclient_id')->nullable()->constrained('superclients');
            $table->string('client_mail', 191)->nullable();
            $table->foreignId('service_id')->constrained('services');
            $table->timestamps();
        });

        // FK explicite (nécessite que clients.mail soit unique)
        Schema::table('tickets', function (Blueprint $table) {
            $table->foreign('client_mail')->references('mail')->on('clients')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tickets');
    }
};