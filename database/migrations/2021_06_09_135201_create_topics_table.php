<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTopicsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('topics', function (Blueprint $table) {
            $table->Increments('topic_id');
            $table->integer('part_id')->unsigned();
            $table->integer('level_id')->unsigned();
            $table->string('topic_name');
            $table->string('topic_audio')->nullable();
            $table->longtext('topic_content')->nullable();
            $table->string('topic_image')->nullable();
            $table->string('path')->nullable();
            $table->string('path_img')->nullable();
            $table->foreign('part_id')->references('part_id')->on('parts')->onDelete('RESTRICT')->onUpdate('CASCADE');
            $table->foreign('level_id')->references('level_id')->on('levels')->onDelete('RESTRICT')->onUpdate('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('topics');
    }
}
