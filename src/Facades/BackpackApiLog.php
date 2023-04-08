<?php

namespace Laraflow\BackpackApiLog\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Laraflow\BackpackApiLog\BackpackApiLog
 */
class BackpackApiLog extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \Laraflow\BackpackApiLog\BackpackApiLog::class;
    }
}
