<?php

namespace Api\V1\Providers;

use Api\V1\Console\Commands\CreateSwaggerSpecification;
use Api\V1\Entities\ApiUserEntity;
use Api\V1\Entities\CategoryEntity;
use Api\V1\Entities\ItemEntity;
use Api\V1\Observers\ApiUserEntityObserver;
use Api\V1\Observers\CategoryEntityObserver;
use Api\V1\Observers\ItemEntityObserver;
use Illuminate\Support\ServiceProvider;

class ApiServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {

    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'api-v1');
        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');
        $this->registerConsoleCommands();
        $this->registerObservers();
    }

    private function registerObservers()
    {
        ApiUserEntity::observe(ApiUserEntityObserver::class);
        ItemEntity::observe(ItemEntityObserver::class);
        CategoryEntity::observe(CategoryEntityObserver::class);
    }

    private function registerConsoleCommands()
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                CreateSwaggerSpecification::class,
            ]);
        }
    }
}
