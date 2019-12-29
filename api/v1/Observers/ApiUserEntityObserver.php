<?php

namespace Api\V1\Observers;

use Api\V1\Generators\IdGenerator;
use Api\V1\Entities\ApiUserEntity;
use Illuminate\Support\Facades\Hash;

class ApiUserEntityObserver
{
    /**
     * Handle the api user entity "creating" event.
     *
     * @param ApiUserEntity $entity
     *
     * @return void
     * @throws \Exception
     */
    public function creating(ApiUserEntity $entity)
    {
        $entity->id = IdGenerator::generate();
        $entity->password = Hash::make($entity->password);
    }
}
