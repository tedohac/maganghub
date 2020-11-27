<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePerusahaansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('perusahaans', function (Blueprint $table) {
            $table->bigIncrements('perusahaan_id');
            $table->string('perusahaan_user_email', 50);
            $table->bigInteger('perusahaan_industri_id')->nullable()->unsigned()->index();
            $table->string('perusahaan_city_id', 4)->nullable();
            $table->string('perusahaan_nib', 50)->unique();
            $table->string('perusahaan_nama', 200);
            $table->string('perusahaan_alamat', 300)->nullable();
            $table->string('perusahaan_profile_pict', 20)->nullable();
            $table->string('perusahaan_nib_path', 20)->nullable();
            $table->integer('perusahaan_jlh_karyawan', false)->nullable();
            $table->string('perusahaan_no_tlp', 15)->nullable();
            $table->string('perusahaan_website', 100)->nullable();
            $table->timestamps();
            $table->foreign('perusahaan_user_email')->references('user_email')->on('users');
            $table->foreign('perusahaan_industri_id')->references('industri_id')->on('industris');
            $table->foreign('perusahaan_city_id')->references('city_id')->on('cities');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('perusahaans');
    }
}
