
<?php
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class ChangeLoyaltyCategories extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::table('loyalty_user_categories')->where('title->ru', 'Новичок')->update(['points' => 10]);
        DB::table('loyalty_user_categories')->where('title->ru', 'Мастер')->update(['points' => 20]);
        DB::table('loyalty_user_categories')->where('title->ru', 'Профессионал')->update(['points' => 50]);
        DB::table('loyalty_user_categories')->where('title->ru', 'Эксперт')->update(['points' => 100]);
        DB::table('loyalty_user_categories')->where('title->ru', 'Суперэлектрик')->update(['points' => 200]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::table('loyalty_user_categories')->where('title->ru', 'Новичок')->update(['points' => 1]);
        DB::table('loyalty_user_categories')->where('title->ru', 'Мастер')->update(['points' => 5]);
        DB::table('loyalty_user_categories')->where('title->ru', 'Профессионал')->update(['points' => 10]);
        DB::table('loyalty_user_categories')->where('title->ru', 'Эксперт')->update(['points' => 20]);
        DB::table('loyalty_user_categories')->where('title->ru', 'Суперэлектрик')->update(['points' => 30]);
    }
}
