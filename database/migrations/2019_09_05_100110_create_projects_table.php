<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title', 512)->nullable();
            $table->string('address', 512)->nullable();

            $table->unsignedBigInteger('project_status_id')->nullable()->index();
            $table->foreign('project_status_id')->references('id')->on('project_statuses')
                ->onDelete('set null')->onUpdate('cascade');

            $table->unsignedBigInteger('user_id')->nullable()->index();
            $table->foreign('user_id')->references('id')->on('users')
                ->onDelete('set null')->onUpdate('cascade');

            $table->unsignedDecimal('total_price', 16, 2)->default(0);
            $table->string('session_key', 128)->nullable();
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
        Schema::dropIfExists('projects');
    }
}
