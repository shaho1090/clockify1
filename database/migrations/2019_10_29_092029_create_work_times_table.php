<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWorkTimesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('work_times', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_work_space_id');
            $table->dateTime('start_time');
            $table->dateTime('stop_time')->nullable();
            $table->boolean('billable')->default(true);
            $table->unsignedBigInteger('project_id')->nullable();
            $table->unsignedBigInteger('tag_id')->nullable();
            $table->string('title')->nullable();
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
        Schema::dropIfExists('time_works');
    }
}
