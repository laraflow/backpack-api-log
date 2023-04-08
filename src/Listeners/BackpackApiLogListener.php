<?php

namespace Laraflow\BackpackApiLog\Listeners;

use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Http\Client\Events\ConnectionFailed;
use Illuminate\Http\Client\Events\ResponseReceived;
use Illuminate\Http\Client\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Schema;

class BackpackApiLogListener
{
    /**
     * Handle the event.
     *
     * @param  ResponseReceived|ConnectionFailed  $event
     * @return void
     *
     * @throws BindingResolutionException
     */
    public function handle($event)
    {

        /**
         * @var Request $request
         */
        $request = $event->request;

        $apiLog = app()->make(config('backpack.api-log.model'));

        if (Schema::hasTable(config('backpack.api-log'))) {
            $apiLog->host = $request->toPsrRequest()->getUri()->getHost();
            $apiLog->method = $request->method();
            $apiLog->url = $request->url();
            $apiLog->type = $request->header('Content-Type')[0] ?? 'application/x-www-form-urlencoded';
            $apiLog->request_header = $request->headers();
            $apiLog->request_body = $request->data();
            $apiLog->request_object = $request;

            if ($event instanceof ResponseReceived) {
                /**
                 * @var Response $response
                 */
                $response = $event->response ?? null;

                $apiLog->status_code = $response->status();
                $apiLog->status_text = $response->reason();

                $apiLog->response_time = $response->handlerStats()['total_time_us'] ?? 0;
                if ($apiLog->response_time > 0) {
                    $apiLog->response_time = $apiLog->response_time / 1000000.0;
                }

                $apiLog->response_header = $response->headers();
                $apiLog->response_body = $response->body();
                $apiLog->response_object = $response;
            }

            if ($event instanceof ConnectionFailed) {
                $apiLog->status_code = 0;
                $apiLog->status_text = 'Connection Failed';

                $apiLog->response_time = 0;
                $apiLog->response_header = [];
                $apiLog->response_body = [];
                $apiLog->response_object = [];
            }

            $apiLog->save();
        }
    }
}
