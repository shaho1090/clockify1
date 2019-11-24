<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class InviteMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('members/invite');

        //        $data = array(
//            'workSpaceId' => $workSpaceId,
//            'uniqid' => $request->get('project_id'),
//            'email' => $request->get('email'),
//        );
//        Mail::send( 'contributors/welcome',$data, function ($message) use ($email) {
//            $message->from('laravelshaho@gmail.com', 'project manager');
//            $message->to( $email)->subject('دعوت به همکاری در پروژه');
//        });
//        return "Your email has been sent successfully";

    }
}
