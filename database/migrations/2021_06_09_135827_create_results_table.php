<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateResultsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('results', function (Blueprint $table) {
            $table->Increments('result_id');
            $table->integer('student_id')->unsigned();
            $table->integer('teacher_id')->unsigned()->nullable();
            $table->double('total_mark',8,2)->nullable();
            $table->double('fee',8,2);
            $table->integer('result_status')->nullable();
            $table->integer('route_id')->nullable();
            $table->integer('submit');
            $table->timestamps();
            $table->foreign('student_id')->references('student_id')->on('students')->onDelete('RESTRICT')->onUpdate('CASCADE');
            $table->foreign('teacher_id')->references('staff_id')->on('staff')->onDelete('RESTRICT')->onUpdate('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('results');
    }
}
