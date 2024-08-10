<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class SnapshotMail extends Mailable
{
    use Queueable, SerializesModels;

    public $subject;
    public $headerContent;
    public $bodyContent;
    public $reply_to;
    public $reply_name;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($subject, $headerContent, $bodyContent, $reply_to = null,$reply_name = null)
    {
        $this->subject = $subject;
        $this->headerContent = $headerContent;
        $this->bodyContent = $bodyContent;
        $this->reply_to = $reply_to;
        $this->reply_name = $reply_name;
    }
   
    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        if($this->reply_to != null){
            return $this->subject($this->subject)
                    ->replyTo($this->reply_to, $this->reply_name)
                    ->view('emails.general')
                    ->with([
                        'headerContent' => $this->headerContent,
                        'bodyContent' => $this->bodyContent,
                    ]);
        }
        return $this->subject($this->subject)
                    ->view('emails.general')
                    ->with([
                        'headerContent' => $this->headerContent,
                        'bodyContent' => $this->bodyContent,
                    ]);
    }
}
