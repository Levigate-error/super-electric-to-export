<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductFeatureValuesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_feature_values', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('product_feature_type_id')->index();
            $table->jsonb('value');
            $table->timestamps();

            $table->foreign('product_feature_type_id')
                ->references('id')->on('product_feature_types')
                ->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('product_feature_values');
    }
}
