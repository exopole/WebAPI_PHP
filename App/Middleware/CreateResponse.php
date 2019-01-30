<?php

namespace Middleware;

use Kernel\Controller;

class CreateResponse
{

    public function __invoke($request,  $response, $next)
    {
        $response = $next($request, $response);
        $newResponse = $response->withHeader('Content-type', 'application/json');
        $newResponse->write(json_encode(['messages'=>\Models\Message::get(),'content'=>Controller::getContent()]));

        return $newResponse;
    }
}