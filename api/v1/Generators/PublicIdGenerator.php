<?php

namespace Api\V1\Generators;

class PublicIdGenerator implements StringGeneratorInterface
{
    /**
     * @inheritDoc
     */
    public static function generate()
    {
        return substr(IdGenerator::generate(), 0, 7);
    }
}
