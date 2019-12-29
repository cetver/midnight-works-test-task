<?php

namespace Api\V1\Http\Controllers;

use Illuminate\Config\Repository;
use Illuminate\Contracts\View\Factory;
use Illuminate\Routing\Controller;

class DefaultController extends Controller
{
    public function docs(Factory $viewFactory, Repository $configRepository)
    {
        return $viewFactory->make('api-v1::default/docs', [
            'url' => $configRepository->get('api-v1.swagger.url')
        ]);
    }
}
