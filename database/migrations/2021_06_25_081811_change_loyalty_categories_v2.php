<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeLoyaltyCategoriesV2 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::table('loyalty_user_categories')->where('title->ru', 'Новичок')->update(['points' => 5]);
        DB::table('loyalty_user_categories')->where('title->ru', 'Мастер')->update(['points' => 10]);
        DB::table('loyalty_user_categories')->where('title->ru', 'Профессионал')->update(['points' => 15]);
        DB::table('loyalty_user_categories')->where('title->ru', 'Эксперт')->update(['points' => 20]);
        DB::table('loyalty_user_categories')->where('title->ru', 'Суперэлектрик')->update(['points' => 30]);   
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::table('loyalty_user_categories')->where('title->ru', 'Новичок')->update(['points' => 10]);
        DB::table('loyalty_user_categories')->where('title->ru', 'Мастер')->update(['points' => 20]);
        DB::table('loyalty_user_categories')->where('title->ru', 'Профессионал')->update(['points' => 50]);
        DB::table('loyalty_user_categories')->where('title->ru', 'Эксперт')->update(['points' => 100]);
        DB::table('loyalty_user_categories')->where('title->ru', 'Суперэлектрик')->update(['points' => 200]);
    }
}
