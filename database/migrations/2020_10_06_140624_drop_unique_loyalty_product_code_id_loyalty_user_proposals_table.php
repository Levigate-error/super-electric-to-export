<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class DropUniqueLoyaltyProductCodeIdLoyaltyUserProposalsTable
 */
class DropUniqueLoyaltyProductCodeIdLoyaltyUserProposalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::table('loyalty_user_proposals', static function (Blueprint $table) {
            $table->dropUnique('loyalty_user_proposals_loyalty_product_code_id_unique');
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
            $table->unique('loyalty_product_code_id');
        });
    }
}
