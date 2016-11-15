<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserStoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_stories', function (Blueprint $table) {
            $table->increments('id');
            $table->string('description');
            $table->string('status')->nullable();
            $table->string('commit')->nullable();
            $table->date('date_begin')->nullable();
            $table->date('date_estimated')->nullable();
            $table->date('date_finished')->nullable();
            $table->integer('effort');
            $table->integer('priority');
            $table->integer('project_id')->unsigned();
            $table->foreign('project_id')->references('id')->on('projects');
            $table->integer('sprint_id')->unsigned()->nullable();
            $table->foreign('sprint_id')->references('id')->on('sprints')->onDelete('cascade');
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
        Schema::dropIfExists('user_stories');
    }
}
