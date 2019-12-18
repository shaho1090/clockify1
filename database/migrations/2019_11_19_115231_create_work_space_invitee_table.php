<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWorkSpaceInviteeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('work_space_invitee', function (Blueprint $table) {
            $table->softDeletes();
            $table->bigIncrements('id');
            $table->unsignedBigInteger('work_space_id');
            $table->unsignedBigInteger('invitee_id');
            $table->string('token');
            $table->timestamps();
            $table->unique(['invitee_id', 'work_space_id']);
            $table->foreign('work_space_id')
                ->references('id')->on('work_spaces')
                ->onDelete('cascade');
            $table->foreign('invitee_id')
                ->references('id')->on('invitees')
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
        Schema::dropIfExists('work_space_invitee');
    }
}
