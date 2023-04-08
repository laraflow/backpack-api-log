<?php

namespace Laraflow\BackpackApiLog;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use Laraflow\BackpackApiLog\Commands\BackpackApiLogCommand;

class BackpackApiLogServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('backpack-api-log')
            ->hasConfigFile()
            ->hasViews()
            ->hasMigration('create_backpack-api-log_table')
            ->hasCommand(BackpackApiLogCommand::class);
    }
}
