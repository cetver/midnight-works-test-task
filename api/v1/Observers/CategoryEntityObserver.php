<?php

namespace Api\V1\Observers;

use Api\V1\Entities\CategoryEntity;
use Api\V1\Generators\IdGenerator;
use Api\V1\Generators\PublicIdGenerator;

class CategoryEntityObserver
{
    /**
     * Handle the category entity "creating" event.
     *
     * @param CategoryEntity $entity
     *
     * @return void
     * @throws \Exception
     */
    public function creating(CategoryEntity $entity)
    {
        $entity->id = IdGenerator::generate();
        $entity->public_id = PublicIdGenerator::generate();
    }
}
