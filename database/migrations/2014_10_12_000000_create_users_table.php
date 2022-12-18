<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', static function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('first_name', 128);
            $table->string('last_name', 128);
            $table->string('phone', 32);
            $table->string('email', 128)->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->timestamp('personal_data_agreement_at');
            $table->string('photo', 128)->nullable();
            $table->boolean('published')->default(false);
            $table->boolean('show_contacts')->default(false);
            $table->rememberToken();
            $table->timestamps();
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
