<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTolakUndanganReasonToRekruts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('rekruts', function (Blueprint $table) {
            $table->dateTime('rekrut_waktu_tolakundangan')->nullable()->after('rekrut_waktu_konfirmundangan');
            $table->text('rekrut_tolakundangan_reason')->nullable()->after('rekrut_waktu_tolakundangan');
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
            $table->dropColumn('rekrut_tolakundangan_reason');
            $table->dropColumn('rekrut_waktu_tolakundangan');
        });
    }
}
