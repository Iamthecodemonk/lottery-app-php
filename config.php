<?php
// Allow manual override via environment variable
$env = getenv('APP_ENV');
if (!$env) {
    $host = isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : (isset($_SERVER['SERVER_NAME']) ? $_SERVER['SERVER_NAME'] : '');
    $localHosts = ['localhost', '127.0.0.1', '::1'];
    $env = in_array($host, $localHosts) ? 'development' : 'production';
}

$config = [
    'development' => [
        'servername' => '',
        'hostname' => 'localhost',
        'password' => '',
        'user' => 'root',
        'dbname' => 'blueloto',
        'serverpathname' => '/lt/'
    ],
    'production' => [
       'servername' => '',
        'hostname' => 'localhost',
        'password' => '',
        'user' => 'root',
        'dbname' => 'blueloto',
        'serverpathname' => '/lt/'
    ]
];
// $config = [
//     'development' => [
//         'servername' => 'https://blueextralotto.com/',
//         'hostname' => 'localhost',
//         'password' => 'au{*=l@)]lKt',
//         'user' => 'blueextra_loto',
//         'dbname' => 'blueextra_loto',
//         'serverpathname' => '/lt/'
//     ],
//     'production' => [
//         'servername' => 'https://blueextralotto.com/',
//         'hostname' => 'localhost',
//         'password' => 'au{*=l@)]lKt',
//         'user' => 'blueextra_loto',
//         'dbname' => 'blueextra_loto',
//         'serverpathname' => '/lt/'
//     ]
// ];

return $config[$env];
