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
        Schema::create('reservations', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->time('heure_souhaite');
            $table->foreignId('superclient_id')->nullable()->constrained('superclients')->onDelete('cascade');
            $table->string('client_mail', 191)->nullable();
            
            $table->timestamps();
        });

        
        Schema::table('reservations', function (Blueprint $table) {
            $table->foreign('client_mail')->references('mail')->on('clients')->onDelete('cascade');
        });

        DB::statement('ALTER TABLE reservations ADD CONSTRAINT chk_reservation_valeur CHECK (superclient_id IS NULL OR client_mail IS NULL)');
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reservations');
    }
};
