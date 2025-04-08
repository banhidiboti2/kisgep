<?php
// rendeles_termek tábla migrációja
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration
{
   public function up()
   {
       Schema::create('rendeles_termek', function (Blueprint $table) {
           $table->id();
           $table->unsignedBigInteger('rendeles_id');
           $table->unsignedBigInteger('termek_id');
           $table->integer('mennyiseg');
           $table->date('kezdo_datum');
           $table->date('vegso_datum');
           $table->decimal('ar', 10, 2); 
           $table->timestamps();
           $table->foreign('rendeles_id')->references('id')->on('rendelesek')->onDelete('cascade');
           $table->foreign('termek_id')->references('id')->on('termekek')->onDelete('cascade');
       });
   }
   public function down()
   {
       Schema::dropIfExists('rendeles_termek');
   }
};
