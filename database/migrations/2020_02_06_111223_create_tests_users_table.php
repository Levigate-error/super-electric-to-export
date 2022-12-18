<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreateTestsUsersTable
 */
class CreateTestsUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('tests_users', static function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->unsignedBigInteger('test_id')->index();
            $table->foreign('test_id')
                ->references('id')->on('tests')
                ->onUpdate('cascade')->onDelete('cascade');

            $table->unsignedBigInteger('user_id')->index();
            $table->foreign('user_id')
                ->references('id')->on('users')
                ->onUpdate('cascade')->onDelete('cascade');

            $table->unsignedBigInteger('test_result_id')->nullable();
            $table->foreign('test_result_id')
                ->references('id')->on('test_results')
                ->onUpdate('cascade')->onDelete('cascade');

            $table->smallInteger('points');

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
        Schema::dropIfExists('tests_users');
    }
}
