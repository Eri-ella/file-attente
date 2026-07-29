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
        Schema::create('tickets', function (Blueprint $table) {
            $table->id();
            $table->string('numero', 191)->unique();
            $table->enum('statut', ['en_attente', 'en_cours', 'termine', 'annule'])->default('en_attente');
            $table->foreignId('superclient_id')->nullable()->constrained('superclients');
            $table->foreignId('client_id')->nullable()->constrained('clients');
            $table->foreignId('service_id')->constrained('services');
            $table->timestamps();
        });

        DB::statement('ALTER TABLE tickets ADD CONSTRAINT chk_unique_valeur CHECK (superclient_id IS NULL OR client_id IS NULL)');

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tickets');
    }
};
