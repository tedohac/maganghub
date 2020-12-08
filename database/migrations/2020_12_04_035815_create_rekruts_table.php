<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRekrutsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rekruts', function (Blueprint $table) {
            $table->bigIncrements('rekrut_id');
            $table->bigInteger('rekrut_lowongan_id')->unsigned()->index();
            $table->bigInteger('rekrut_mahasiswa_id')->unsigned()->index();
            $table->string('rekrut_status', 10);
            $table->dateTime('rekrut_undangan_waktu')->nullable();
            $table->string('rekrut_undangan_alamat', 300)->nullable();
            $table->text('rekrut_undangan_desc')->nullable();
            $table->integer('rekrut_rating', false)->nullable();
            $table->dateTime('rekrut_waktu_melamar');
            $table->dateTime('rekrut_waktu_diundang')->nullable();
            $table->dateTime('rekrut_waktu_konfirmundangan')->nullable();
            $table->dateTime('rekrut_waktu_diterima')->nullable();
            $table->dateTime('rekrut_waktu_konfirmditerima')->nullable();
            $table->timestamps();
            $table->foreign('rekrut_lowongan_id')->references('lowongan_id')->on('lowongans');
            $table->foreign('rekrut_mahasiswa_id')->references('mahasiswa_id')->on('mahasiswas');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rekruts');
    }
}
