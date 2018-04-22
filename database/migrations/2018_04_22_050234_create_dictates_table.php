<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDictatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dictates', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->integer('score');
            $table->string('word');
            $table->string('last_dictate_date');
            $table->integer('userid');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('dictates');
    }
}
