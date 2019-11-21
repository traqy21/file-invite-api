<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\UserService as Service;

class UserController extends Controller {

    public function __construct(Service $service) {
        $this->service = $service;
    }

    public function register(Request $request) {
        $this->validate($request, [
            'email' => 'required|unique:customers,email',
            'password' => 'required',
            'first_name' => 'required',
            'last_name' => 'required',
            'middle_initial' => 'required',
            'contact_number' => 'required',
        ]);

        $result = $this->service->create($request->all());

        return response()->json([
                    "message" => $result->message,
                    "model" => $result->model
                        ], $result->status);
    }

    public function login(Request $request) {
        $this->validate($request, [
            'email' => 'required',
            'password' => 'required'
        ]);

        $login = $this->service->login($request->email, $request->password);
        if ($login->status == 200) {
            return response()->json([
                        "message" => null,
                        "user" => $login->user,
                        "token" => $login->token,
                        "refresh_token" => $login->refresh_token,
            ]);
        }

        return response()->json([
                    "message" => $login->message,
                    "user" => null,
                    "token" => null,
                    "refresh_token" => null,
                        ], $login->status);
    }

}
