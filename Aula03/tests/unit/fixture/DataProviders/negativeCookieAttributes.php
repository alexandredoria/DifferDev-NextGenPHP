<?php

return [
    [
        'data' => [
            'name' => '__Secure-ID', 'value' => '123', 'domain' => '.example.com'
        ],
    ],
    [
        'data' => [
            'name' => 'sessionId', 'value' => '38a7a8', 'maxAge' => -20
        ],
    ],
    [
        'data' => [
            'name' => 'sessionId', 'value' => '38afes7a8', 'maxAge' => '-2'
        ],
    ],
    [
        'data' => [
            'name' => '__Host-example', 'value' => '34d8g', 'sameSite' => 'none'
        ],
    ],
    [
        'data' => [
            'name' => '__Host-example', 'value' => '34d8g', 'path' => 'aço'
        ],
    ],
    [
        'data' => [
            'name' => '__Host-example', 'value' => '34d8g', 'path' => 'docs'
        ],
    ],
    [
        'data' => [
            'name' => '__Host-example', 'value' => '34d8g', 'path' => '//docs'
        ],
    ],
];
