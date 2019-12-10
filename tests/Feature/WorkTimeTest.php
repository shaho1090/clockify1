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
    /*
     * @test
     * */

    public function test_user_can_see_projects_in_work_time_page_related_to_specific_work_space()
    {
        //initial user and work space
        $user = $this->registerUserAndCreateWorkSpace();
        //get work space id
        $userWorkSpaceId = $user->workSpaces()->get()->first()->pivot->id;

        //create number of projects for this work space
        $user->workSpaces()->find($userWorkSpaceId)->projects()->createMany([
            ['title'=> 'test project A',],
            ['title'=> 'test project B',],
            ['title'=> 'test project C',],
        ]);

        //check if projects are exist
        $this->assertCount('3', Project::all());
        //go to the work time page
        $response = $this->get(route('work-time.index'));
        //assert see the projects have been created
        $response->assertSeeText('test project A');
        $response->assertSeeText('test project B');
        $response->assertSeeText('test project C');
    }

    /*
     * @test
     *
     * */

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
