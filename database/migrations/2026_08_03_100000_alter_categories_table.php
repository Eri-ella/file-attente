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
        if (Schema::hasTable('categories')) {
            DB::statement("ALTER TABLE categories MODIFY nom VARCHAR(255) NOT NULL UNIQUE, MODIFY statut ENUM('actif','inactif') NOT NULL DEFAULT 'actif';");
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('categories')) {
            DB::statement("ALTER TABLE categories MODIFY nom ENUM('Foncier & Urbanisme','Économie & Commerce','État Civil & Citoyenneté') NOT NULL UNIQUE, MODIFY statut ENUM('actif','inactif') NOT NULL;");
        }
    }
};
