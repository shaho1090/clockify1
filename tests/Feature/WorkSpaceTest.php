<?php

namespace Tests\Feature;

use App\User;
use App\UserWorkSpace;
use App\WorkSpace;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Support\Str;
use Tests\TestCase;

class workSpaceTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_creating_workspace_for_user_just_registered()
    {
        $this->user = $this->post('/register', [
            'name' => 'yadgar',
            'email' => 'yadgar42@test.com',
            'password' => 'passwordtest',
            'password_confirmation' => 'passwordtest',
        ]);

        $this->assertDatabaseHas('users', ['name' => 'yadgar']);
        $this->assertDatabaseHas('work_spaces', ['title' => 'yadgar work space']);
        // self::assertCount(1, $user->workSpaces);
    }

    /*
     * @test
     * */
    public function test_first_user_work_space_is_owner_and_active()
    {
        $this->post('/register', [
            'name' => 'yadgar',
            'email' => 'yadgar42@test.com',
            'password' => 'passwordtest',
            'password_confirmation' => 'passwordtest',
        ]);

        $this->assertDatabaseHas('user_work_space', [
            'access' => 0,
            'active' => true,
        ]);
    }

    /*
     *
     *  @test
     * */
    public function test_user_can_create_work_space()
    {
        $user = $this->login();

        $this->post(route('work-spaces.store'), [
            'title' => 'example work space',
        ]);
        $this->assertCount(1, $user->workSpaces);

        $this->assertDatabaseHas('work_spaces', [
            'title' => 'example work space'
        ]);
    }

    /*
     *
     *  @test
     * */
    public function test_new_work_space_which_created_is_active()
    {
        $user = $this->login();

        $this->json('post',route('work-spaces.store'), [
            'title' => 'example work space',
        ]);

        $this->json('post', route('work-spaces.store'), [
            'title' => 'example work space 2',
        ]);

        $this->assertCount(2, $user->workSpaces);

        $this->assertEquals('1', UserWorkSpace::where('user_id', $user->id)
            ->orderBy('id', 'desc')
            ->get()
            ->first()
            ->active);
        $this->assertEquals('0', UserWorkSpace::where('user_id', $user->id)
            ->orderBy('id', 'asc')
            ->get()
            ->first()
            ->active);


    }
    /*
     * @test
     * */

    public function test_user_can_see_work_spaces_in_index_page()
    {
        $user = $this->login();

        $this->json('post',route('work-spaces.store'), [
            'title' => 'example work space',
        ]);

        $this->json('post', route('work-spaces.store'), [
            'title' => 'example work space 2',
        ]);

        $this->assertCount(2, $user->workSpaces);

        $response = $this->json('get', route('work-spaces.index'));

        $response->assertSee('example work space');

        $response->assertSee('example work space 2');
    }

    /*
     * @test
     * */

    public function test_work_space_title_between_3_to_50_char_when_creating()
    {
        $this->login();

        $stringLength = rand(3, 50);

        $response = $this->post(route('work-spaces.store'), [
            'title' => Str::random($stringLength),
        ]);

        $response->assertSessionHasNoErrors();
    }

    /*
    * @test
    * */

    public function test_if_title_less_then_3_char()
    {
        $this->login();

        $response = $this->post(route('work-spaces.store'), [
            'title' => Str::random(2),
        ]);

        $response->assertSessionHasErrors('title');

        echo $response->getStatusCode();

    }

    /*
     * @test
     * */

    public function test_if_title_greater_then_50_char()
    {
        $this->login();

        $response = $this->post(route('work-spaces.store'), [
            'title' => Str::random(51),
        ]);

        $response->assertSessionHasErrors('title');

        echo $response->getStatusCode();

    }


    /*
     * @test
     * */
    public function test_requirement_of_title_in_work_space_creation()
    {
        $this->login();

        $response = $this->post(route('work-spaces.store'), [
            'title' => ''
        ]);

        $response->assertSessionHasErrors('title');
    }

    /*
        * @test
        * */
    public function test_work_space_title_can_be_updated()
    {
        $user = $this->login();

        $this->post(route('work-spaces.store'), [
            'title' => 'example work space',
        ]);

        $this->put(route('work-spaces.update', $user->workSpaces()->get()->first()->id), [
            'title' => 'test update title',
        ]);

        $this->assertDatabaseHas('work_spaces', [
            'title' => 'test update title'
        ]);
    }

    /*
     * @test
     *
     *  */
    public function test_work_space_update_min_3_char()
    {
        $user = $this->login();

        $this->post(route('work-spaces.store'), [
            'title' => 'example work space',
        ]);

        $response = $this->put(route('work-spaces.update', $user->workSpaces()->get()->first()->id), [
            'title' => 'AB',
        ]);

        $this->assertDatabaseHas('work_spaces', [
            'title' => 'example work space'
        ]);

        $response->assertSessionHasErrors('title');
    }

    /*
     * @test
     * */
    public function test_work_space_update_max_50_char()
    {
        $user = $this->login();

        $this->post(route('work-spaces.store'), [
            'title' => 'example work space',
        ]);

        $response = $this->put(route('work-spaces.update', $user->workSpaces()->get()->first()->id), [
            'title' => Str::random('51'),
        ]);

        $this->assertDatabaseHas('work_spaces', [
            'title' => 'example work space'
        ]);

        $response->assertSessionHasErrors('title');
    }

    /*
     * @test
     * */
    public function test_user_can_change_active_work_space()
    {
        $user = $this->login();

        $this->post(route('work-spaces.store'), [
            'title' => 'example work space',
        ]);

        $this->post(route('work-spaces.store'), [
            'title' => 'example work space 2',
        ]);

        $inActiveUserWorkSpace = UserWorkSpace::where('user_id', '=', $user->id)
            ->where('active', '=', 0)
            ->get()
            ->first();

        $this->post(route('activate-workspace', ['workSpace' => $inActiveUserWorkSpace]));

        $this->assertEquals('1', UserWorkSpace::find($inActiveUserWorkSpace->id)->active);
    }

    /*
     * @test
     * */
    public function test_user_can_not_delete_active_work_space()
    {
        $user = $this->login();

        $workSpace = $user->workSpaces()->create(['title' => 'example for delete']);
        //dd($user->workSpaces()->find($workSpace->id)->pivot->active);

        $this->assertDatabaseHas('work_spaces', ['title' => 'example for delete']);

        $response = $this->delete(route('work-spaces.destroy', ['work_space' => $workSpace->id]));
        //dd($response);
        $response->assertStatus(302);
        $this->assertDatabaseHas('work_spaces', ['title' => 'example for delete']);

    }

    /*
     * @test
     * */

    public function test_user_can_delete_inActive_work_space()
    {
        $user = $this->login();
        // $user = factory(User::class)->create();
        //  $workSpace = factory(WorkSpace::class)->create();
//        $userWorkspace = factory(UserWorkSpace::class, [
//            'user_id' => $user->id,
//            'work_space_id' => $workSpace->id,
//            'access' => 0,
//            'active' => 0,
//
//        ]);

        $workSpace = $user->workSpaces()->create(['title' => 'example for delete']);

        $user->workSpaces()->updateExistingPivot($workSpace->id, ['active' => 0, 'access' => 0]);

        $this->assertDatabaseHas('user_work_space', ['active' => 0]);

        $this->assertEquals(0, $user->workSpaces()->find($workSpace->id)->pivot->active);

        $this->delete(route('work-spaces.destroy', [
            $workSpace->id
        ]));

        $this->assertSoftDeleted('work_spaces', [
            'id' => $workSpace->id
        ]);
    }

    /*
     * @test
     * */
    public function test_user_that_is_not_owner_cant_delete_work_space()
    {
        $user = $this->login();

        $workSpace = $user->workSpaces()->create(['title' => 'example for delete']);

        $user->workSpaces()->updateExistingPivot($workSpace->id, ['active' => 0, 'access' => 1]);

        $this->assertEquals(1, $user->workSpaces()->find($workSpace->id)->pivot->access);

        $response = $this->delete(route('work-spaces.destroy', [
            $workSpace->id
        ]));

        $response->assertStatus(403);

        $this->assertDatabaseHas('work_spaces', ['title' => $workSpace->title]);
    }
}

