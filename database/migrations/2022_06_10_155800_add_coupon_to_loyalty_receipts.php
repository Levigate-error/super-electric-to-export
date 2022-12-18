<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCouponToLoyaltyReceipts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('loyalty_receipts', function (Blueprint $table) {
            $table->string('coupon', 255)->nullable();
            $table->string('coupon_code', 255)->nullable();
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
            $table->dropColumn(['coupon']);
            $table->dropColumn(['coupon_code']);
        });
    }
}
