<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProjectSpecificationProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('project_specification_products', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->unsignedBigInteger('project_specification_section_id')->index();
            $table->foreign('project_specification_section_id')->references('id')->on('project_specification_sections')
                ->onDelete('cascade')->onUpdate('cascade');

            $table->unsignedBigInteger('product_id')->index();
            $table->foreign('product_id')->references('id')->on('products')
                ->onDelete('cascade')->onUpdate('cascade');

            $table->unsignedBigInteger('project_product_id')->index();
            $table->foreign('project_product_id')->references('id')->on('project_products')
                ->onDelete('cascade')->onUpdate('cascade');

            $table->unsignedInteger('amount')->default(1);
            $table->unsignedDecimal('real_price', 16, 2);
            $table->unsignedDecimal('price', 16, 2);
            $table->unsignedDecimal('total_price', 16, 2)->default(0);
            $table->boolean('in_stock')->default(true);
            $table->boolean('active')->default(true);
            $table->unsignedMediumInteger('discount')->default(0);

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
        Schema::dropIfExists('project_specification_products');
    }
}
