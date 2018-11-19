<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class ContactUsEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $content;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($content)
    {
        $this->content = $content;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('int.marcomm@fiberstar.co.id')
            ->subject("Contacted by ".$this->content->name." via Web Form")
            ->view('mails.contact_message')
            ->text('mails.contact_message_plain');
    }

    //fsjktsmtp01
    //port 25
    //alert@fiberstar.co.id
}
