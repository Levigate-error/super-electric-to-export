<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class DropUniqueCodeLoyaltyUserProposalsTable
 */
class DropUniqueCodeLoyaltyUserProposalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::table('loyalty_user_proposals', static function (Blueprint $table) {
            $table->dropUnique('loyalty_user_proposals_code_unique');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::table('loyalty_user_proposals', static function (Blueprint $table) {
            $table->unique('code');
        });
    }
}
