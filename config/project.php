<?php

return [
    "public-key" => [
        "user" => file_get_contents(storage_path("jwt/keys/user-auth.key.pub")),
    ],
    "private-key" => [
        "user" => file_get_contents(storage_path("jwt/keys/user-auth.key")),
    ],
    "message-403" => "Access Forbidden",
    "message-419" => "Token expired",
];
