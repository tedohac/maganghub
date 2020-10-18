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
            $table->id();
            $table->string('email', 50);
            $table->string('nama', 100);
            $table->string('no_skpt', 50)->unique();
            $table->date('tgl_skpt')->nullable();
            $table->char('akreditasi', 1)->nullable();
            $table->date('tgl_berdiri')->nullable();
            $table->string('alamat', 200)->nullable();
            $table->string('no_tlp', 15)->nullable();
            $table->timestamps();
            $table->foreign('email')->references('email')->on('users');
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
