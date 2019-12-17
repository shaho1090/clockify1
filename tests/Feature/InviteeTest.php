<?php

namespace Tests\Feature;

use App\Invitee;
use App\Mail\InviteMail;
use App\User;
use App\WorkSpace;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
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

    public function test_preventing_duplicate_email()
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

    public function test_user_can_send_invitation_email()
    {
        Mail::fake();

        $ownerUser = $this->registerUserAndCreateWorkSpace();

        $this->assertCount(0, Invitee::all());

        $userA = factory(User::class)->create();

        $this->post(route('invitees.store'), ['email' => $userA->email]);

        $this->assertCount(1, Invitee::all());

        //  $response = Mail::to(Invitee::first()->email)->send(new InviteMail($ownerUser->activeWorkSpace(), Invitee::first()->email));
        //Mail::assertSent(InviteMail::class, function (){}

        $response = $this->json('post',route('send.mail', Invitee::first()));

        $response->assertSessionHas('status', 'ایمیل دعوت نامه با موفقیت ارسال شد!');

        Mail::assertSent(InviteMail::class);

       // $this->assertCount(0, Invitee::all());
    }

    public function test_user_has_invitation_link_in_his_own_email()
    {
        Mail::fake();

        $ownerUser = $this->registerUserAndCreateWorkSpace();

        $this->assertCount(0, Invitee::all());

        $userA = factory(User::class)->create();

        $this->post(route('invitees.store'), ['email' => $userA->email]);

        $this->assertCount(1, Invitee::all());

        $response = $this->json('post',route('send.mail', Invitee::first()));

        $response->assertSessionHas('status', 'ایمیل دعوت نامه با موفقیت ارسال شد!');

        Mail::assertSent(InviteMail::class, 1);

        Mail::shouldReceive('get.back'.'/'.$ownerUser->activeWorkSpace().'/'.Invitee::first());
    }

    public function test_invitee_can_accept_invitation()
    {
        Mail::fake();

        $ownerUser = $this->registerUserAndCreateWorkSpace();

        $this->assertCount(0, Invitee::all());

        $userA = factory(User::class)->create();

        $this->post(route('invitees.store'), ['email' => $userA->email]);

        $this->assertCount(1, Invitee::all());

        // $response = Mail::to(Invitee::first()->email)->send(new InviteMail($ownerUser->activeWorkSpace(), Invitee::first()->email));
        //Mail::assertSent(InviteMail::class, function (){}

        $response = $this->json('post',route('send.mail', Invitee::first()));

        $response->assertSessionHas('status', 'ایمیل دعوت نامه با موفقیت ارسال شد!');

        Mail::assertSent(InviteMail::class, 1);
    }

}
