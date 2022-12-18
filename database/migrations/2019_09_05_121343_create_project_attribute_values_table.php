<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProjectAttributeValuesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('project_attribute_values', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->jsonb('title');

            $table->unsignedBigInteger('project_attribute_id')->index();
            $table->foreign('project_attribute_id')->references('id')->on('project_attributes')
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
        Schema::dropIfExists('project_attribute_values');
    }
}
