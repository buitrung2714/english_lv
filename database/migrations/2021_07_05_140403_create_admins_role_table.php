<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdminsRoleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admins_role', function (Blueprint $table) {
            $table->id();
            $table->integer('staff_id')->unsigned();
            $table->integer('role_id')->unsigned();
            $table->foreign('staff_id')->references('staff_id')->on('staff')->onDelete('RESTRICT')->onUpdate('CASCADE');
            $table->foreign('role_id')->references('role_id')->on('roles')->onDelete('RESTRICT')->onUpdate('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('admins_role');
    }
}
