<?php

namespace Api\V1\Middlewares;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ModelNotFoundMiddleware
{
    private const SUFFIX_ENTITY = 'Entity';

    public function handle($request, \Closure $next)
    {
        $response = $next($request);

        $e = $response->exception;
        if ($e instanceof ModelNotFoundException) {
            $entityName = $this->entityName($e);
            throw new NotFoundHttpException("The '$entityName' entity is not found", $e);
        }

        return $response;
    }

    private function entityName(ModelNotFoundException $e)
    {
        $rc = new \ReflectionClass($e->getModel());
        $shortName = $rc->getShortName();
        $pos = strrpos($shortName, self::SUFFIX_ENTITY);
        $len = strlen(self::SUFFIX_ENTITY);

        return substr_replace($shortName, '', $pos, $len);
    }
}
