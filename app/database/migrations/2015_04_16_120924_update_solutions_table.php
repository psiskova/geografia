<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateSolutionsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::table('solutions', function(Blueprint $table) {
            $table->integer('homework_id')->unsigned();
            $table->foreign('homework_id')->references('id')->on('homeworks');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::table('solutions', function(Blueprint $table) {
            //
        });
    }

}
