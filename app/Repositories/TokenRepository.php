<?php

namespace App\Repositories;

use App\Models\Token;

class TokenRepository extends Repository {

    /**
     * Holds the Token Model instance
     *
     * @var Token
     */
    protected $token;

    /**
     * TokenRepository constructor.
     * @param Token $token
     */
    public function __construct(Token $token) {
        $this->token = $token;
    }

    /**
     * Find User Token
     *
     * @param $token
     * @return object
     */
    public function findToken($token) {
        return $this->find('token', $token);
    }

}
