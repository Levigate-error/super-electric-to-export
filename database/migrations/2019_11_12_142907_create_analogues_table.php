<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAnaloguesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('analogues', static function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('vendor', 64)->nullable();
            $table->string('vendor_code', 32)->unique()->index();
            $table->jsonb('description')->nullable();
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
        Schema::dropIfExists('analogues');
    }
}
