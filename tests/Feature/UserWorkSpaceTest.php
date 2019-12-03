<?php

namespace Tests\Feature;

use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserWorkSpaceTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testCreateWorkSpaceForUser()
    {
        $this->post('/register', [
            'name' => 'yadgar',
            'email' => 'yadgar42@test.com',
            'password' => 'passwordtest',
            'password_confirmation' => 'passwordtest',
        ]);

        //  $this->assertDatabaseHas('users', ['name' => 'yadgar']);
        $this->assertDatabaseHas('work_spaces', ['title' => 'yadgar']);
        self::assertCount(1, User::first()->workSpaces);
        // $response->assertStatus(200);
    }
}
