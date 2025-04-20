<?php
//termekek tabla
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration
{
   public function up()
   {
    DB::statement('CREATE TABLE termekek (
        id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        nev VARCHAR(255) NOT NULL,
        leiras VARCHAR(255) NOT NULL,
        ar DECIMAL(10, 2) NOT NULL,
        kep LONGBLOB,
        keszlet INT DEFAULT 1,
        created_at TIMESTAMP NULL,
        updated_at TIMESTAMP NULL,
        deleted_at TIMESTAMP NULL
    )');
   }
   public function down()
   {
       Schema::dropIfExists('termekek');
   }
};