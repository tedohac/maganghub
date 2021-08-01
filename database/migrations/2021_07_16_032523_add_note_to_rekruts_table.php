<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNoteToRekrutsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('rekruts', function (Blueprint $table) {
            $table->string('rekrut_note', 200)->nullable()->after('rekrut_waktu_diterima');
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
            $table->dropColumn('rekrut_note');
        });
    }
}
