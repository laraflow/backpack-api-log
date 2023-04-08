<?php

namespace Laraflow\BackpackApiLog\Commands;

use Illuminate\Console\Command;

class BackpackApiLogCommand extends Command
{
    public $signature = 'backpack-api-log';

    public $description = 'My command';

    public function handle(): int
    {
        $this->comment('All done');

        return self::SUCCESS;
    }
}
