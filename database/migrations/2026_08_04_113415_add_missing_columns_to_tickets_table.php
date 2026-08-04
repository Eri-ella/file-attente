<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('tickets', function (Blueprint $table) {
            if (!Schema::hasColumn('tickets', 'reservation_id')) {
                $table->foreignId('reservation_id')->nullable()->after('id')
                    ->constrained('reservations')->onDelete('cascade');
            }

            if (!Schema::hasColumn('tickets', 'numero')) {
                $table->string('numero', 191)->nullable()->after('reservation_id');
            }

            if (!Schema::hasColumn('tickets', 'statut')) {
                $table->enum('statut', ['en_attente', 'en_file', 'appele', 'en_cours', 'termine', 'annule', 'no_show'])
                    ->default('en_attente')->after('numero');
            }

            if (!Schema::hasColumn('tickets', 'position')) {
                $table->unsignedInteger('position')->nullable()->after('statut');
            }

            if (!Schema::hasColumn('tickets', 'heure_estimee')) {
                $table->time('heure_estimee')->nullable()->after('position');
            }

            if (!Schema::hasColumn('tickets', 'heure_passage')) {
                $table->time('heure_passage')->nullable()->after('heure_estimee');
            }

            if (!Schema::hasColumn('tickets', 'date_file')) {
                $table->date('date_file')->nullable()->after('heure_passage');
            }
        });

        // La contrainte unique sur "numero" doit être ajoutée séparément :
        // Schema::table() ne peut pas fiabiliser un ->unique() conditionnel dans le même bloc
        // si des lignes existantes ont déjà numero = NULL en double.
        if (!$this->hasUniqueIndex('tickets', 'numero')) {
            Schema::table('tickets', function (Blueprint $table) {
                $table->unique('numero');
            });
        }
    }

    public function down(): void
    {
        Schema::table('tickets', function (Blueprint $table) {
            if (Schema::hasColumn('tickets', 'reservation_id')) {
                $table->dropForeign(['reservation_id']);
                $table->dropColumn('reservation_id');
            }

            $columns = ['numero', 'statut', 'position', 'heure_estimee', 'heure_passage', 'date_file'];
            foreach ($columns as $column) {
                if (Schema::hasColumn('tickets', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }

    /**
     * Vérifie si un index unique existe déjà sur cette colonne (évite un doublon d'index au rollback/replay).
     */
    private function hasUniqueIndex(string $table, string $column): bool
    {
        $indexes = Schema::getConnection()->getSchemaBuilder()->getIndexes($table);
        foreach ($indexes as $index) {
            if ($index['unique'] && in_array($column, $index['columns'])) {
                return true;
            }
        }
        return false;
    }
};