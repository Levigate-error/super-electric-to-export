<?php

use App\Domain\Dictionaries\Loyalty\LoyaltyUserPrizeWinningStatuses;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLoyaltyUserPrizeWinnings extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('loyalty_user_prize_winnings', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('loyalty_user_id');
            $table->foreign('loyalty_user_id')
                ->references('id')
                ->on('loyalty_users')
                ->onDelete('cascade');
            $table->string('month');
            $table->tinyInteger('status')
                ->default(LoyaltyUserPrizeWinningStatuses::NEW);
            $table->string('title');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('loyalty_user_prize_winnings');
    }
}
