<?php

namespace Api\V1\Entities;

use Illuminate\Foundation\Auth\User;
use Tymon\JWTAuth\Contracts\JWTSubject;

/**
 * Class ApiUserEntity
 *
 * @package Api\V1\Entities
 *
 * @property string $id
 * @property string $login
 * @property string $password
 */
class ApiUserEntity extends User implements JWTSubject
{
    protected $table = 'users';
    protected $fillable = ['id', 'login', 'password'];
    public $timestamps = false;

    public function getIncrementing()
    {
        return false;
    }

    public function getKeyType()
    {
        return 'string';
    }

    /**
     * @inheritDoc
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * @inheritDoc
     */
    public function getJWTCustomClaims()
    {
        return [];
    }
}
