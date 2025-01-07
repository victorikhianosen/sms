<?php


return [
    'smpp' => [
        'system_id'   => env('SMPP_SYSTEM_ID', 'novsmptx'),
        'system_type' => env('SMPP_SYSTEM_TYPE', 'smpp'),
        'password'    => env('SMPP_PASSWORD', 'txnovsmp'),
        'host'        => env('SMPP_HOST', '172.31.131.241'),
        'port'        => env('SMPP_PORT', 7661),
    ],
];

