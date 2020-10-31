<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddKotaToUnivs extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('univs', function (Blueprint $table) {
            $table->string('city_id', 4)->nullable()->index()->after('profile_pict');
            $table->foreign('city_id')->references('id')->on('cities');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('univs', function (Blueprint $table) {
            $table->dropForeign('univs_city_id_foreign');
            $table->dropColumn('city_id');
        });
    }
}
