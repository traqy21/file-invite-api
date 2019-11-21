<?php

namespace App\Services;

use App\Repositories\TokenRepository as Repository;

class TokenService extends Service {

    public function __construct(Repository $repository) {
        $this->repository = $repository;
    }

    public function findToken($token) {
        $tokenObj = $this->repository->findToken($token);

        if ($tokenObj) {
            if ($tokenObj->expired) {
                return (object) [
                            "status" => 419,
                            "message" => __('messages.user.token.419'),
                            "token" => null
                ];
            }

            return (object) [
                        "status" => 200,
                        "message" => null,
                        "token" => $tokenObj,
            ];
        }

        return (object) [
                    "status" => 404,
                    "message" => __('messages.user.token.404')
        ];
    }

}
