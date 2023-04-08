<?php

namespace Laraflow\BackpackApiLog;


use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;
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

        $this->loadRoutesFrom(__DIR__ . '/../routes/backpack/api-log.php');

        if ($this->app->runningInConsole()) {
            $this->commands([
                BackpackApiLogCommand::class
            ]);
        }

        $this->registerListener();
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

    /**
     * The register any event listener mappings for the application.
     *
     * @return void
     */
    private function registerListener(): void
    {
        foreach ($this->listen as $event => $listeners) {
            foreach ($listeners as $listener) {
                Event::listen($event, $listener);
            }
        }
    }
}
