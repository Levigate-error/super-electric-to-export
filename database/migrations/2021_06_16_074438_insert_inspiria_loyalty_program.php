<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class InsertInspiriaLoyaltyProgram extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::table('loyalties')->insert([
            'title' => 'Inspiria',
            'started_at' => now(),
            'ended_at' => now()->addYears(10),
            'active' => true,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::table('loyalties')->where('title', 'Inspiria')->delete();
    }
}
