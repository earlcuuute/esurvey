<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateResponseDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('response_details', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('response_id')->unsigned();
            $table->foreign('response_id')
                ->references('id')->on('responses')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->text('text_answer');
            $table->integer('choice_id')->unsigned();
            $table->foreign('choice_id')
                ->references('id')->on('question_choices')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->time('response_time');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('response_details');
    }
}
