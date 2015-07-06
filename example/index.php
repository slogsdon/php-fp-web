<?php

require '../vendor/autoload.php';

use \FPWeb\Request;
use \FPWeb\Route;

// bundle params
$params = Request\prepareParams([$_GET, $_POST]);

// index handler
$index = function ($request) {
    return 'index';
};

// create routes
$routes = [
    Route\get('/index', $index),
];

// parse request
$request = Request\parse($params);

// match request and run match
echo Route\run($request, $routes, [
    'not_found' => function () {
        return 'Not Found';
    },
]);
