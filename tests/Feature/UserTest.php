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
    public function test_password_confirmation_error()
    {
        $this->post('/register', [
            'name' => 'yadgar',
            'email' => 'yadgar42@test.com',
            'password' => 'passwordtest',
            'password_confirmation' => 'Bye World',
        ])->assertSessionHasErrors('password');
    }

    /** @test */
    public function test_password_confirmation_ok()
    {
        $this->post('/register', [
            'name' => 'yadgar',
            'email' => 'yadgar42@test.com',
            'password' => 'passwordtest',
            'password_confirmation' => 'passwordtest',
        ])->assertSessionHasNoErrors();
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



    public function test_user_login()
    {
        $this->post('/register', [
            'name' => 'yadgar',
            'email' => 'yadgar42@test.com',
            'password' => 'passwordtest',
            'password_confirmation' => 'passwordtest',
        ]);

        $this->postJson('/login',[
            'email' => 'yadgar42@test.com',
            'password' => 'passwordtest',
        ])->assertRedirect('/home');
    }
}
