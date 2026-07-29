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
        Schema::create('notifications', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->time('heure');
            $table->foreignId('client_id')->nullable()->constrained('clients');
            $table->foreignId('superclient_id')->nullable()->constrained('superclients');
            $table->timestamps();
        });

        DB::statement('ALTER TABLE notifications ADD CONSTRAINT chk_unique_destination CHECK (superclient_id IS NULL OR client_id IS NULL)');

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notifications');
    }
};
