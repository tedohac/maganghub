<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRating2FromRekruts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('rekruts', function (Blueprint $table) {
            $table->dateTime('rekrut_finish')->nullable()->after('rekrut_waktu_konfirmditerima');
            $table->integer('rekrut_ratingto_mahasiswa', false)->nullable()->after('rekrut_finish');
            $table->integer('rekrut_ratingto_perusahaan', false)->nullable()->after('rekrut_ratingto_mahasiswa');
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
            $table->dropColumn('rekrut_finish');
            $table->dropColumn('rekrut_ratingto_mahasiswa');
            $table->dropColumn('rekrut_ratingto_perusahaan');
        });
    }
}
