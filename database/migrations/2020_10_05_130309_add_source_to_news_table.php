<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class AddSourceToNewsTable
 */
class AddSourceToNewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::table('news', static function (Blueprint $table) {
            $table->string('title', 256)->change();
            $table->string('source', 128)->nullable()->after('image');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::table('news', static function (Blueprint $table) {
            $table->string('title', 128)->change();
            $table->dropColumn('source');
        });
    }
}
