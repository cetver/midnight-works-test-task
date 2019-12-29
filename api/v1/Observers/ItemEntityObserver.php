<?php

namespace Api\V1\Observers;

use Api\V1\Entities\ItemEntity;
use Api\V1\Generators\IdGenerator;
use Api\V1\Generators\PublicIdGenerator;

class ItemEntityObserver
{
    /**
     * Handle the item entity "creating" event.
     *
     * @param ItemEntity $entity
     *
     * @return void
     * @throws \Exception
     */
    public function creating(ItemEntity $entity)
    {
        $entity->id = IdGenerator::generate();
        $entity->public_id = PublicIdGenerator::generate();
    }
}
