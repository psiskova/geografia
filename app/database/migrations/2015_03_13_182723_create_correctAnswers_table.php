<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCorrectAnswersTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('correctAnswers', function(Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->integer('question_id')->unsigned();
            $table->foreign('question_id')->references('id')->on('questions');
            $table->longText('text');
            $table->boolean('correct')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::drop('correctAnswers');
    }

}
