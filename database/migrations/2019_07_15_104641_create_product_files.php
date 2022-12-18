<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductFiles extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_files', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('type', 32);
            $table->jsonb('description')->nullable();
            $table->string('file_link');
            $table->jsonb('comment')->nullable();

            $table->unsignedBigInteger('product_id')->index();
            $table->foreign('product_id')
                ->references('id')->on('products')
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
        Schema::dropIfExists('product_files');
    }
}
