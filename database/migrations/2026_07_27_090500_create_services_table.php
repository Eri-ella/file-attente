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
        Schema::create('services', function (Blueprint $table) {
            $table->id();
            $table->string('nom');
            $table->enum('categorie', ['État Civil & Citoyenneté', 'Foncier & Urbanisme', 'Économie & Commerce']);
            $table->enum('profil_usager', ['Particuliers', 'Entreprises']);
            $table->enum('criter_technique', ['Gratuit', 'Payant']);
            $table->time('duree');
            $table->integer('cout');
            $table->foreignId('mairie_id')->constrained('mairies')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('service');
    }
};
