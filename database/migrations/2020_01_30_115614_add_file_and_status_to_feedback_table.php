<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class AddFileAndStatusToFeedbackTable
 */
class AddFileAndStatusToFeedbackTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('feedback', static function (Blueprint $table) {
            $table->string('status')->nullable();
            $table->string('file', 128)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('feedback', static function (Blueprint $table) {
            $table->dropColumn([
                'status',
                'file',
            ]);
        });
    }
}
