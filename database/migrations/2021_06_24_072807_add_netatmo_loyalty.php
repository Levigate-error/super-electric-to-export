<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class AddNetatmoLoyalty extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::table('loyalties')->insert([
            'title' => 'Стань суперэлектриком with Netatmo 2.1',
            'active' => true,
            'started_at' => now(),
            'ended_at' => now()->addYear(),
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
        DB::table('loyalties')
            ->where('title', 'Стань суперэлектриком with Netatmo 2.1')
            ->delete();
    }
}
