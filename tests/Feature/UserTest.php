<?php

namespace Tests\Feature;

use App\User;
use Faker\Factory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Session;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function name_field_is_required()
    {
        $this->json('post', '/register')->assertSee("The name field is required");
    }

    /** @test */
    public function email_field_is_required()
    {
        $this->json('post', '/register')->assertSee("The email field is required");
    }

    /** @test */
    public function test_if_password_confirmation_not_same_as()
    {
        $this->json('post', '/register', [
            'password' => "Hello World",
            'password_confirmation' => "Bye World",
        ])->assertSee("The password confirmation does not match");
    }

    /** @test */
    public function test_if_password_confirmation_the_same_as()
    {
        $this->json('post', '/register', [
            'password' => "Hello World",
            'password_confirmation' => "Hello World",
        ])->assertDontSee("The password confirmation does not match");
    }

    /** @test */
    public function test_if_email_duplicate()
    {
        factory(User::class)->create([
            'email' => 'shaho.parvini@gmail.com',
        ]);
        $this->json('post', '/register', [
            'name' => "dsajkfhjasdfhj",
            'email' => "shaho.parvini@gmail.com",
        ])->assertSee('The email has already been taken.');
    }
    /**
     * A basic feature test example.
     *
     * @return void
     */
    /** @test */
    public function testRegister()
    {
        $this->json('post', '/register', [
            'name' => 'yadgar',
            'email' => 'yadgar42@test.com',
            'password' => 'passwordtest',
            'password_confirmation' => 'passwordtest',
        ]);

        $this->assertDatabaseHas('users', [
            'name' => 'yadgar',
            'email' => 'yadgar42@test.com',
        ]);

        //self::assertCount(1, User::first()->workSpaces());
    }

    public function testWorkSpace()
    {


        $this->postJson('/workspaces', [
            'title' => 'yadgar'
        ]);

         $this->assertDatabaseHas('work_spaces', ['title' => 'yadgar']);
        //  $this->assertIsNotResource('work-spaces');

        // $response->assertStatus(200);
    }

//    public function testProjects()
//    {
//
//        $this->assertIsNotResource('/projects');
//
//        // $response->assertStatus(200);
//    }

//    public function testUserAndWorkSpace()
//    {
//        //arrange
//        //user can register
//        $user = User::create([
//            'name' => 'yadgar',
//            'email' => 'yadgar42@yahoo.com',
//            'password' => 'passwordforyadgar',
//        ]);
//
//        //act
//        //go to the home
//
//        //assert
//        //see the workspace
//
//    }
}
