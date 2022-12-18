<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreateTestsUsersAnswersTable
 */
class CreateTestsUsersTestAnswersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('tests_users_test_answers', static function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->unsignedBigInteger('test_user_id')->index();
            $table->foreign('test_user_id')
                ->references('id')->on('tests_users')
                ->onUpdate('cascade')->onDelete('cascade');

            $table->unsignedBigInteger('test_answer_id')->index();
            $table->foreign('test_answer_id')
                ->references('id')->on('test_answers')
                ->onUpdate('cascade')->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('tests_users_answers');
    }
}
