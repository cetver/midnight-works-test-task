<?php

namespace Api\V1\Repositories;

use Api\V1\Entities\ItemEntity;

class ItemRepository
{
    /**
     * @param string $id
     *
     * @return ItemEntity
     */
    public function findByPublicId($id)
    {
        return ItemEntity::where('public_id', $id)->firstOrFail();
    }
}
