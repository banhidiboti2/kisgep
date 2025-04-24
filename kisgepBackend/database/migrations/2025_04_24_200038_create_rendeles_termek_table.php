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
        Schema::create('rendeles_termek', function (Blueprint $table) {
            $table->id();
            $table->foreignId('rendeles_id')->constrained('rendeles');
            $table->foreignId('termek_id')->constrained('termekek');
            $table->integer('mennyiseg');
            $table->date('kezdo_datum');
            $table->date('vegso_datum');
            $table->decimal('ar', 10, 2);
            $table->string('rendeles_azonosito');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rendeles_termek');
    }
};
