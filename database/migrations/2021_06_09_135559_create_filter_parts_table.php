<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFilterPartsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('filter_parts', function (Blueprint $table) {
            $table->Increments('filter_part_id');
            $table->integer('part_id')->unsigned();
            $table->integer('filter_id')->unsigned();
            $table->integer('filter_topic_level');
            $table->integer('filter_part_amount_topic');
            $table->foreign('part_id')->references('part_id')->on('parts')->onDelete('RESTRICT')->onUpdate('CASCADE');
            $table->foreign('filter_id')->references('filter_id')->on('filter_structures')->onDelete('CASCADE')->onUpdate('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('filter_parts');
    }
}
