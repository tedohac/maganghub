<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProdisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('prodis', function (Blueprint $table) {
            $table->bigIncrements('prodi_id');
            $table->BigInteger('prodi_univ_id')->unsigned()->index();
            $table->string('prodi_nama', 100);
            $table->string('prodi_fakultas', 100)->nullable();
            $table->string('prodi_jenjang', 5);
            $table->char('prodi_akreditasi', 1);
            $table->timestamps();
            $table->foreign('prodi_univ_id')->references('univ_id')->on('univs');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('prodis');
    }
}
