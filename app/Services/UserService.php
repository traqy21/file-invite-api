<?php

namespace App\Services;

use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use Firebase\JWT\JWT;

class UserService extends Service {

    protected $userType;

    public function login($email, $password) {
        $user = $this->repository->find('email', $email);

        if (!$user) {
            return (object) [
                        "status" => 404,
                        "message" => __("messages.user.login.404"),
                        "token" => null,
                        "user" => null,
            ];
        }

        if (Hash::check($password, $user->password)) {
            return (object) [
                        "status" => 200,
                        "message" => null,
                        "token" => $this->generateJWTToken($user),
                        "user" => $user,
                        "refresh_token" => $user->generateRefreshToken(),
            ];
        }

        return (object) [
                    "status" => 401,
                    "message" => __("messages.user.login.401"),
                    "token" => null,
                    "user" => null,
                    "refresh_token" => null,
        ];
    }

    protected function generateJWTToken($user) {
        $payload = [
            'iss' => $this->userType, // Issuer of the token
            'sub' => $user->uuid, // Subject of the token
            'iat' => Carbon::now()->timestamp, // Time when JWT was issued.
            'exp' => Carbon::now()->addHours(1)->timestamp, // Expiration time
            'user' => $user, // User
        ];
        return JWT::encode($payload, config("project.private-key.{$this->userType}"), 'RS256');
    }

}
