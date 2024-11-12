<?php

return [
    [
        'data' => [
            'name' => '__Secure-ID', 'value' => '123', 'domain' => 'example.com', 'secure' => true, 'httpOnly' => true
        ],
        'expect' => 'Set-Cookie: __Secure-ID=123; Domain=example.com; Secure; HttpOnly'
    ],
    [
        'data' => [
            'name' => 'sessionId', 'value' => '38afes7a8', 'maxAge' => 2592000
        ],
        'expect' => 'Set-Cookie: sessionId=38afes7a8; Max-Age=2592000'
    ],
    [
        'data' => [
            'name' => '__Host-example', 'value' => '34d8g', 'sameSite' => 'None', 'secure' => true, 'path' => '/', 'partitioned' => true
        ],
        'expect' => 'Set-Cookie: __Host-example=34d8g; SameSite=None; Secure; Path=/; Partitioned'
    ],
];
