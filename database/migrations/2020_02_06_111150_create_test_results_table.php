<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreateTestResultsTable
 */
class CreateTestResultsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('test_results', static function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->unsignedBigInteger('test_id')->index();
            $table->foreign('test_id')
                ->references('id')->on('tests')
                ->onUpdate('cascade')->onDelete('cascade');

            $table->string('title', 128);
            $table->text('description');
            $table->tinyInteger('percent_from');
            $table->tinyInteger('percent_to');
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
        Schema::dropIfExists('test_results');
    }
}
