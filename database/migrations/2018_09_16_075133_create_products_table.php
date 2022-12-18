<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', static function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('vendor_code', 32)->unique();
            $table->jsonb('name');
            $table->jsonb('description')->nullable();
            $table->unsignedDecimal('recommended_retail_price', 16, 2);
            $table->unsignedInteger('min_amount');
            $table->jsonb('unit');
            $table->unsignedInteger('rank')->default(0);

            $table->unsignedBigInteger('division_id')->index();
            $table->unsignedBigInteger('category_id')->index();
            $table->unsignedBigInteger('family_id')->index();

            $table->foreign('division_id')->references('id')->on('product_divisions')
                ->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('category_id')->references('id')->on('product_categories')
                ->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('family_id')->references('id')->on('product_families')
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
        Schema::dropIfExists('products');
    }
}
