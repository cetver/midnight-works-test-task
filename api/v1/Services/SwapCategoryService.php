<?php

namespace Api\V1\Services;

use Api\V1\Entities\CategoryEntity;
use Illuminate\Database\Connection;

class SwapCategoryService
{
    /**
     * @var Connection
     */
    private $connection;

    public function __construct(Connection $connection)
    {

        $this->connection = $connection;
    }

    /**
     * @param CategoryEntity $from
     * @param CategoryEntity $to
     *
     * @throws \Throwable
     */
    public function swap(CategoryEntity $from, CategoryEntity $to)
    {
        $this->connection->transaction(function () use ($from, $to) {
            /** @var CategoryEntity $fromClone */
            $fromClone = clone $from;
            $fromName = $from->name;
            $tmpFromName = uniqid(__METHOD__ . '_', true);
            $toName = $to->name;

            $from->name = $tmpFromName;
            $to->name = $fromName;
            $fromClone->name = $toName;

            return $from->save() && $to->save() && $fromClone->save();
        });
    }
}
