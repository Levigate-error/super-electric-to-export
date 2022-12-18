<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cities', static function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->jsonb('title');
            $table->timestamps();
        });

        Schema::table('users', static function (Blueprint $table) {
            $table->unsignedBigInteger('city_id')->nullable();
            $table->foreign('city_id')
                ->references('id')->on('cities')
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
        Schema::table('users', static function (Blueprint $table) {
            $table->dropForeign('users_city_id_foreign');
            $table->dropColumn('city_id');
        });

        Schema::dropIfExists('cities');
    }
}
