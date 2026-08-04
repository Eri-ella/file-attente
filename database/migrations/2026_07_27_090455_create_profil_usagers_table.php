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
        Schema::create('profil_usagers', function (Blueprint $table) {
            $table->id();
            $table->string('nom', 191)->unique(); // ← Changé de enum à string
            $table->string('statut')->default('actif'); // ← string au lieu de enum pour plus de flexibilité
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('profil_usagers');
    }
};