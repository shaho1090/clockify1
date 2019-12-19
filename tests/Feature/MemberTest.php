<?php

namespace Tests\Feature;

use App\Project;
use App\Tag;
use App\User;
use App\WorkSpace;
use App\WorkTime;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
//use Tests\MyFactories\WorkSpaceFactory;
use Tests\TestCase;
use Facades\Tests\MyFactories\WorkSpaceFactory;

class MemberTest extends TestCase
{
    use refreshDatabase;

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_user_can_see_members_of_active_work_space()
    {
        //initial user and work space
        $ownerUser = $this->registerUserAndCreateWorkSpace();

        $userA = factory(User::class)->create();

        $ownerUser->activeWorkSpace()->users()->attach($userA, ['access' => 2]);

        $userB = factory(User::class)->create();

        $ownerUser->activeWorkSpace()->users()->attach($userB, ['access' => 2]);

        $response = $this->json('get', route('members.index'));

        $response->assertSee($userA->name);
        $response->assertSee($userB->name);
        $response->assertSee($ownerUser->name);
    }

    public function test_user_should_not_see_members_of_inActive_work_space()
    {
        //initial user and work space
        $ownerUser = $this->registerUserAndCreateWorkSpace();

        $userA = factory(User::class)->create();

        $ownerUser->activeWorkSpace()->users()->attach($userA, ['access' => 2]);

        $userB = factory(User::class)->create();

        $ownerUser->activeWorkSpace()->users()->attach($userB, ['access' => 2]);

        $ownerUser->addWorkSpace()->activate();

        $response = $this->json('get', route('members.index'));

        $response->assertSee($ownerUser->name);

        $response->assertDontSee($userA->name);
        $response->assertDontSee($userB->name);
    }

    public function test_ordinary_member_can_see_projects_of_work_space_that_invited_in()
    {
        $ownerUser = $this->login();

        $this->assertCount(0, Tag::all());
        $this->assertCount(0, Project::all());
        $this->assertCount(0, WorkSpace::all());

        $workSpace = WorkSpaceFactory::ownedBy($ownerUser)->withTags(3)->withProjects(4)->create();

        $this->assertCount(1, WorkSpace::all());
        $this->assertCount(3, Tag::all());
        $this->assertCount(4, Project::all());

        $ordinaryUser = factory(User::class)->create();

        $ownerUser->activeWorkSpace()->users()->attach($ordinaryUser, ['access' => 2]);

        $this->assertCount(2, $ownerUser->activeWorkSpace()->users()->get());

        $this->actingAs($ordinaryUser);

        $response = $this->json('get', route('projects.index'));
        $response->assertSee(Project::find(1)->title);
        $response->assertSee(Project::find(2)->title);
        $response->assertSee(Project::find(3)->title);
        $response->assertSee(Project::find(4)->title);
    }

    public function test_ordinary_member_can_see_tags_of_work_space_that_invited_in()
    {
        $ownerUser = $this->login();

        $this->assertCount(0, Tag::all());
        $this->assertCount(0, Project::all());
        $this->assertCount(0, WorkSpace::all());

        $workSpace = WorkSpaceFactory::ownedBy($ownerUser)->withTags(3)->withProjects(4)->create();

        $this->assertCount(1, WorkSpace::all());
        $this->assertCount(3, Tag::all());
        $this->assertCount(4, Project::all());

        $ordinaryUser = factory(User::class)->create();

        $ownerUser->activeWorkSpace()->users()->attach($ordinaryUser, ['access' => 2]);

        $this->assertCount(2, $ownerUser->activeWorkSpace()->users()->get());

        $this->actingAs($ordinaryUser);

        $response = $this->json('get', route('tags.index'));
        $response->assertSee(Tag::find(1)->title);
        $response->assertSee(Tag::find(2)->title);
        $response->assertSee(Tag::find(3)->title);

    }

