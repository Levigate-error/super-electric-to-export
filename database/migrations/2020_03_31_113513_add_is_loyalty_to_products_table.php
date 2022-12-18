<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class AddIsLoyaltyToProductsTable
 */
class AddIsLoyaltyToProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::table('products', static function (Blueprint $table) {
            $table->boolean('is_loyalty')->default(false)->index();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::table('products', static function (Blueprint $table) {
            $table->dropColumn('is_loyalty');
        });
    }
}
