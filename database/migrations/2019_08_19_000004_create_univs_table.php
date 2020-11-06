<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUnivsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('univs', function (Blueprint $table) {
            $table->bigIncrements('univ_id');
            $table->string('univ_user_email', 50);
            $table->string('univ_nama', 200);
            $table->string('univ_npsn', 50)->unique();
            $table->char('univ_akreditasi', 1)->nullable();
            $table->date('univ_tgl_berdiri')->nullable();
            $table->string('univ_alamat', 200)->nullable();
            $table->string('univ_no_tlp', 15)->nullable();
            $table->string('univ_website', 100)->nullable();
            $table->string('univ_profile_pict', 20)->nullable();
            $table->string('univ_city_id', 4)->nullable();
            $table->timestamps();
            $table->foreign('univ_user_email')->references('user_email')->on('users');
            $table->foreign('univ_city_id')->references('city_id')->on('cities');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('univs');
    }
}
