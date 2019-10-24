<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvitationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invitations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('project_owner')->unsigned();
            $table->bigInteger('invited')->unsigned();
            $table->bigInteger('project_id')->unsigned();
            $table->timestamps();
            $table->foreign('project_owner')
                ->references('owner')->on('projects')
                ->onUpdate('cascade');
            $table->foreign('invited')
                ->references('id')->on('users')
                ->onUpdate('cascade');
            $table->foreign('project_id')
                ->references('id')->on('project')
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
        Schema::dropIfExists('invitations');
    }
}
