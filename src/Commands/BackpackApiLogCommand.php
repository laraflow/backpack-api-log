<?php

namespace Laraflow\BackpackApiLog\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Laraflow\BackpackApiLog\BackpackApiLogServiceProvider;

class BackpackApiLogCommand extends Command
{
    public $signature = 'backpack-api-log:install';

    public $description = 'This command will run actions required';

    public function handle(): int
    {
        $progressBar = $this->output->createProgressBar(4);
        $progressBar->minSecondsBetweenRedraws(0);
        $progressBar->maxSecondsBetweenRedraws(120);
        $progressBar->setRedrawFrequency(1);
        $progressBar->start();

        try {

            if ($this->confirm('Publish Stub Files', true)) {
                Artisan::call('vendor:publish', ['--tag' => 'api-log-config', '--provider' => BackpackApiLogServiceProvider::class]);
                Artisan::call('vendor:publish', ['--tag' => 'api-log-migration', '--provider' => BackpackApiLogServiceProvider::class]);
            }

            if ($this->confirm('Add Link on Sidebar', true)) {

                Artisan::call('backpack:add-sidebar-content', ['code' => "<li class='nav-item'><a class='nav-link' href='{{ backpack_url('" . config('backpack.api-log.route') . "') }}' ><i class='nav-icon la la-search'></i> API Logs</a></li>"]);
            }

            $progressBar->finish();

            return self::SUCCESS;

        } catch (\Exception $exception) {

            $this->error($exception->getMessage());

            return self::FAILURE;

        }
    }
}
