<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAnalogueProductTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('analogue_product', static function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->unsignedBigInteger('product_id')->index();
            $table->foreign('product_id')
                ->references('id')->on('products')
                ->onDelete('cascade')->onUpdate('cascade');

            $table->unsignedBigInteger('analogue_id')->index();
            $table->foreign('analogue_id')
                ->references('id')->on('analogues')
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
        Schema::dropIfExists('analogue_product');
    }
}
