<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddDatetimeFnFpFdToLoyaltyReceipts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('loyalty_receipts', function (Blueprint $table) {
            $table->dateTime('receipt_datetime')->nullable();
            $table->string('fn', 255)->nullable();
            $table->string('fp', 255)->nullable();
            $table->string('fd', 255)->nullable();
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
            $table->dropColumn(['receipt_datetime', 'fn', 'fp', 'fd',]);
        });
    }
}