    public function test_ordinary_member_should_not_see_tags_of_other_work_spaces()
    {
        $ownerUser = $this->login();

        $this->assertCount(0, Tag::all());
        $this->assertCount(0, Project::all());
        $this->assertCount(0, WorkSpace::all());

        $workSpaceA = WorkSpaceFactory::ownedBy($ownerUser)->withTags(3)->withProjects(4)->create();
        $workSpaceB = WorkSpaceFactory::ownedBy($ownerUser)->withTags(2)->withProjects(2)->create();

        $this->assertCount(2, WorkSpace::all());
        $this->assertCount(5, Tag::all());
        $this->assertCount(6, Project::all());

        $ordinaryUser = factory(User::class)->create();

        $ownerUser->workSpaces()->find($workSpaceA->id)->users()->attach($ordinaryUser, ['access' => 2]);

        $this->assertCount(2, $ownerUser->workSpaces()->find($workSpaceA->id)->users()->get());


        $this->actingAs($ordinaryUser);
        $this->assertEquals(WorkSpace::find($workSpaceA->id)->title, $ordinaryUser->activeWorkSpace()->title);

        $response = $this->json('get', route('tags.index'));
        $response->assertSee($workSpaceA->tags()->find(1)->title);
        $response->assertSee($workSpaceA->tags()->find(2)->title);
        $response->assertSee($workSpaceA->tags()->find(3)->title);

        $response->assertDontSee($workSpaceB->tags()->find(4)->title);
        $response->assertDontSee($workSpaceB->tags()->find(5)->title);
    }

    public function test_ordinary_member_should_not_see_projects_of_other_work_spaces()
    {
        $ownerUser = $this->login();

        $this->assertCount(0, Tag::all());
        $this->assertCount(0, Project::all());
        $this->assertCount(0, WorkSpace::all());

        $workSpaceA = WorkSpaceFactory::ownedBy($ownerUser)->withTags(2)->withProjects(2)->create();
        $workSpaceB = WorkSpaceFactory::ownedBy($ownerUser)->withTags(3)->withProjects(3)->create();

        $this->assertCount(2, WorkSpace::all());
        $this->assertCount(5, Tag::all());
        $this->assertCount(5, Project::all());

        $ordinaryUser = factory(User::class)->create();

        $ownerUser->workSpaces()->find($workSpaceA->id)->users()->attach($ordinaryUser, ['access' => 2]);

        $this->assertCount(2, $ownerUser->workSpaces()->find($workSpaceA->id)->users()->get());


        $this->actingAs($ordinaryUser);
        $this->assertEquals(WorkSpace::find($workSpaceA->id)->title, $ordinaryUser->activeWorkSpace()->title);

        $response = $this->json('get', route('projects.index'));
        $response->assertSee($workSpaceA->projects()->find(1)->title);
        $response->assertSee($workSpaceA->projects()->find(2)->title);

        $response->assertDontSee($workSpaceB->projects()->find(3)->title);
        $response->assertDontSee($workSpaceB->projects()->find(4)->title);
        $response->assertDontSee($workSpaceB->projects()->find(5)->title);
    }

    public function test_ordinary_member_can_start_work_time()
    {
        $ownerUser = $this->login();

        $workSpaceA = WorkSpaceFactory::ownedBy($ownerUser)->withTags(2)->withProjects(2)->create();

        $ordinaryUser = factory(User::class)->create();

        $ownerUser->workSpaces()->find($workSpaceA->id)->users()->attach($ordinaryUser, ['access' => 2]);

        $this->assertCount(2, $ownerUser->workSpaces()->find($workSpaceA->id)->users()->get());

        $this->actingAs($ordinaryUser);

        $this->assertCount(0, $ordinaryUser->workTimes()->unCompleted()->get());

        $this->post(route('work-time.start'));

        $this->assertCount(1, WorkTime::all());

        $this->assertCount(1, $ordinaryUser->workTimes()->unCompleted()->get());

    }

    public function test_ordinary_member_can_stop_work_time()
    {
        $ownerUser = $this->login();

        $workSpaceA = WorkSpaceFactory::ownedBy($ownerUser)->withTags(2)->withProjects(2)->create();

        $ordinaryUser = factory(User::class)->create();

        $ownerUser->workSpaces()->find($workSpaceA->id)->users()->attach($ordinaryUser, ['access' => 2]);

        $this->assertCount(2, $ownerUser->workSpaces()->find($workSpaceA->id)->users()->get());

        $this->actingAs($ordinaryUser);

        $this->assertCount(0, WorkTime::all());
        $this->post(route('work-time.start'));
        $this->assertCount(1, WorkTime::all());

        $this->json('post', route('work-time.stop', [
            'selectBillable' => true,
            'title' => 'work time for test']));

        $this->assertCount(1, $ordinaryUser->workTimes()->completed()->get());

        $this->assertEquals('work time for test', $ordinaryUser->workTimes()->get()->first()->title);
    }

