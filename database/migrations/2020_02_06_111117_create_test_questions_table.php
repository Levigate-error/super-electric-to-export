<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreateTestQuestionsTable
 */
class CreateTestQuestionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('test_questions', static function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->unsignedBigInteger('test_id')->index();
            $table->foreign('test_id')
                ->references('id')->on('tests')
                ->onUpdate('cascade')->onDelete('cascade');

            $table->text('question');
            $table->string('image', 128)->nullable();
            $table->string('video', 128)->nullable();
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
        Schema::dropIfExists('test_questions');
    }
}
