<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddRemoteReceiptIdToLoyaltyReceipts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('loyalty_receipts', function (Blueprint $table) {
            $table->string('remote_receipt_id', 255)->nullable();
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
            $table->dropColumn(['remote_receipt_id']);
        });
    }
}
