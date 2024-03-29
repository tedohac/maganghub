<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMahasiswasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mahasiswas', function (Blueprint $table) {
            $table->bigIncrements('mahasiswa_id');
            $table->string('mahasiswa_user_email', 50)->nullable();
            $table->bigInteger('mahasiswa_dospem_id')->unsigned()->index();
            $table->string('mahasiswa_city_id', 4)->nullable();
            $table->string('mahasiswa_nim', 50);
            $table->string('mahasiswa_nama', 200);
            $table->string('mahasiswa_no_tlp', 15)->nullable();
            $table->string('mahasiswa_alamat', 200)->nullable();
            $table->string('mahasiswa_tempat_lahir', 200)->nullable();
            $table->date('mahasiswa_tgl_lahir')->nullable();
            $table->string('mahasiswa_profile_pict', 20)->nullable();
            $table->string('mahasiswa_cv', 20)->nullable();
            $table->string('mahasiswa_khs', 20)->nullable();
            $table->string('mahasiswa_status', 10)->nullable();
            $table->timestamps();
            $table->foreign('mahasiswa_user_email')->references('user_email')->on('users');
            $table->foreign('mahasiswa_dospem_id')->references('dospem_id')->on('dospems');
            $table->foreign('mahasiswa_city_id')->references('city_id')->on('cities');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('mahasiswas');
    }
}
