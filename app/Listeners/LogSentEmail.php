<?php
/*
 * This engine owned and produced by HyipLab studio.
 * Visit our website: https://hyiplab.net/
 */

namespace App\Listeners;

use App\Models\MailSent;
use App\Models\User;
use Illuminate\Mail\Events\MessageSent;

/**
 * Class LogSentEmail
 * @package App\Listeners
 */
class LogSentEmail
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * @param MessageSent $messageSent
     */
    public function handle(MessageSent $messageSent)
    {
        $message    = $messageSent->message;

        $email      = current(array_keys($messageSent->message->getTo()));
        $text       = $message->getBody();
        $subject    = $messageSent->message->getSubject();
        /** @var User $user */
        $user       = User::where('email', $email)->first();

        if (null === $user) {
            \Log::info('User not found for email log');
        }

        $mailSent = new MailSent();
        $mailSent->text = $text;
        $mailSent->email = $email;
        $mailSent->subject = $subject;
        $mailSent->user()->associate($user);
        $mailSent->save();
    }
}
