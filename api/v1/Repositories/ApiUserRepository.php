<?php

namespace Api\V1\Repositories;

use Api\V1\Entities\ApiUserEntity;

class ApiUserRepository
{
    /**
     * @param $login
     *
     * @return ApiUserEntity
     */
    public function findByLogin($login)
    {
        return ApiUserEntity::where('login', $login)->findOrFail();
    }
}
