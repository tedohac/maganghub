<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDospemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dospems', function (Blueprint $table) {
            $table->bigIncrements('dospem_id');
            $table->string('dospem_user_email', 50);
            $table->bigInteger('dospem_prodi_id')->unsigned()->index();
            $table->string('nik', 50);
            $table->string('nama', 200);
            $table->timestamps();
            $table->foreign('dospem_user_email')->references('user_email')->on('users');
            $table->foreign('dospem_prodi_id')->references('prodi_id')->on('prodis');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('dospems');
    }
}
