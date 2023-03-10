<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePermissionRoleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $connection = config('roles.connection');
        $table = config('roles.permissionsRoleTable');
        $tableCheck = Schema::connection($connection)->hasTable($table);

        if (!$tableCheck) {
            Schema::connection($connection)->create($table, function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->unsignedBigInteger('permission_id')->index();
                $table->foreign('permission_id')->references('id')->on('permissions')->onDelete('cascade');
                $table->unsignedBigInteger('role_id')->index();
                $table->foreign('role_id')->references('id')->on('roles')->onDelete('cascade');
                $table->timestamps();
                $table->softDeletes();
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $connection = config('roles.connection');
        $table = config('roles.permissionsRoleTable');
        Schema::connection($connection)->dropIfExists($table);
    }
}
