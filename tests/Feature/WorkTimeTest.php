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

        $this->post(route('work-time.start'));

        $this->assertCount(1, WorkTime::all());

        $this->assertCount(1, WorkTime::unCompleted()->get()->all());
    }

    /**
     *
     * @return void
     */

    public function test_user_can_stop_work_time()
    {
        $user = $this->registerUserAndCreateWorkSpace();

        $this->post(route('work-time.start'));

        $this->assertCount(1, WorkTime::all());

        $this->post(route('work-time.stop', [
            'selectBillable' => true,
            'title' => 'work time for test']));

        $this->assertNotNull($user->workTimes()->completed()->get());
    }

    /*
     * @test
     * tests for seeing projects on page work time index
     * */

    public function test_user_can_see_projects_on_work_time_page_related_to_active_work_space()
    {
        //initial user and work space
        $user = $this->registerUserAndCreateWorkSpace();

        $workSpace = $user->workSpaces()->get()->first();

        $this->assertCount(0, Project::all());

        //create number of projects for this work space
        $workSpace->projects()->createMany([
            ['title' => 'test project A',],
            ['title' => 'test project B',],
            ['title' => 'test project C',],
        ]);

        //check if projects are exist
        $this->assertCount(3, Project::all());

        //go to the work time page
        $response = $this->json('get', route('work-time.index'));

        //assert see the projects that have been created
        $response->assertSee('test project A');
        $response->assertSee('test project B');
        $response->assertSee('test project C');
    }

    public function test_user_should_not_see_projects_of_other_work_space_on_active_work_space()
    {
        //initial user and work space
        $user = $this->registerUserAndCreateWorkSpace();

        //get work space that was created
        $firstWorkSpace = $user->workSpaces()->get()->first();

        //create another work space for test
        $secondWorkSpace = $user->addWorkSpace('This is second work space');

        //check if two work spaces are not equal
        $this->assertNotEquals($firstWorkSpace->id, $secondWorkSpace->id);

        //Activate the first work space
        $firstWorkSpace->activate();

        $this->assertCount(0, Project::all());
        //create number of projects for this work space
        $firstWorkSpace->projects()->createMany([
            ['title' => 'test project A',],
            ['title' => 'test project B',],
            ['title' => 'test project C',],
        ]);

        //check if projects are exist
        $this->assertCount(3, Project::all());


        //activating second work space and we should not see the projects of the first work space
        $secondWorkSpace->activate();

        //go to the work time page
        $response = $this->json('get', route('work-time.index'));

        //assert don not see the projects
        $response->assertDontSee('test project A');
        $response->assertDontSee('test project B');
        $response->assertDontSee('test project C');
    }

    public function test_user_can_see_projects_on_work_time_page_related_to_specific_work_space_2()
    {
        $user = $this->login();

        $this->assertCount(0, Tag::all());
        $this->assertCount(0, Project::all());
        $this->assertCount(0, WorkSpace::all());

        $workSpace = WorkSpaceFactory::ownedBy($user)->withTags(3)->withProjects(4)->create();

        // dd(Tag::all());

        $this->assertCount(1, WorkSpace::all());
        $this->assertCount(3, Tag::all());
        $this->assertCount(4, Project::all());

        $response = $this->json('get', route('work-time.index'));
    }

    /*
     * tests for seeing tags on page work time index
     * */
    public function test_user_can_see_tags_on_work_time_page_related_to_active_work_space()
    {
        //initial user and work space
        $user = $this->registerUserAndCreateWorkSpace();

        $workSpace = $user->workSpaces()->get()->first();

        $this->assertCount(0, $workSpace->tags()->get()->all());


        //create number of tags for this work space
        $workSpace->tags()->createMany([
            ['title' => 'test Tag A',],
            ['title' => 'test Tag B',],
            ['title' => 'test Tag C',],
        ]);

        //check if tags are exist
        $this->assertCount(3, $workSpace->tags()->get()->all());

        //go to the work time page
        $response = $this->json('get', route('work-time.index'));

        //assert see the projects that have been created
        $response->assertSee('test Tag A');
        $response->assertSee('test Tag B');
        $response->assertSee('test Tag C');
    }


    public function test_user_should_not_see_tags_of_other_work_space_on_work_time_index_page()
    {
        //initial user and work space
        $user = $this->registerUserAndCreateWorkSpace();

        //get work space that was created
        $firstWorkSpace = $user->workSpaces()->get()->first();

        //create another work space for test
        $secondWorkSpace = $user->addWorkSpace('This is second work space');

        //check if two work spaces are not equal
        $this->assertNotEquals($firstWorkSpace->id, $secondWorkSpace->id);

        //Activate the first work space
        $firstWorkSpace->activate();

        $this->assertCount(0, $firstWorkSpace->tags()->get()->all());
        $this->assertCount(0, $secondWorkSpace->tags()->get()->all());

        //create number of projects for this work space
        $firstWorkSpace->tags()->createMany([
            ['title' => 'test Tag A',],
            ['title' => 'test Tag B',],
            ['title' => 'test Tag C',],
        ]);

        //check if projects are exist
        $this->assertCount(3, $firstWorkSpace->tags()->get()->all());

        //activating second work space and we should not see the projects of the first work space
        $secondWorkSpace->activate();

        //go to the work time page
        $response = $this->json('get', route('work-time.index'));

        //assert don not see the projects
        $response->assertDontSee('test project A');
        $response->assertDontSee('test project B');
        $response->assertDontSee('test project C');
    }

    public function test_user_can_add_title_to_work_time()
    {
        //initial user and work space
        $user = $this->registerUserAndCreateWorkSpace();

        //get work space that was created
        //$workSpace = $user->workSpaces()->get()->first();

        $this->post(route('work-time.start'));

        $this->assertCount(1, WorkTime::all());

        $this->assertCount(1, WorkTime::unCompleted()->get()->all());

        $this->json('post', route('work-time.stop'), [
            'selectBillable' => true,
            'title' => 'title for test',
        ]);

        $this->assertDatabaseHas('work_times', [
            'title' => 'title for test',
            'billable' => true,
        ]);

    }

    public function test_user_can_update_title_of_work_time()
    {
        //initial user and work space
        $user = $this->registerUserAndCreateWorkSpace();

        $this->post(route('work-time.start'));

        $this->json('post', route('work-time.stop'), [
            'selectBillable' => true,
            'title' => 'First title of work time',
        ]);

        $this->json('put', route('work-time-title.update', $user->workTimes()->get()->first()), [
            'title' => 'title has been updated',
        ]);

        $this->assertDatabaseHas('work_times', [
            'title' => 'title has been updated',
        ]);

        $this->assertEquals('title has been updated', $user->workTimes()->get()->first()->title);
    }

    public function test_user_can_update_billable_of_work_time()
    {
        //initial user and work space
        $user = $this->registerUserAndCreateWorkSpace();

        $this->post(route('work-time.start'));

        $this->json('post', route('work-time.stop'), [
            'selectBillable' => true,
            'title' => 'First title of work time',
        ]);

        $this->json('put', route('work-time-billable.update', $user->workTimes()->get()->first()), [
            'billable' => false,
        ]);

        $this->assertDatabaseHas('work_times', [
            'billable' => false,
        ]);
    }

    public function test_user_can_update_project_of_work_time()
    {
        //initial user and work space
        $user = $this->registerUserAndCreateWorkSpace();

        $project = $user->activeWorkSpace()->projects()->create(['title' => 'project A']);

        $newProject = $user->activeWorkSpace()->projects()->create(['title' => 'project for Update']);

        $this->post(route('work-time.start'));

        $this->assertCount(2, Project::all());

        $this->json('post', route('work-time.stop'), [
            'selectBillable' => true,
            'title' => 'title of work time',
            'project_id' => $project->id
        ]);

        $workTime = $user->workTimes()->get()->first();

        $this->assertEquals(1, $workTime->project_id);

        $this->json('put', route('work-time-project.update', $workTime), [
            'projectId' => $newProject->id,
        ]);

        $this->assertDatabaseHas('work_times', [
            'project_id' => 2,
        ]);

        $this->assertEquals(2, $user->workTimes()->get()->first()->project_id);

    }

    public function test_user_can_add_tags_when_work_time_stored()
    {
        $user = $this->registerUserAndCreateWorkSpace();

        $firstTag = $user->activeWorkSpace()->tags()->create(['title' => 'first TAG']);
        $secondTag = $user->activeWorkSpace()->tags()->create(['title' => 'second TAG']);
        $thirdTag = $user->activeWorkSpace()->tags()->create(['title' => 'Third TAG']);

        $this->assertCount(0, WorkTime::all());

        $this->assertCount(3, $user->activeWorkSpace()->tags()->get());

        $this->post(route('work-time.start'));

        $this->post(route('work-time.stop'), [
            'selectBillable' => true,
            'title' => 'title of work time',
            'tags' => [$thirdTag, $firstTag]
        ]);

        $workTime = WorkTime::first();

        $this->assertCount(2, $workTime->tags()->get());
        $this->assertDatabaseHas('work_time_tag', [
            'tag_id' => 1,
        ]);
        $this->assertDatabaseHas('work_time_tag', [
            'tag_id' => 3,
        ]);
        $this->assertDatabaseMissing('work_time_tag', [
            'tag_id' => 2,
        ]);
    }

    public function test_user_can_update_tags_of_work_time()
    {
        $user = $this->registerUserAndCreateWorkSpace();

        $firstTag = $user->activeWorkSpace()->tags()->create(['title' => 'first TAG']);

        $secondTag = $user->activeWorkSpace()->tags()->create(['title' => 'second TAG']);

        $this->assertCount(2, $user->activeWorkSpace()->tags()->get());

        $this->post(route('work-time.start'));

        $this->post(route('work-time.stop'), [
            'selectBillable' => true,
            'title' => 'title of work time',
            'tags' => $firstTag,
        ]);

        $this->assertEquals('first TAG', WorkTime::first()->tags()->get()->first()->title);

        $workTime = WorkTime::first();

        $this->assertDatabaseMissing('work_time_tag', ['tag_id'=> 2 ]);

        $this->json('put', route('work-time-tag.update', $workTime), [
            'tagId' => $secondTag->id,
        ]);

        $this->assertDatabaseHas('work_time_tag', ['tag_id'=> 2 ]);

    }

    public function test_user_can_delete_work_time()
    {
        $user = $this->registerUserAndCreateWorkSpace();

        $firstTag = $user->activeWorkSpace()->tags()->create(['title' => 'first TAG']);

        $this->assertCount(0, WorkTime::all());

        $this->post(route('work-time.start'));

        $this->post(route('work-time.stop'), [
            'selectBillable' => true,
            'title' => 'title of work time',
            'tags' => $firstTag,
        ]);

        $this->assertCount(1, WorkTime::all());

        $this->json('delete', route('work-time.destroy', WorkTime::first()));

        $this->assertCount(0, WorkTime::all());
    }


}
