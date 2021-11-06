<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAnswerStudentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('answer_students', function (Blueprint $table) {
            $table->integer('lesson_content_id')->unsigned();
            $table->integer('result_id')->unsigned();
            $table->integer('ans_id_stu')->nullable();
            $table->text('ans_task')->nullable();
            $table->string('note')->nullable();
            $table->double('mark',8,2)->nullable();
            // $table->primary(array('lesson_content_id', 'result_id'));
            $table->foreign('lesson_content_id')->references('lesson_content_id')->on('lesson_contents')->onDelete('RESTRICT')->onUpdate('CASCADE');
            $table->foreign('result_id')->references('result_id')->on('results')->onDelete('RESTRICT')->onUpdate('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('answer_students');
    }
}
