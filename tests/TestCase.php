<?php

use Firebase\JWT\JWT;

abstract class TestCase extends Laravel\Lumen\Testing\TestCase {

    /**
     * Creates the application.
     *
     * @return \Laravel\Lumen\Application
     */
    public function createApplication() {
        return require __DIR__ . '/../bootstrap/app.php';
    }

    public function debug($response, $flag = false) {
        $string = $response->response->getContent();
        if ($flag) {
            $string = preg_replace('/\s+/', ' ', trim($response->response->getContent()));
        }

        dd($string);
    }

    public function decode($response) {
        return json_decode($response->response->getContent());
    }

    public function AgentHeader($user) {
        $agent = JWT::encode([
                    "iss" => env('SERVICE_NAME'),
                    "sub" => $user->uuid,
                    "iat" => \Carbon\Carbon::now()->timestamp,
                    "exp" => \Carbon\Carbon::now()->addHours(1)->timestamp,
                    "user" => [
                        "uuid" => $user->uuid,
                        "email" => $user->email,
                        "first_name" => $user->first_name,
                        "last_name" => $user->last_name,
                        "middle_initial" => $user->middle_initial,
                        "contact_number" => $user->contact_number,
                        "branch_uuid" => $user->branch_uuid,
                    ]
                        ], config('project.private-key.agent'), 'RS256');
        return ["Authorization" => $agent];
    }

    public function CustomerHeader($user) {
        $customer = JWT::encode([
                    "iss" => env('SERVICE_NAME'),
                    "sub" => $user->uuid,
                    "iat" => \Carbon\Carbon::now()->timestamp,
                    "exp" => \Carbon\Carbon::now()->addHours(1)->timestamp,
                    "user" => [
                        "uuid" => $user->uuid,
                        "email" => $user->email,
                        "first_name" => $user->first_name,
                        "last_name" => $user->last_name,
                        "middle_initial" => $user->middle_initial,
                        "contact_number" => $user->contact_number,
                    ]
                        ], config('project.private-key.customer'), 'RS256');
        return ["Authorization" => $customer];
    }

    public function AdminHeader($user) {
        $admin = JWT::encode([
                    "iss" => env('SERVICE_NAME'),
                    "sub" => $user->uuid,
                    "iat" => \Carbon\Carbon::now()->timestamp,
                    "exp" => \Carbon\Carbon::now()->addHours(1)->timestamp,
                    "user" => [
                        "uuid" => $user->uuid,
                        "username" => $user->username
                    ]
                        ], config('project.private-key.admin'), 'RS256');
        return ["Authorization" => $admin];
    }

}
