<?php

use App\Domain\Dictionaries\Users\SourceDictionary;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSourceToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::table('users', static function (Blueprint $table) {
            $table->string('source')
                ->nullable(true)
                ->comment('Источник откуда пришел пользователь');
        });

        DB::table('users')->update([
            'source' => SourceDictionary::REGISTRATION
        ]);

        Schema::table('users', static function (Blueprint $table) {
            $table->string('source')
                ->nullable(false)
                ->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::table('users', static function (Blueprint $table) {
            $table->dropColumn('source');
        });
    }
}
