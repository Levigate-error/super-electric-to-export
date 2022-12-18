<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddVolumeLotteryIdColumnsToLoyaltyReceipts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('loyalty_receipts', function (Blueprint $table) {
            $table->float('amount', 9, 2)->nullable();
            $table->unsignedBigInteger('lottery_id')->nullable();
            $table->unsignedTinyInteger('review_status_id')->default(1);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('loyalty_receipts', function (Blueprint $table) {
            $table->dropColumn(['amount', 'lottery_id', 'review_status_id']);
        });
    }
}
