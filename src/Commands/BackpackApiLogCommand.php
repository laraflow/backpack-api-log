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
        try {

            if ($this->confirm('Publish Stub Files', true)) {

                (Artisan::call('vendor:publish', ['--tag' => 'api-log-config', '--provider' => BackpackApiLogServiceProvider::class]) == self::SUCCESS)
                    ? $this->info('Configuration file published.')
                    : $this->error('Configuration file publish failed.');

                (Artisan::call('vendor:publish', ['--tag' => 'api-log-migration', '--provider' => BackpackApiLogServiceProvider::class]) == self::SUCCESS)
                    ? $this->info('Migration file published.')
                    : $this->error('Migration file publish failed.');
            }

            if ($this->confirm('Add Link on Sidebar', true)) {

                Artisan::call('backpack:add-sidebar-content', ['code' => "<li class='nav-item'><a class='nav-link' href='{{ backpack_url('".config('backpack.api-log.route')."') }}' ><i class='nav-icon la la-search'></i> API Logs</a></li>"]);
            }

            return self::SUCCESS;

        } catch (\Exception $exception) {

            $this->error($exception->getMessage());

            return self::FAILURE;

        }
    }
}
