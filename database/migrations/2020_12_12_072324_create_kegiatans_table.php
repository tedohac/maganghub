<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKegiatansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kegiatans', function (Blueprint $table) {
            $table->bigIncrements('kegiatan_id');
            $table->bigInteger('kegiatan_rekrut_id')->unsigned()->index();
            $table->date('kegiatan_tgl');
            $table->text('kegiatan_desc');
            $table->string('kegiatan_path', 20);
            $table->dateTime('kegiatan_verify_mentor')->nullable();
            $table->foreign('kegiatan_rekrut_id')->references('rekrut_id')->on('rekruts');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('kegiatans');
    }
}
