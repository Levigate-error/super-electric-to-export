<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_categories', static function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->jsonb('name');
            $table->boolean('published')->default(true);
            $table->boolean('in_main')->default(false);
            $table->string('image', 128)->nullable();
            $table->timestamps();
        });

        Schema::table('product_divisions', static function (Blueprint $table) {
            $table->unsignedBigInteger('category_id')->nullable()->index();

            $table->foreign('category_id')->references('id')->on('product_categories')
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
        if (Schema::hasColumn('product_divisions', 'category_id')) {
            Schema::table('product_divisions', static function (Blueprint $table) {
                $table->dropColumn('category_id');
            });
        }

        Schema::dropIfExists('product_categories');
    }
}
