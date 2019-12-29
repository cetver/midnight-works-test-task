<?php

namespace Api\V1\Services;

use Api\V1\Items\AuthCredentialsItem;
use Api\V1\Items\JwtTokenItem;
use Illuminate\Auth\AuthManager;
use Illuminate\Validation\UnauthorizedException;

class JwtTokenService
{
    /**
     * @var AuthManager|\Tymon\JWTAuth\JWTGuard $authManager
     */
    private $authManager;

    /**
     * JwtTokenService constructor.
     *
     * @param AuthManager $authManager
     */
    public function __construct(AuthManager $authManager)
    {
        $this->authManager = $authManager;
    }

    public function item(AuthCredentialsItem $credentials)
    {
        $accessToken = $this->authManager->attempt($credentials->toArray());
        if (!$accessToken) {
            throw new UnauthorizedException('Unauthorized');
        }

        return new JwtTokenItem(
            $accessToken,
            'bearer',
            $this->authManager->factory()->getTTL() * 60
        );
    }
}
