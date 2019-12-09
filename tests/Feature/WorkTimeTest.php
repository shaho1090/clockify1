<?php

namespace Tests\Feature;

use App\Project;
use App\WorkTime;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;

use Tests\TestCase;

class WorkTimeTest extends TestCase
{
    use refreshDatabase;
    /**
     *
     * @return void
     */
    public function test_user_can_start_work_time()
    {
        $this->registerUserAndCreateWorkSpace();

        //$userWorkSpaceId = $user->workSpaces()->get()->first()->pivot->id;

        $this->post(route('work-time.start'))->assertSessionDoesntHaveErrors();

        $this->assertCount(1, WorkTime::all());

    }
    /**
     *
     * @return void
     */

    public function test_user_can_stop_work_time()
    {
        $user = $this->registerUserAndCreateWorkSpace();

        $this->post(route('work-time.stop', [
            'title' => 'work time for test']));

        $this->assertNotNull($user->completeWorkTimes());
    }

    public function test_user_can_see_projects_in_work_time_page()
    {
        $user = $this->registerUserAndCreateWorkSpace();

        $userWorkSpaceId = $user->workSpaces()->get()->first()->pivot->id;

        $user->workSpaces()->find($userWorkSpaceId)->projects()->createMany([
            ['title'=> 'test project A',],
            ['title'=> 'test project B',],
            ['title'=> 'test project C',],
            ['title'=> 'test project D',],
        ]);

        $this->assertCount('4', Project::all());

        $response = $this->get(route('work-time.index'));

        dd($response);


    }

    public function createManyProjects()
    {
        $user = $this->registerUserAndCreateWorkSpace();

        $userWorkSpaceId = $user->workSpaces()->get()->first()->pivot->id;

        $user->workSpaces()->find($userWorkSpaceId)->projects()->createMany([
            ['title'=> 'test project A',],
            ['title'=> 'test project B',],
            ['title'=> 'test project C',],
            ['title'=> 'test project D',],
        ]);
    }
}
