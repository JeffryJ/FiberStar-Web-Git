<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class UserInviteEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $invite;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($invite)
    {
        $this->invite = $invite;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('int.marcomm@fiberstar.co.id')
            ->subject("Web Management Invitation")
            ->view('mails.invitation')
            ->text('mails.invitation_plain');
    }

    //fsjktsmtp01
    //port 25
    //alert@fiberstar.co.id
}
