<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->string('user_email', 50);
            $table->string('user_password', 200);
            $table->string('user_role', 50);
            $table->char('user_status', 1);
            $table->timestamp('user_email_verified_at')->nullable();
            $table->string('user_verify_token', 100)->nullable();
            $table->string('forgetpass_token', 100)->nullable();
            $table->rememberToken();
            $table->timestamps();
            $table->primary('user_email');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
