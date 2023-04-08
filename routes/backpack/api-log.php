<?php

/*
|--------------------------------------------------------------------------
| Backpack Api Log Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all the routes that are
| handled by the Backpack Api Log package.
|
*/

use Illuminate\Support\Facades\Route;
use Laraflow\BackpackApiLog\Http\Controllers\BackpackApiLogCrudController;

Route::group([
    'prefix' => config('backpack.base.route_prefix', 'admin'),
    'middleware' => ['web', backpack_middleware()],
], function () {
    Route::crud(config('backpack.api-log.route'), BackpackApiLogCrudController::class);
});

