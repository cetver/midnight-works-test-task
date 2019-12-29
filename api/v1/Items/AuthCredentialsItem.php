<?php

namespace Api\V1\Items;

use Illuminate\Contracts\Support\Arrayable;

class AuthCredentialsItem implements Arrayable
{
    private $login;
    private $password;

    /**
     * AuthCredentialsItem constructor.
     *
     * @param string $login
     * @param string $password
     */
    public function __construct($login, $password)
    {
        $this->login = $login;
        $this->password = $password;
    }

    /**
     * @inheritDoc
     */
    public function toArray()
    {
        return [
            'login' => $this->login,
            'password' => $this->password
        ];
    }
}
