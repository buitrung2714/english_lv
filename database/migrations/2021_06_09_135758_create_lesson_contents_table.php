<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLessonContentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lesson_contents', function (Blueprint $table) {
            $table->Increments('lesson_content_id');
            $table->integer('lesson_id')->unsigned();
            $table->integer('question_id')->unsigned();
            $table->foreign('lesson_id')->references('lesson_id')->on('lessons')->onDelete('RESTRICT')->onUpdate('CASCADE');
            $table->foreign('question_id')->references('question_id')->on('questions')->onDelete('RESTRICT')->onUpdate('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('lesson_contents');
    }
}
