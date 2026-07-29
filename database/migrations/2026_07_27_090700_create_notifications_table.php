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
        Schema::create('notifications', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->time('heure');
            $table->string('client_mail', 191)->nullable(); 
            $table->foreignId('superclient_id')->nullable()->constrain('superclients')->onDelete('cascade');

            $table->timestamps();
        });

        
        Schema::table('notifications', function (Blueprint $table) {
            $table->foreign('client_mail')->references('mail')->on('clients')->onDelete('cascade');
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notifications');
    }
};
