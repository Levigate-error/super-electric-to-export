<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPointsToLoyaltyUserProposals extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('loyalty_user_proposals', function (Blueprint $table) {
            $table->integer('accrue_points')->nullable()->comment('Количество баллов, которое необходимо начислить пользователю за серийный номер');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('loyalty_user_proposals', function (Blueprint $table) {
            $table->dropColumn('accrue_points');
        });
    }
}
