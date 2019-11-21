<?php

/**
 * Validate the JWT Auth Token to prevent hacker
 */

namespace App\ThirdParty\Jwt;

use Closure;
use Illuminate\Http\Request;

/**
 * Validate the JWT Auth Token to prevent hacker
 */
class TokenAuthMiddleware {

    /**
     * Validate the JWT Auth Token to prevent hacker
     *
     * @param \Illuminate\Http\Request $request Request object
     * @param \Closure $next Callback function
     * @return Closure
     */
    public function handle(Request $request, Closure $next, $role) {
        $validate = TokenAuthFacades::validateToken($request, $role);

        if ($validate->status == 200) {
            return $next($request);
        } else {
            return response()->json([
                        "message" => $validate->message
                            ], $validate->status);
        }
    }

}
