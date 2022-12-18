<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductFeatureTypesDivisions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_feature_types_divisions', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->unsignedBigInteger('product_division_id')->index();
            $table->foreign('product_division_id')
                ->references('id')->on('product_divisions')
                ->onDelete('cascade')->onUpdate('cascade');

            $table->unsignedBigInteger('product_feature_type_id')->index();
            $table->foreign('product_feature_type_id')
                ->references('id')->on('product_feature_types')
                ->onDelete('cascade')->onUpdate('cascade');

            $table->boolean('published')->default(true);

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
        Schema::dropIfExists('product_feature_types_divisions');
    }
}
