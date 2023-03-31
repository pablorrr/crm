<?php

namespace App\Mail;


use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Http\Request;

//class SendEmail extends Mailable implements ShouldQueue
class SendTaskEmail extends Mailable
{
    use Queueable, SerializesModels;


    public $request;

    /**
     * Create a new message instance.
     * @return void
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }


    /**
     * Get the message envelope.
     *
     * @return \Illuminate\Mail\Mailables\Envelope
     *
     * https://stitcher.io/blog/php-8-named-arguments
     * nowy wyglad klasy od laravel 9 (php 8)
     * https://www.youtube.com/watch?v=h7oDAViX90M
     * https://github.com/laravel/framework/pull/44462
     * argument nazwany od php 8  subject: 'Send Email',
     *
     * https://blog.templid.com/5/advanced-transactional-emails-sending-in-laravel-9/?gclid=Cj0KCQiArsefBhCbARIsAP98hXQZz767Sqdyg0O2gpd6ywjM1yE01FJ5Xmc7q-9MgSC4BxZ-wbZY0EYaAg5UEALw_wcB
     *
     * metoda envelope obsluguje from i subject
     *
     */
    public function envelope()
    {
        return new Envelope(
            subject: 'Masz nowe zadanie',
            from: auth()->user()->email,
        );
    }

    /**
     * Get the message content definition.
     *
     * @return \Illuminate\Mail\Mailables\Content
     *
     *  metoda content obsluguje  view
     */
    public function content()
    {
        return new Content(
            view: 'crm.mail.mail-task',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array
     *
     * obsluguje zalczaniki
     */
    public function attachments()
    {
        return [];
    }
}
