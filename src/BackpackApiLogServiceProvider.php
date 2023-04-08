<?php

namespace Laraflow\BackpackApiLog;


use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Http\Client\Events\ConnectionFailed;
use Illuminate\Http\Client\Events\ResponseReceived;
use Laraflow\BackpackApiLog\Listeners\BackpackApiLogListener;
use Laraflow\BackpackApiLog\Commands\BackpackApiLogCommand;

class BackpackApiLogServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        ResponseReceived::class => [
            BackpackApiLogListener::class,
        ],
        ConnectionFailed::class => [
            BackpackApiLogListener::class,
        ],
    ];
    /**
     * Bootstrap any package services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes(
            [__DIR__ . '/../config/backpack/api-log.php' => config_path('backpack/api-log.php')],
        'api-log-config'
        );

        $this->publishes(
            [__DIR__ . '/../database/migrations' => database_path('migrations')],
        'api-log-migration'
        );

        $this->loadRoutesFrom(__DIR__.'/../routes/api-log.php');

        if ($this->app->runningInConsole()) {
            $this->commands([
                BackpackApiLogCommand::class
            ]);
        }
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__ . '/../config/backpack/api-log.php', 'backpack.api-log'
        );
    }
}
