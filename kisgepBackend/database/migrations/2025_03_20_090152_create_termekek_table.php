<?php
//termekek tabla
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration
{
   public function up()
   {
       Schema::create('termekek', function (Blueprint $table) {
           $table->id();
           $table->string('nev');
           $table->decimal('ar', 10, 2); // napi díj
           $table->string('kep');
           $table->unsignedBigInteger('kategoria_id');
           $table->integer('keszlet')->default(1); // rendelkezésre álló darabszám
           $table->integer('nepszeruseg')->default(0); // népszerűség számláló
           $table->timestamps();
           $table->foreign('kategoria_id')->references('id')->on('kategoriak')->onDelete('cascade');
       });
   }
   public function down()
   {
       Schema::dropIfExists('termekek');
   }
};