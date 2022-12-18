<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeUserCertificatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('loyalty_users', static function (Blueprint $table) {
            $table->dropForeign('loyalty_users_loyalty_certificate_id_foreign');
            $table->foreign('loyalty_certificate_id')
                ->references('id')->on('certificates')
                ->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('loyalty_users', static function (Blueprint $table) {
            $table->dropForeign('loyalty_users_loyalty_certificate_id_foreign');
            $table->foreign('loyalty_certificate_id')
                ->references('id')->on('loyalty_certificates')
                ->onDelete('cascade')->onUpdate('cascade');
        });
    }
}
