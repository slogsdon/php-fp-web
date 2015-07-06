<?php

require '../vendor/autoload.php';

use \FPWeb\App;
use \FPWeb\Route;

// index handler
$index = function ($conn) {
    // TODO: make this process nicer
    $conn['response']['body'] = 'index';
    return $conn;
};

// create routes
$routes = [
    Route\get('/index', $index),
];

// match request and run match
$response = App\run($routes, [
    'param_set' => [$_GET, $_POST],
    'not_found' => function ($conn) {
        $conn['response']['body'] = 'Not Found';
        return $conn;
    },
]);

printf('<pre><code>%s</code></pre>', print_r($response, true));
