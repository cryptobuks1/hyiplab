<?php
/*
 * This engine owned and produced by HyipLab studio.
 * Visit our website: https://hyiplab.net/
 */

namespace App\Mail;

use App\Models\Setting;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

/**
 * Class NotificationMail
 * @package App\Mail
 */
class NotificationMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    /** @var int $tries */
    public $tries = 1;

    /** @var string $email */
    protected $email;

    /** @var string $code */
    protected $code;

    /** @var array $data */
    protected $data;

    /**
     * Notification constructor.
     * @param string $email
     * @param string $code
     * @param array|null $data
     */
    public function __construct(string $email, string $code, array $data=null)
    {
        /** @var string $email */
        $this->email    = $email;

        /** @var string data */
        $this->data     = $data;

        /** @var string code */
        $this->code     = $code;
    }

    /**
     * @return NotificationMail|null
     * @throws \Throwable
     */
    public function build()
    {
        $subjectView    = 'mail.'.$this->code.'.subject';
        $bodyView       = 'mail.'.$this->code.'.body';

        if (!view()->exists($subjectView) || !view()->exists($bodyView)) {
            \Log::error('View for mail not found - '.$subjectView.' OR '.$bodyView);
            return null;
        }

        $html = view('mail.'.$this->code.'.body', array_merge([
            'subject' => $this->subject,
        ], $this->data))->render();

        if (empty($html)) {
            return null;
        }

        $from = $this->code == 'support_form'
            ? $this->data['sender_email']
            : Setting::getValue('support-email');

        return $this->from($from)
            ->to($this->email)
            ->subject(isset($this->data['subject'])
                ? $this->data['subject']
                : view($subjectView, array_merge([
                    'subject'   => $this->subject,
            ], $this->data))->render())
            ->view('mail.'.$this->code.'.body', array_merge([
                'subject'   => $this->subject,
            ], $this->data));
    }
}
