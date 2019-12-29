<?php

use Api\V1\Http\Controllers\DefaultController;
use Illuminate\Support\Facades\Route;

Route::get('/', DefaultController::class . '@docs');
