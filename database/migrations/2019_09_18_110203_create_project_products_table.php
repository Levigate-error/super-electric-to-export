<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProjectProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('project_products', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->unsignedBigInteger('product_id')->index();
            $table->foreign('product_id')->references('id')->on('products')
                ->onDelete('cascade')->onUpdate('cascade');

            $table->unsignedBigInteger('project_id')->index();
            $table->foreign('project_id')->references('id')->on('projects')
                ->onDelete('cascade')->onUpdate('cascade');

            $table->unsignedInteger('amount')->default(1);
            $table->unsignedInteger('not_used_amount')->default(1);
            $table->boolean('in_stock')->default(true);
            $table->boolean('active')->default(true);
            $table->unsignedMediumInteger('discount')->default(0);
            $table->unsignedDecimal('real_price', 16, 2);
            $table->unsignedDecimal('price_with_discount', 16, 2);
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
        Schema::dropIfExists('project_products');
    }
}
