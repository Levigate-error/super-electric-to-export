<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateExternalEntitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('external_entities', static function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->unsignedBigInteger('source_id')->index();
            $table->string('external_id', 64);
            $table->string('source_type', 64)->index();
            $table->string('system', 64)->index();

            $table->unique(['source_id', 'source_type', 'system'], 'unique_external_entity');

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
        Schema::dropIfExists('external_entities');
    }
}
