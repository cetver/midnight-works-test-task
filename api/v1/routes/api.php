<?php

use Api\V1\Http\Controllers\AuthController;
use Api\V1\Http\Controllers\CategoriesController;
use Api\V1\Http\Controllers\ItemsController;
use Illuminate\Support\Facades\Route;

Route::group(
    [
        'middleware' => 'api',
        'prefix' => 'auth'

    ],
    function () {
        Route::post('/', AuthController::class . '@index');
    }
);

Route::group(
    ['middleware' => 'api',],
    function () {
        Route::post('/item', ItemsController::class . '@create');
        Route::get('/item/{public_id}', ItemsController::class . '@view');
        Route::patch('/item/{public_id}', ItemsController::class . '@update');
        Route::delete('/item/{public_id}', ItemsController::class . '@delete');

        Route::post('/category', CategoriesController::class . '@create');
        Route::get('/category', CategoriesController::class . '@list');
        Route::get('/category/{public_id}', CategoriesController::class . '@view');
        Route::post('/category/{public_id}', CategoriesController::class . '@createChild');
        Route::patch('/category/{public_id}', CategoriesController::class . '@update');
        Route::delete('/category/{public_id}', CategoriesController::class . '@delete');
        Route::put('/category/{public_id}', CategoriesController::class . '@swap');

        Route::post('/category/{public_id}/item', CategoriesController::class . '@addItem');
        Route::get('/category/{public_id}/item', CategoriesController::class . '@getItems');
    }
);
