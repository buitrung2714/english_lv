<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetailRoutesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detail_routes', function (Blueprint $table) {
            $table->integer('filter_id')->unsigned();
            $table->integer('route_id')->unsigned();
            $table->integer('detail_route_level');
            $table->foreign('filter_id')->references('filter_id')->on('filter_structures')->onDelete('RESTRICT')->onUpdate('CASCADE');
            $table->foreign('route_id')->references('route_id')->on('routes')->onDelete('RESTRICT')->onUpdate('CASCADE');
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('detail_routes');
    }
}
