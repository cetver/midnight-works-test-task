<?php

namespace Api\V1\Items;

use Illuminate\Contracts\Support\Arrayable;

class JwtTokenItem implements Arrayable
{
    /**
     * @var string
     */
    private $accessToken;
    /**
     * @var string
     */
    private $tokenType;
    /**
     * @var int
     */
    private $expiresIn;

    /**
     * JwtTokenItem constructor.
     *
     * @param string $accessToken
     * @param string $tokenType
     * @param int $expiresIn
     */
    public function __construct($accessToken, $tokenType, $expiresIn)
    {

        $this->accessToken = $accessToken;
        $this->tokenType = $tokenType;
        $this->expiresIn = $expiresIn;
    }

    public function toArray()
    {
        return [
            'access_token' => $this->accessToken,
            'token_type' => $this->tokenType,
            'expires_in' => $this->expiresIn,
        ];
    }
}
