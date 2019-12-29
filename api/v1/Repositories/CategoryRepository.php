<?php

namespace Api\V1\Repositories;

use Api\V1\Entities\CategoryEntity;

class CategoryRepository
{
    /**
     * @param string $id
     *
     * @return CategoryEntity
     */
    public function findByPublicId($id)
    {
        return CategoryEntity::where('public_id', $id)->firstOrFail();
    }

    /**
     * @return array
     */
    public function asTree()
    {
        return CategoryEntity::get()->toTree();
    }
}
