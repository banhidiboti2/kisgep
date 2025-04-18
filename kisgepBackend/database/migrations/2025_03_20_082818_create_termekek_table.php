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
           $table->string('leiras');
           $table->decimal('ar', 10, 2); // napi díj
           $table->string('kep');
           $table->integer('keszlet')->default(1); // rendelkezésre álló darabszám
           $table->timestamps();
           $table->softDeletes();
       });
   }
   public function down()
   {
       Schema::dropIfExists('termekek');
   }
};