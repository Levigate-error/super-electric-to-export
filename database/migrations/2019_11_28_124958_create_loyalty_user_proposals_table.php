<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLoyaltyUserProposalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('loyalty_user_proposals', static function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedTinyInteger('points')->default(0);

            $table->unsignedBigInteger('loyalty_user_point_id')->index();
            $table->foreign('loyalty_user_point_id')
                ->references('id')->on('loyalty_user_points')
                ->onDelete('cascade')->onUpdate('cascade');

            $table->unsignedBigInteger('loyalty_product_code_id')->unique()->index();
            $table->foreign('loyalty_product_code_id')
                ->references('id')->on('loyalty_product_codes')
                ->onDelete('cascade')->onUpdate('cascade');

            $table->unsignedBigInteger('loyalty_proposal_cancel_reason_id')->nullable();
            $table->foreign('loyalty_proposal_cancel_reason_id')
                ->references('id')->on('loyalty_proposal_cancel_reasons')
                ->onDelete('cascade')->onUpdate('cascade');

            $table->string('proposal_status');
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
        Schema::dropIfExists('loyalty_user_proposals');
    }
}
