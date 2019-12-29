<?php

namespace Api\V1\Providers;

use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends \Illuminate\Foundation\Support\Providers\RouteServiceProvider
{
    const ROUTE_PREFIX_API = '/api/v1';

    /**
     * Define the routes for the application.
     *
     * @return void
     */
    public function map()
    {
        $this->mapApiRoutes();
        $this->mapWebRoutes();
    }

    private function mapWebRoutes()
    {
        Route::middleware('web')
             ->namespace($this->namespace)
             ->group(__DIR__ . '/../routes/web.php');
    }

    private function mapApiRoutes()
    {
        Route::prefix(self::ROUTE_PREFIX_API)
             ->middleware('api')
             ->namespace($this->namespace)
             ->group(__DIR__ . '/../routes/api.php');
    }
}
