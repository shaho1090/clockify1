<?php

namespace Tests\Feature;

use App\Project;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Str;
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

        $this->assertDatabaseMissing('projects', [
            'title' => 'AB',
        ]);
    }

    /*
     * @test
     * */
    public function test_project_title_cont_be_greater_than_50_char()
    {
        $user = $this->registerUserAndCreateWorkSpace();

        $title = Str::random('51');

        $this->post(route('projects.store', [
            'title' => $title,
            'work_space_id' => $user->workSpaces()->get()->first()->id,
        ]))->assertSessionHas('errors');

        $this->assertDatabaseMissing('projects', [
            'title' => $title,
        ]);
    }

    /*
     * @test
     *
     * */
    public function test_project_title_can_update()
    {
        $user = $this->registerUserAndCreateWorkSpace();

        $workSpaceId = $user->workSpaces()->get()->first()->id;

        $project = $user->workSpaces()->find($workSpaceId)
            ->projects()
            ->create(['title' => Str::random('20')]);

        $newTitle = Str::random('25');

        $this->put(route('projects.update', $project->id), [
            'title' => $newTitle,
        ])->assertSessionDoesntHaveErrors();

        $this->assertDatabaseHas('projects', ['title' => $newTitle]);
    }
    /*
     * @test
     *
     * */

    public function test_user_can_delete_project()
    {
        $user = $this->registerUserAndCreateWorkSpace();

        $workSpaceId = $user->workSpaces()->get()->first()->id;

        $project = $user->workSpaces()->find($workSpaceId)
            ->projects()
            ->create(['title' => Str::random('20')]);

        $this->delete(route('projects.destroy',$project->id))->assertSessionDoesntHaveErrors();

        $this->assertSoftDeleted('projects', ['id' =>$project->id]);
    }
}
