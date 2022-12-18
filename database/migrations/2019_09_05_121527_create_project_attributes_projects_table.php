<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProjectAttributesProjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('project_attributes_projects', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->unsignedBigInteger('project_id')->index();
            $table->foreign('project_id')->references('id')->on('projects')
                ->onDelete('cascade')->onUpdate('cascade');

            $table->unsignedBigInteger('project_attribute_id')->index();
            $table->foreign('project_attribute_id')->references('id')->on('project_attributes')
                ->onDelete('cascade')->onUpdate('cascade');

            $table->unsignedBigInteger('project_attribute_value_id')->index();
            $table->foreign('project_attribute_value_id')->references('id')->on('project_attribute_values')
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
        Schema::dropIfExists('project_attributes_projects');
    }
}
