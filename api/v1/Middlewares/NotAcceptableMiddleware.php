<?php

namespace Api\V1\Middlewares;

use Api\V1\Http\Controllers\AuthController;
use Api\V1\Http\Controllers\CategoriesController;
use Api\V1\Http\Controllers\ItemsController;
use Symfony\Component\HttpKernel\Exception\NotAcceptableHttpException;

class NotAcceptableMiddleware
{
    public function handle($request, \Closure $next)
    {
        if (!$this->isBlacklisted($request) && $request->header('accept') !== 'application/json') {
            throw new NotAcceptableHttpException('Not Acceptable');
        }

        $response = $next($request);

        return $response;
    }

    /**
     * @param \Illuminate\Http\Request $request
     *
     * @return bool
     */
    private function isBlacklisted($request)
    {
        $actions = [
            AuthController::class . '@index',

            ItemsController::class . '@delete',
            ItemsController::class . '@update',
            ItemsController::class . '@create',

            CategoriesController::class . '@addItem',
            CategoriesController::class . '@swap',
            CategoriesController::class . '@delete',
            CategoriesController::class . '@update',
            CategoriesController::class . '@createChild',
            CategoriesController::class . '@create',
        ];
        $action = $request->route()->getActionName();

        return in_array($action, $actions);
    }
}
