<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration
{
   public function up()
   {
       Schema::create('kategoriak', function (Blueprint $table) {
           $table->id();
           $table->string('nev');
           $table->text('leiras')->nullable();
           $table->string('kep')->nullable();
           $table->timestamps();
       });
   }
   public function down()
   {
       Schema::dropIfExists('kategoriak');
   }
};