    public function test_ordinary_member_can_see_his_work_times_on_work_time_index_page()
    {
        $ownerUser = $this->login();

        $workSpaceA = WorkSpaceFactory::ownedBy($ownerUser)->withTags(2)->withProjects(2)->create();

        $ordinaryUser = factory(User::class)->create();

        $ownerUser->workSpaces()->find($workSpaceA->id)->users()->attach($ordinaryUser, ['access' => 2]);

        $this->assertCount(2, $ownerUser->workSpaces()->find($workSpaceA->id)->users()->get());

        $this->actingAs($ordinaryUser);

        $this->assertCount(0, $ordinaryUser->workTimes()->completed()->get());

        $this->post(route('work-time.start'));
        $this->json('post', route('work-time.stop', [
            'selectBillable' => true,
            'title' => 'work time one']));

        $this->assertCount(1, $ordinaryUser->workTimes()->completed()->get());

        $this->post(route('work-time.start'));
        $this->json('post', route('work-time.stop', [
            'selectBillable' => false,
            'title' => 'work time two']));

        $this->assertCount(2, $ordinaryUser->workTimes()->completed()->get());

        $response = $this->json('get', route('work-time.index'));

        $response->assertSee('work time one');
        $response->assertSee('work time two');
    }

    public function test_ordinary_member_can_update_the_title_of_work_time()
    {
        $ownerUser = $this->login();

        $workSpaceA = WorkSpaceFactory::ownedBy($ownerUser)->withTags(2)->withProjects(2)->create();

        $ordinaryUser = factory(User::class)->create();

        $ownerUser->workSpaces()->find($workSpaceA->id)->users()->attach($ordinaryUser, ['access' => 2]);

        $this->assertCount(2, $ownerUser->workSpaces()->find($workSpaceA->id)->users()->get());

        $this->actingAs($ordinaryUser);

        $this->assertCount(0, $ordinaryUser->workTimes()->completed()->get());

        $this->post(route('work-time.start'));
        $this->json('post', route('work-time.stop', [
            'selectBillable' => true,
            'title' => 'work time one']));

        $this->assertCount(1, $ordinaryUser->workTimes()->completed()->get());

        $this->json('put', route('work-time-title.update', $ordinaryUser->workTimes()->get()->first()),
            ['title' => 'title has been updated']);

        $this->assertDatabaseHas('work_times', [
            'title' => 'title has been updated',
        ]);

        $this->assertEquals('title has been updated', $ordinaryUser->workTimes()->get()->first()->title);
    }

    public function test_ordinary_member_can_update_the_tags_of_his_work_time()
    {
        $ownerUser = $this->login();

        $workSpaceA = WorkSpaceFactory::ownedBy($ownerUser)->withTags(3)->withProjects(2)->create();

        $ordinaryUser = factory(User::class)->create();

        $ownerUser->workSpaces()->find($workSpaceA->id)->users()->attach($ordinaryUser, ['access' => 2]);

        $this->assertCount(2, $ownerUser->workSpaces()->find($workSpaceA->id)->users()->get());

        $this->actingAs($ordinaryUser);

        $this->assertCount(0, $ordinaryUser->workTimes()->completed()->get());

        $this->post(route('work-time.start'));
        $this->json('post', route('work-time.stop', [
            'selectBillable' => true,
            'title' => 'work time one',
            'tags' => [$workSpaceA->tags()->find(1)->id],
        ]));

        $this->assertCount(1, $ordinaryUser->workTimes()->completed()->get());

        $this->assertEquals($workSpaceA->tags()->find(1)->title, $ordinaryUser->workTimes()->find(1)->tags()->get()->first()->title);

        $this->json('put', route('work-time-tag.update', $ordinaryUser->workTimes()->first()), [
            'tagId' => $workSpaceA->tags()->find(2)->id,
        ]);

        $this->assertEquals($workSpaceA->tags()->find(2)->title, $ordinaryUser->workTimes()->find(1)->tags()->find(2)->title);

        $this->assertEquals('title has been updated', $ordinaryUser->workTimes()->get()->first()->title);
    }

}
