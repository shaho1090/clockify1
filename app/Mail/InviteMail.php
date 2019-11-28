<?php

namespace App\Mail;

use App\UserWorkSpace;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use PharIo\Manifest\Email;

class InviteMail extends Mailable
{
    use Queueable, SerializesModels;
    private $workSpaceId ='';
    private $email;

    /**
     * Create a new message instance.
     * @param UserWorkSpace $activeUserWorkSpace
     * @param Email $email
     */
    public function __construct(UserWorkSpace $activeUserWorkSpace, $email)
    {
        $this->workSpaceId = $activeUserWorkSpace->work_space_id;
        $this->email = $email;
    }

    /**
     * Build the message.
     *
     * @param $work_space_id
     * @return $this
     */
    public function build()
    {
        return $this->markdown('members/invite')->with(['workSpaceId' => $this->workSpaceId,
            'email' => $this->email]);

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
