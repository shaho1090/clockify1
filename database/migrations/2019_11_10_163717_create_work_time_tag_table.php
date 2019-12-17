<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWorkTimeTagTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('work_time_tag', function (Blueprint $table) {
            $table->softDeletes();
            $table->bigIncrements('id');
            $table->unsignedBigInteger('work_time_id');
            $table->unsignedBigInteger('tag_id');
            $table->timestamps();
            $table->foreign('work_time_id')
                ->references('id')->on('work_times')
                ->onDelete('cascade');
            $table->foreign('tag_id')
                ->references('id')->on('tags')
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
        Schema::dropIfExists('work_time_tag');
    }
}
