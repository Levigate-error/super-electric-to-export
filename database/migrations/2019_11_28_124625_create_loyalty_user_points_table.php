<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLoyaltyUserPointsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('loyalty_user_points', static function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('points')->default(0);
            $table->unsignedInteger('place')->default(0);
            $table->unsignedInteger('points_gap')->default(0);

            $table->unsignedBigInteger('loyalty_user_id')->unique()->index();
            $table->foreign('loyalty_user_id')
                ->references('id')->on('loyalty_users')
                ->onDelete('cascade')->onUpdate('cascade');

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
        Schema::dropIfExists('loyalty_user_points');
    }
}
