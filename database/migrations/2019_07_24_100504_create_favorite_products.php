<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFavoriteProducts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('favorite_products', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->unsignedBigInteger('product_id')->index();
            $table->foreign('product_id')
                ->references('id')->on('products')
                ->onDelete('cascade')->onUpdate('cascade');

            $table->unsignedBigInteger('user_id')->index();
            $table->foreign('user_id')
                ->references('id')->on('users')
                ->onDelete('cascade')->onUpdate('cascade');

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
        Schema::dropIfExists('favorite_products');
    }
}
