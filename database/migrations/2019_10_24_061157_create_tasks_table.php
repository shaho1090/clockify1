<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTasksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title');
            $table->bigInteger('contributor')->unsigned();
            $table->bigInteger('project_id')->unsigned();
            $table->dateTime('start_time');
            $table->dateTime('stop_time');
            $table->boolean('billable');
            $table->timestamps();
            $table->foreign('contributor')
                ->references('contributor')->on('contributors')
                ->onUpdate('cascade');
            $table->foreign('project_id')
                ->references('id')->on('projects')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tasks');
    }
}
