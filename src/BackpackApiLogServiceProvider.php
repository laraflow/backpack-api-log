<?php

namespace Laraflow\BackpackApiLog;


use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Http\Client\Events\ConnectionFailed;
use Illuminate\Http\Client\Events\ResponseReceived;
use Laraflow\BackpackApiLog\Listeners\ApiLogListener;
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
            ApiLogListener::class,
        ],
        ConnectionFailed::class => [
            ApiLogListener::class,
        ],
    ];
    /**
     * Bootstrap any package services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([__DIR__ . '/../config/backpack/api-log.php' => config_path('backpack/api-log.php'),]);

//        $this->loadTranslationsFrom(__DIR__ . '/../lang', 'form');

//        $this->publishes([
//            __DIR__ . '/../lang' => $this->app->langPath('vendor/form'),
//        ]);

        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'generator');

        $this->publishes([
            __DIR__ . '/../resources/views' => resource_path('views/vendor/generator'),
        ]);

        $this->loadRoutesFrom(__DIR__ . '/../routes/web.php');

        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');

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
