<?php

namespace Tests\Feature;

use App\Invitee;
use App\Mail\InviteMail;
use App\User;
use App\UserWorkSpace;
use App\WorkSpace;
use App\WorkSpaceInvitee;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;
use function foo\func;

class InviteeTest extends TestCase
{
    use refreshDatabase;

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_user_can_invite_others_to_active_work_space()
    {
        $ownerUser = $this->registerUserAndCreateWorkSpace();

        $this->assertCount(0, Invitee::all());

        $userA = factory(User::class)->create();
        $userB = factory(User::class)->create();

        $this->post(route('invitees.store'), ['email' => $userA->email]);
        $this->post(route('invitees.store'), ['email' => $userB->email]);

        $this->assertCount(2, WorkSpace::find($ownerUser->activeWorkSpace()->id)->invitees()->get());

        $this->assertCount(2, Invitee::all());
    }

    /*
     * test user can see invitees in
     * */
    public function test_user_can_see_invitees_on_members_index_page()
    {
        $ownerUser = $this->registerUserAndCreateWorkSpace();

        $this->assertCount(0, Invitee::all());

        $userA = factory(User::class)->create();
        $userB = factory(User::class)->create();

        $this->post(route('invitees.store'), ['email' => $userA->email]);
        $this->post(route('invitees.store'), ['email' => $userB->email]);

        $response = $this->json('get', route('members.index'));

        $response->assertSee($userA->email);
        $response->assertSee($userB->emial);
    }

    public function test_to_prevent_duplicate_email_when_inserting_invitation_email()
    {
        $ownerUser = $this->registerUserAndCreateWorkSpace();

        $this->assertCount(0, Invitee::all());

        $userA = factory(User::class)->create();

        $this->post(route('invitees.store'), ['email' => $userA->email]);

        $this->assertCount(1, Invitee::all());

        $response = $this->post(route('invitees.store'), ['email' => $userA->email]);

        $this->assertCount(1, Invitee::all());

        $response->assertSessionHas(['status' => 'این ایمیل قبلا در لیست ارسال ثبت شده است!']);
    }

    public function test_to_prevent_inserting_invalid_email_address()
    {
        $ownerUser = $this->registerUserAndCreateWorkSpace();

        $this->assertCount(0, Invitee::all());

        $userA = factory(User::class)->create(['email' => 'invalidemail']);

        $response = $this->post(route('invitees.store'), ['email' => $userA->email]);

        $this->assertCount(0, Invitee::all());

        $response->assertSessionHasErrors(['email']);
    }

    public function test_user_can_send_invitation_email()
    {
        Mail::fake();

        $ownerUser = $this->registerUserAndCreateWorkSpace();

        $this->assertCount(0, Invitee::all());

        $userA = factory(User::class)->create();

        $this->post(route('invitees.store'), ['email' => $userA->email]);

        $this->assertCount(1, Invitee::all());

        $response = $this->json('post', route('send.mail', Invitee::first()));

        $response->assertSessionHas('status', 'ایمیل دعوت نامه با موفقیت ارسال شد!');

        Mail::assertSent(InviteMail::class);

        // $this->assertCount(0, Invitee::all());
    }

    public function test_invitee_can_accept_invitation()
    {
        Mail::fake();

        $ownerUser = $this->registerUserAndCreateWorkSpace();

        $this->assertCount(0, Invitee::all());

        $userA = factory(User::class)->create();

        $this->post(route('invitees.store'), ['email' => $userA->email]);

        $this->assertCount(1, Invitee::all());
        $this->assertCount(1, $ownerUser->activeWorkSpace()->invitees()->get());
        $this->assertEquals(Invitee::first()->email, $userA->email);

        $response = $this->json('post', route('send.mail', Invitee::first()));
        $response->assertSessionHas('status', 'ایمیل دعوت نامه با موفقیت ارسال شد!');

        Mail::assertSent(InviteMail::class, 1);

        $this->actingAs($userA);

        $token = WorkSpaceInvitee::where('work_space_id','=',$ownerUser->activeWorkSpace()->id)
            ->where('invitee_id','=',Invitee::first()->id)->get()->first()->token;

        $response = $this->get(route('accept.invitation',$token ));

        $response->assertSessionHas(['status'=>'از شما بابت قبول دعوت نامه تشکر می کنیم!']);

        $this->assertCount(2, WorkSpace::find($ownerUser->activeWorkSpace()->id)->users()->get());

        $this->assertNotNull($userA->workSpaces()->find($ownerUser->activeWorkSpace()->id)->get());
    }

}
