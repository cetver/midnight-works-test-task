<?php

namespace Api\V1\Middlewares;

use Illuminate\Validation\ValidationException;

class UnprocessableEntityMiddleware
{
    public function handle($request, \Closure $next)
    {
        $response = $next($request);

        $e = $response->exception;
        if ($e instanceof ValidationException) {
            $errors = $e->validator->errors();
            $response->setData(compact('errors'));
            $response->setStatusCode($response::HTTP_UNPROCESSABLE_ENTITY);
        }

        return $response;
    }
}
