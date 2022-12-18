<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLoyaltyGiftsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('loyalty_gifts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('loyalty_user_id');
            $table->foreign('loyalty_user_id')
                ->references('id')->on('loyalty_users')
                ->onDelete('cascade')->onUpdate('cascade');
            $table->unsignedInteger('gift_id')->nullable();
            $table->unsignedTinyInteger('status_id');
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
        Schema::dropIfExists('loyalty_gifts');
    }
}
