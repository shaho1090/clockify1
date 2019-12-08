<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class projectTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_user_can_create_project()
    {
//        $users = $this->registerAndCreateWorkSpace();
//
//        $user = $users[rand(1, 20)];
//
//        $this->actingAs($user);
        $user = $this->registerUserAndCreateWorkSpace();

        $this->post(route('projects.store', [
            'title' => $user->name . ' test project',
            'work_space_id' => $user->workSpaces()->get()->first()->id,
        ]));

        $this->assertDatabaseHas('projects', [
            'title' => $user->name . ' test project',
            'work_space_id' => $user->workSpaces()->get()->first()->id,
        ]);
    }
    /*
     * @test
     * */
    public function test_project_title_cant_be_less_than_3_char()
    {
        $user = $this->registerUserAndCreateWorkSpace();

        $this->post(route('projects.store', [
            'title' => 'AB',
            'work_space_id' => $user->workSpaces()->get()->first()->id,
        ]))->assertSessionHas('errors');



       $this->assertDatabaseMissing('projects',[
           'title' => 'AB',
       ]);


    }
}
