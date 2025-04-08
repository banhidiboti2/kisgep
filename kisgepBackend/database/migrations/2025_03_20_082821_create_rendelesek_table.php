<?php

// rendelesek tábla migrációja
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration
{
   public function up()
   {
       Schema::create('rendelesek', function (Blueprint $table) {
           $table->id();
           $table->unsignedBigInteger('user_id');
           $table->decimal('teljes_osszeg', 10, 2);
           $table->enum('statusz', ['feldolgozas_alatt', 'visszaigazolva', 'kiadva', 'visszahozva', 'lezarva']);
           $table->text('megjegyzes')->nullable();
           $table->timestamps();
           $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
       });
   }
   public function down()
   {
       Schema::dropIfExists('rendelesek');
   }
};