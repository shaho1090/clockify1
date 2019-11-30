<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    /** @test */
    public function testRegister()
    {
        //$this->assertTrue(true);
        // $response = $this->post('/projects');

        //  $response->assertStatus(200);
//
        $user = [
            'name' => 'Joe',
            //'last_name' => 'Smith',
            //  'function' => 'Rental Clerk',
            'email' => 'testemail@test.com',
            'password' => 'passwordtest',
            'password_confirmation' => 'passwordtest'
        ];

        $response = $this->post('/register', $user);

        $response
            ->assertRedirect('/home')
            ->assertSessionHas('status', 'Zodra uw account is goedgekeurd ontvangt u een email');

        //Remove password and password_confirmation from array
        array_splice($user, 4, 2);

        $this->assertDatabaseHas('users', $user);

    }

    public function testWorkSpace()
    {

        $this->assertIsNotResource('work-spaces');

       // $response->assertStatus(200);
    }
}
