<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProjectSpecificationSectionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('project_specification_sections', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->unsignedBigInteger('project_specification_id')->index();
            $table->foreign('project_specification_id')->references('id')->on('project_specifications')
                ->onDelete('cascade')->onUpdate('cascade');

            $table->string('title');
            $table->integer('discount')->default(0);
            $table->boolean('active')->default(true);

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
        Schema::dropIfExists('project_specification_sections');
    }
}
