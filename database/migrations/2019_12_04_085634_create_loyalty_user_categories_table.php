<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLoyaltyUserCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('loyalty_user_categories', static function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->jsonb('title');
            $table->string('icon', '64');
            $table->unsignedSmallInteger('points');
            $table->timestamps();
        });

        Schema::table('loyalty_users', static function (Blueprint $table) {
            $table->unsignedBigInteger('loyalty_user_category_id')->nullable();
            $table->foreign('loyalty_user_category_id')
                ->references('id')->on('loyalty_user_categories')
                ->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('loyalty_users', static function (Blueprint $table) {
            $table->dropForeign('loyalty_users_loyalty_user_category_id_foreign');
            $table->dropColumn('loyalty_user_category_id');
        });

        Schema::dropIfExists('loyalty_user_categories');
    }
}
