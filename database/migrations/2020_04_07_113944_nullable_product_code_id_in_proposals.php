<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class NullableProductCodeIdInProposals
 */
class NullableProductCodeIdInProposals extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::table('loyalty_user_proposals', static function (Blueprint $table) {
            $table->unsignedBigInteger('loyalty_product_code_id')->nullable()->change();
            $table->string('code', 32)->nullable()->unique();
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
            $table->unsignedBigInteger('loyalty_product_code_id')->nullable(false)->change();
            $table->dropColumn('code');
        });
    }
}
