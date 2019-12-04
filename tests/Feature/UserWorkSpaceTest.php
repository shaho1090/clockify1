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

    public function test_work_space_title_between_3_to_50_character()
    {
        $this->login();
        for ($counter = 3; $counter <= 50; $counter++) {
            $response = $this->post(route('work-spaces.store'), [
                'title' => Str::random($counter),
            ]);
            if (!$response->assertSessionHasNoErrors()) {
                break;
            }

        }
    }

    /*
    * @test
    * */

    public function test_if_title_less_then_3_char()
    {

        $response = $this->post(route('work-spaces.store'), [
            'title' => Str::random(2),
        ]); $this->login();

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

    

}
