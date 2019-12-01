<?php

namespace Tests\Feature;

use App\User;
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
    public function password_confirmation_bayad_ba_password_barabar_bashad()
    {
        $this->json('post', '/register', [
            'password' => "Hello World",
            'password_confirmation' => "Bye World",
        ])->assertSee("The password confirmation does not match");
    }

    /** @test */
    public function password_confirmation_barabar_ba_password_ast()
    {
        $this->json('post', '/register', [
            'password' => "Hello World",
            'password_confirmation' => "Hello World",
        ])->assertDontSee("The password confirmation does not match");
    }



    /**
     * A basic feature test example.
     *
     * @return void
     */
    /** @test */
    public function testRegister()
    {
        $user = [
            'name' => 'yadgar',
            'email' => 'yadgar42@test.com',
            'password' => 'passwordtest',
            'password_confirmation' => 'passwordtest',
        ];

        $this->json('post', '/register', $user);

        $this->assertDatabaseHas('users', [
            'name' => 'yadgar',
            'email' => 'yadgar42@test.com',
        ]);

        self::assertCount(1, User::first()->workSpaces);
    }

    public function testWorkSpace()
    {

        $this->assertIsNotResource('work-spaces');

        // $response->assertStatus(200);
    }

    public function testProjects()
    {

        $this->assertIsNotResource('/projects');

        // $response->assertStatus(200);
    }

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
