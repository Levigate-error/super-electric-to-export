<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class MakeLoyaltyCertificateIdNullable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('loyalty_users', function (Blueprint $table) {
            $table->bigInteger('loyalty_certificate_id')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('loyalty_users', function (Blueprint $table) {
            $table->bigInteger('loyalty_certificate_id')->change();
        });
    }
}
