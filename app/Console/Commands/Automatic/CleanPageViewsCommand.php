<?php
/*
 * This engine owned and produced by HyipLab studio.
 * Visit our website: https://hyiplab.net/
 */

namespace App\Console\Commands\Automatic;

use App\Models\PageViews;
use Illuminate\Console\Command;

/**
 * Class CleanPageViewsCommand
 * @package App\Console\Commands\Automatic
 */
class CleanPageViewsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'clean:page_views';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clean old page views';

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
        $deleteFrom = now()->subDays(7)->toDateTimeString();

        /** @var PageViews $views */
        $views = PageViews::where('created_at', '<', $deleteFrom)->get();

        /** @var PageViews $view */
        foreach ($views as $view) {
            $this->info('row '.$view->page_url.' deleted');
            $view->delete();
        }
    }
}
