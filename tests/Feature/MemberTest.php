<?php

namespace Tests\Feature;

use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

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

    
}
