<?php

namespace Api\V1\Generators;

use Webpatser\Uuid\Uuid;

class IdGenerator implements StringGeneratorInterface
{
    /**
     * @inheritDoc
     * @throws \Exception
     */
    public static function generate()
    {
        return Uuid::generate(4)->string;
    }
}
