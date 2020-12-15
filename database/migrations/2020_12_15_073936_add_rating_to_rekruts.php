<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRatingToRekruts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('rekruts', function (Blueprint $table) {
            $table->dateTime('rekrut_finish_mahasiswa')->nullable()->after('rekrut_waktu_konfirmditerima');
            $table->integer('rekrut_rating_mahasiswa', false)->nullable()->after('rekrut_finish_mahasiswa');
            $table->dateTime('rekrut_finish_perusahaan')->nullable()->after('rekrut_rating_mahasiswa');
            $table->integer('rekrut_rating_perusahaan', false)->nullable()->after('rekrut_finish_perusahaan');
            $table->text('rekrut_feedback')->nullable()->after('rekrut_rating_perusahaan');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('rekruts', function (Blueprint $table) {
            $table->dropColumn('rekrut_finish_mahasiswa');
            $table->dropColumn('rekrut_rating_mahasiswa');
            $table->dropColumn('rekrut_finish_perusahaan');
            $table->dropColumn('rekrut_rating_perusahaan');
        });
    }
}
