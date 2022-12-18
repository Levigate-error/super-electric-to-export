<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreateVideosTable
 */
class CreateVideosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('videos', static function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->jsonb('title');
            $table->boolean('published')->default(true);
            $table->string('video');

            $table->unsignedBigInteger('video_category_id')->index();
            $table->foreign('video_category_id')
                ->references('id')->on('video_categories')
                ->onUpdate('cascade')->onDelete('cascade');

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
        Schema::dropIfExists('videos');
    }
}
