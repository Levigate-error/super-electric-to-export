<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class ChangeClientCreateLogsTable
 */
class ChangeClientCreateLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::table('create_logs', static function (Blueprint $table) {
            $table->string('client', 512)->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::table('create_logs', static function (Blueprint $table) {
            $table->string('client', 128)->change();
        });
    }
}
