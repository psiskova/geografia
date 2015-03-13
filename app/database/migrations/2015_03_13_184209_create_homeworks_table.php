<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHomeworksTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('homeworks', function(Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->integer('task_id')->unsigned();
            $table->foreign('task_id')->references('id')->on('tasks');
            $table->longText('text');
            $table->integer('points');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::drop('homeworks');
    }

}
