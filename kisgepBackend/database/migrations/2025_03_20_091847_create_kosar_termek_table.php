<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration
{
    public function up()
    {
        Schema::create('kosar_termek', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('kosar_id');
            $table->unsignedBigInteger('termek_id');
            $table->integer('mennyiseg')->default(1);
            $table->date('kezdo_datum');
            $table->date('vegso_datum');
            $table->timestamps();
            $table->foreign('kosar_id')->references('id')->on('kosarak')->onDelete('cascade');
            $table->foreign('termek_id')->references('id')->on('termekek')->onDelete('cascade');
        });
    }
    public function down()
    {
        Schema::dropIfExists('kosar_termek');
    }
}; 