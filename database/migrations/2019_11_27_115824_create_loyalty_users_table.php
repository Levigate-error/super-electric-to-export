<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLoyaltyUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('loyalty_users', static function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->unsignedBigInteger('user_id')->index();
            $table->foreign('user_id')
                ->references('id')->on('users')
                ->onDelete('cascade')->onUpdate('cascade');

            $table->unsignedBigInteger('loyalty_certificate_id')->index()->unique();
            $table->foreign('loyalty_certificate_id')
                ->references('id')->on('loyalty_certificates')
                ->onDelete('cascade')->onUpdate('cascade');

            $table->unsignedBigInteger('loyalty_id')->index();
            $table->foreign('loyalty_id')
                ->references('id')->on('loyalties')
                ->onDelete('cascade')->onUpdate('cascade');

            $table->unique(['user_id', 'loyalty_id'], 'unique_loyalty_user');

            $table->string('status');
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
        Schema::dropIfExists('loyalty_users');
    }
}
