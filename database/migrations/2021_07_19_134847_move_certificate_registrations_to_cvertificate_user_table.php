<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class MoveCertificateRegistrationsToCvertificateUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $certificates = DB::table('loyalty_users')->whereNotNull('loyalty_certificate_id')->get();
        $certificates->each(function ($certificate) {
            DB::table('certificate_user')->create([
                'user_id' => $certificate->user_id,
                'certificate_id' => $certificate->loyalty_certificate_id,
            ]);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::table('certificate_user')->truncate();
    }
}
