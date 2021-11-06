<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLessonsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lessons', function (Blueprint $table) {
            $table->Increments('lesson_id');
            $table->integer('filter_id')->unsigned()->nullable();
            $table->boolean('lesson_status');
            $table->timestamps();
            $table->foreign('filter_id')->references('filter_id')->on('filter_structures')->onDelete('RESTRICT')->onUpdate('CASCADE');
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('lessons');
    }
}
