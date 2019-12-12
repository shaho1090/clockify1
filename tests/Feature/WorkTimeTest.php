<?php

namespace Tests\Feature;

use App\Project;
use App\Tag;
use App\User;
use App\WorkSpace;
use App\WorkTime;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;

use Facades\Tests\MyFactories\WorkSpaceFactory;
//use Tests\MyFactories\WorkSpaceFactory;
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

        //create another work space for test
        $user->addWorkSpace('work space for test seeing projects');

        //check if two work space is exist
        $this->assertEquals($user->activeUserWorkSpace()->id, WorkSpace::where('title','=','work space for test seeing projects' )->get()->first()->id);

        //get work space id
        $userWorkSpaceId = $user->workSpaces()->get()->first()->pivot->id;

        $this->assertCount(0, Project::all());
        //create number of projects for this work space
        $user->workSpaces()->find($userWorkSpaceId)->projects()->createMany([
            ['title'=> 'test project A',],
            ['title'=> 'test project B',],
            ['title'=> 'test project C',],
        ]);

        //check if projects are exist
        $this->assertCount( 3, Project::all());
        //go to the work time page
        $response = $this->json('get',route('work-time.index'));
        //assert see the projects those have been created
       // dd($response);
     //   $response->assertSee('test project A');
//        $response->assertSee('test project B');
//        $response->assertSee('test project C');
    }

    public function test_user_can_see_projects_in_work_time_page_related_to_specific_work_space_2()
    {
        $user = $this->login();

        $this->assertCount(0,Tag::all());
        $this->assertCount(0,Project::all());
        $this->assertCount(0,WorkSpace::all());

        $workSpace = WorkSpaceFactory::ownedBy($user)->withTags(3)->withProjects(4)->create();

       // dd(Tag::all());

        $this->assertCount(1,WorkSpace::all());
        $this->assertCount(3,Tag::all());
        $this->assertCount(4,Project::all());

        $response = $this->json('get',route('work-time.index'));


    }

    /*
     * @test
     *
     * */

}
