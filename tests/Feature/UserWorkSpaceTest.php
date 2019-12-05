<?php

namespace Tests\Feature;

use App\User;
use App\UserWorkSpace;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Support\Str;
use Tests\TestCase;

class UserWorkSpaceTest extends TestCase
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
        $this->assertDatabaseHas('work_spaces', ['title' => 'yadgar']);
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
     * @test
     * */

    public function test_work_space_title_between_3_to_50_char_when_creating()
    {
        $this->login();

//        for ($counter = 3; $counter <= 50; $counter++) {
//            $response = $this->post(route('work-spaces.store'), [
//                'title' => Str::random($counter),
//            ]);
//            if (!$response->assertSessionHasNoErrors()) {
//                break;
//            }
//        }

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
    public function test_work_space_title_can_updated()
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


}
