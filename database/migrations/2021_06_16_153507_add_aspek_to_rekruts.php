<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAspekToRekruts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('rekruts', function (Blueprint $table) {
            $table->integer('rekrut_aspek_kedisiplinan', false)->nullable()->after('rekrut_rating');
            $table->integer('rekrut_aspek_keterampilan', false)->nullable()->after('rekrut_aspek_kedisiplinan');
            $table->integer('rekrut_aspek_sikap', false)->nullable()->after('rekrut_aspek_keterampilan');
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
            $table->dropColumn('rekrut_aspek_kedisiplinan');
            $table->dropColumn('rekrut_aspek_keterampilan');
            $table->dropColumn('rekrut_aspek_sikap');
        });
    }
}
