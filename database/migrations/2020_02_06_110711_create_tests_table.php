<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreateTestsTable
 */
class CreateTestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('tests', static function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->string('title', 128);
            $table->string('image', 128)->nullable();
            $table->text('description');
            $table->boolean('published')->default(true);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('tests');
    }
}
