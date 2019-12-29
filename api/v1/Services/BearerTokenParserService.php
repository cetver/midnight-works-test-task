<?php

namespace Api\V1\Services;

use Api\V1\Items\AuthCredentialsItem;
use Illuminate\Http\Request;

class BearerTokenParserService
{
    /**
     * @var Request
     */
    private $request;

    public function __construct(Request $request)
    {

        $this->request = $request;
    }

    public function credentials()
    {
        $token = base64_decode($this->request->bearerToken(), true);
        $parts = explode(':', $token);
        $username = $parts[0] ?? null;
        $password = $parts[1] ?? null;

        return new AuthCredentialsItem($username, $password);
    }
}
