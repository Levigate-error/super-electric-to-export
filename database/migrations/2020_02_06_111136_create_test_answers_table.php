<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreateTestAnswersTable
 */
class CreateTestAnswersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('test_answers', static function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->unsignedBigInteger('test_question_id')->index();
            $table->foreign('test_question_id')
                ->references('id')->on('test_questions')
                ->onUpdate('cascade')->onDelete('cascade');

            $table->string('answer', 128);
            $table->boolean('is_correct')->default(true);
            $table->text('description');
            $table->smallInteger('points');
            $table->boolean('published')->default(true);

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
        Schema::dropIfExists('test_answers');
    }
}
