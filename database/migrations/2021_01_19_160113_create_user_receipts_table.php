<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserReceiptsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('loyalty_receipts', function (Blueprint $table) {

            $table->bigIncrements('id');
            $table->unsignedBigInteger('loyalty_user_id');
            $table->unsignedInteger('points_already_accured')->nullable();
            $table->unsignedTinyInteger('status_id');

            $table->timestamps();
            $table->foreign('loyalty_user_id')
                ->references('id')->on('loyalty_users')
                ->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('loyalty_receipts');
    }
}
