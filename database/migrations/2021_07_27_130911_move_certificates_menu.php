<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class MoveCertificatesMenu extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $userMenu = DB::table('admin_menu')->where('uri', 'users')->first();
        if ($userMenu) {
            DB::table('admin_menu')->where('uri', 'loyalty-program/settings/certificates')->where('title', 'Сертификаты')->update([
                'parent_id' => $userMenu->id
            ]);
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $settingsMenu = DB::table('admin_menu')->where('uri', 'loyalty-program/settings/certificates')->where('title', 'Настройки')->first();
        if ($settingsMenu) {
            DB::table('admin_menu')->where('uri', 'loyalty-program/settings/certificates')->where('title', 'Сертификаты')->update([
                'parent_id' => $settingsMenu->id
            ]);
        }
    }
}
