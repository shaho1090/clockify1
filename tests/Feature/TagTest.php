<?php

namespace Tests\Feature;

use App\Tag;
use App\User;
use App\WorkSpace;
use App\WorkTime;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Str;
use Tests\TestCase;

class TagTest extends TestCase
{
    use refreshDatabase;

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_user_can_store_new_tag()
    {
        $user = $this->registerUserAndCreateWorkSpace();

        $this->assertCount(0, $user->activeWorkSpace()->tags()->get());

        $this->post(route('tags.store'), ['title' => 'tag for test']);

        $this->assertCount(1, $user->activeWorkSpace()->tags()->get());

    }

    public function test_user_can_see_tags_on_index_page_related_to_active_work_space()
    {
        $user = $this->registerUserAndCreateWorkSpace();

        $this->assertCount(0, $user->activeWorkSpace()->tags()->get());

        $this->post(route('tags.store'), ['title' => 'tag for test ONE']);
        $this->post(route('tags.store'), ['title' => 'tag for test TWO']);
        $this->post(route('tags.store'), ['title' => 'tag for test THREE']);

        $this->assertCount(3, $user->activeWorkSpace()->tags()->get());

        $response = $this->json('get', route('tags.index'));

        $response->assertSee('tag for test ONE');
        $response->assertSee('tag for test TWO');
        $response->assertSee('tag for test THREE');
    }

    public function test_user_should_not_see_tags_of_other_work_space_on_tag_index_page()
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
        $response = $this->json('get', route('tags.index'));

        //assert don not see the projects
        $response->assertDontSee('test project A');
        $response->assertDontSee('test project B');
        $response->assertDontSee('test project C');
    }

    public function test_user_can_update_title_of_tag()
    {
        $user = $this->registerUserAndCreateWorkSpace();
        //there is no tags yet
        $this->assertCount(0, $user->activeWorkSpace()->tags()->get());
        //creating tag with title
        $this->post(route('tags.store'), ['title' => 'tag for test']);
        //be sure about creating tag with title
        $this->assertCount(1, $user->activeWorkSpace()->tags()->get());
        //changing title of tag
        $this->json('put', route('tags.update',
            $user->activeWorkSpace()->tags()->get()->first()),
            ['title' => 'title for updating tag']
        );
        //be sure about changing title of tag
        $this->assertEquals('title for updating tag',
            $user->activeWorkSpace()->tags()->get()->first()->title);
    }


    public function test_title_of_tag_should_be_less_than_100_character()
    {
        $this->registerUserAndCreateWorkSpace();

        $this->assertCount(0 , Tag::all());

        $request = $this->post(route('tags.store'),['title' => Str::random(101)]);

        $this->assertCount(0 , Tag::all());

        $request->assertSessionHasErrorsIn('title');
    }

    public function test_title_of_tag_should_be_greater_than_3_character()
    {
        $this->registerUserAndCreateWorkSpace();

        $this->assertCount(0 , Tag::all());

        $request = $this->post(route('tags.store'),['title' => Str::random(2)]);

        $this->assertCount(0 , Tag::all());

        $request->assertSessionHasErrorsIn('title');
    }

    public function test_title_of_tag_should_not_be_empty()
    {
        $this->registerUserAndCreateWorkSpace();

        $this->assertCount(0 , Tag::all());

        $request = $this->post(route('tags.store'),['title' => '']);

        $this->assertCount(0 , Tag::all());

        $request->assertSessionHasErrorsIn('title');
    }

    public function test_user_can_delete_tag()
    {
        $user = $this->registerUserAndCreateWorkSpace();

        $this->assertCount(0, $user->activeWorkSpace()->tags()->get());

        $this->post(route('tags.store'), ['title' => 'tag for test']);

        $this->assertCount(1, $user->activeWorkSpace()->tags()->get());

        $this->delete(route('tags.destroy', $user->activeWorkSpace()->tags()->get()->first()));

        $this->assertCount(0, $user->activeWorkSpace()->tags()->get());
    }

    public function test_removing_work_times_with_deleting_tag()
    {
        $user = $this->registerUserAndCreateWorkSpace();

        $this->assertCount(0, $user->activeWorkSpace()->tags()->get());
        $this->assertCount(1, User::all());
        $this->assertCount(1, WorkSpace::all());

        $firstTag = $user->activeWorkSpace()->tags()->create(['title' => 'tag for test deleting']);
        $secondTag = $user->activeWorkSpace()->tags()->create(['title' => 'a tag for stay']);

        $this->assertCount(2, $user->activeWorkSpace()->tags);

        //creating a work time
        $this->post(route('work-time.start'));
        $this->post(route('work-time.stop'), [
            'selectBillable' => true,
            'title' => 'first work time',
            'tags' => [$firstTag],
        ]);

        $this->assertCount(1, $firstTag->workTimes()->get());

        //creating another work time
        $this->post(route('work-time.start'));
        $this->post(route('work-time.stop'), [
            'selectBillable' => false,
            'title' => 'second work time',
            'tags' => [$secondTag, $firstTag],
        ]);
        //creating third work time
        $this->post(route('work-time.start'));
        $this->post(route('work-time.stop'), [
            'selectBillable' => false,
            'title' => 'second work time',
            'tags' => [],
        ]);

        $this->assertCount(3, $user->activeWorkSpace()->workTimes()->get());

        $this->assertCount(2, $firstTag->workTimes()->get());

        $this->delete(route('tags.destroy', $firstTag));

        $this->assertCount(1, $user->activeWorkSpace()->tags()->get());

        $this->assertSoftDeleted($firstTag);

        $this->assertCount(1, $user->activeWorkSpace()->workTimes()->get());
    }
}
