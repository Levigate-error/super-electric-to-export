<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProjectProductChangesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('project_product_changes', static function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->unsignedBigInteger('product_id')->index()->nullable();
            $table->foreign('product_id')->references('id')->on('products')
                ->onDelete('cascade')->onUpdate('cascade');

            $table->unsignedBigInteger('project_id')->index();
            $table->foreign('project_id')->references('id')->on('projects')
                ->onDelete('cascade')->onUpdate('cascade');

            $table->string('vendor_code', 32)->index();
            $table->string('name', 128)->nullable();
            $table->string('old_value', 128)->nullable();
            $table->string('new_value', 128)->nullable();
            $table->string('type', 32);
            $table->boolean('used')->default(false);
            $table->jsonb('additional_params')->nullable();
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
        Schema::dropIfExists('project_product_update');
    }
}
