<?php

namespace Laraflow\BackpackApiLog\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Model;

/**
 * @property $id
 * @property string $host
 * @property string $method
 * @property string $url
 * @property array $request_header
 * @property array $request_body
 * @property string $type
 * @property int $status_code
 * @property string $status_text
 * @property array $response_header
 * @property float $response_time
 * @property array $response_body
 * @property array $request_object
 * @property array $response_object
 */
class BackpackApiLog extends Model
{
    use CrudTrait;

    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */
    protected $guarded = ['id'];

    protected $casts = [
        'request_header' => 'json',
        'request_body' => 'json',
        'request_object' => 'json',

        'response_header' => 'json',
        'response_body' => 'json',
        'response_object' => 'json',
    ];

    /*
    |--------------------------------------------------------------------------
    | FUNCTIONS
    |--------------------------------------------------------------------------
    */

    public function __construct(array $attributes = [])
    {
        $this->table = config('backpack.api-log.table', parent::getTable());

        parent::__construct($attributes);

    }

    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */

    /*
    |--------------------------------------------------------------------------
    | SCOPES
    |--------------------------------------------------------------------------
    */

    /*
    |--------------------------------------------------------------------------
    | ACCESSORS
    |--------------------------------------------------------------------------
    */

    /*
    |--------------------------------------------------------------------------
    | MUTATORS
    |--------------------------------------------------------------------------
    */
}
