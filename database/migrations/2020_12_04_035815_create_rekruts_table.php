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
            $table->date('rekrut_tgl_melamar');
            $table->integer('rekrut_rating', false)->nullable();
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
