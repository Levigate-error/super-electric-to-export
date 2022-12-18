<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class ChangeLengthValueOnCancelReasonTable
 */
class ChangeLengthValueOnCancelReasonTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::table('loyalty_proposal_cancel_reasons', static function (Blueprint $table) {
            $table->string('value', 256)->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::table('loyalty_proposal_cancel_reasons', static function (Blueprint $table) {
            $table->string('value', 128)->change();
        });
    }
}
