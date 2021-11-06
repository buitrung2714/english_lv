<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePartsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('parts', function (Blueprint $table) {
            $table->Increments('part_id');
            $table->integer('skill_id')->unsigned();
            $table->integer('part_no');
            $table->integer('part_topic_max');
            $table->text('part_des')->nullable();
            $table->string('part_name');
            $table->integer('part_amount_ques_per_topic');
            $table->foreign('skill_id')->references('skill_id')->on('skills')->onDelete('RESTRICT')->onUpdate('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('parts');
    }
}
