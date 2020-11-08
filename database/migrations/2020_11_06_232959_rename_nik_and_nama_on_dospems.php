<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RenameNikAndNamaOnDospems extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('dospems', function (Blueprint $table) {
            $table->renameColumn('nik', 'dospem_nik');
            $table->renameColumn('nama', 'dospem_nama');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('dospems', function (Blueprint $table) {
            $table->renameColumn('dospem_nik', 'nik');
            $table->renameColumn('dospem_nama', 'nama');
        });
    }
}
