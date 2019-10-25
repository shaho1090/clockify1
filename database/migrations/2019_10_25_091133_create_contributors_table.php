<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContributorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contributors', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('contributor')->unsigned();
            $table->bigInteger('project_id')->unsigned();
            $table->timestamps();
            $table->foreign('contributor')
                 ->references('id')->on('users')
                 ->onUpdate('cascade');
            $table->foreign('project_id')
                 ->references('id')->on('projects')
                 ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('contributors');
    }
}
