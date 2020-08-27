<?php
/*
 * This engine owned and produced by HyipLab studio.
 * Visit our website: https://hyiplab.net/
 */

namespace App\Console\Commands\Automatic;

use App\Models\MailSent;
use Carbon\Carbon;
use Illuminate\Console\Command;

/**
 * Class CleanSentMailsCommand
 * @package App\Console\Commands\Automatic
 */
class CleanSentMailsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'clean:sent_mails';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clean old sent emails';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @throws \Throwable
     */
    public function handle()
    {
        $deleteFrom = Carbon::now()->subDays(7)->toDateTimeString();

        /** @var MailSent $mails */
        $mails = MailSent::where('created_at', '<', $deleteFrom)->get();

        /** @var MailSent $mail */
        foreach ($mails as $mail) {
            $this->info('mail with subject '.$mail->subject.' deleted');
            $mail->delete();
        }
    }
}
