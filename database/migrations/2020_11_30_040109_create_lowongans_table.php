<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLowongansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lowongans', function (Blueprint $table) {
            $table->bigIncrements('lowongan_id');
            $table->bigInteger('lowongan_perusahaan_id')->unsigned()->index();
            $table->string('lowongan_status', 10);
            $table->string('lowongan_city_id', 4);
            $table->string('lowongan_judul', 200);
            $table->date('lowongan_tgl_mulai');
            $table->string('lowongan_durasi', 50);
            $table->text('lowongan_requirement');
            $table->text('lowongan_jobdesk');
            $table->integer('lowongan_jlh_dibutuhkan', false);
            $table->timestamps();
            $table->foreign('lowongan_perusahaan_id')->references('perusahaan_id')->on('perusahaans');
            $table->foreign('lowongan_city_id')->references('city_id')->on('cities');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('lowongans');
    }
}
