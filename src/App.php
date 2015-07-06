<?php

namespace FPWeb\App;

use \FPWeb\Request;
use \FPWeb\Response;
use \FPWeb\Route;
use \FPWeb\Util;

/**
 * Processes the request to build a response.
 *
 * @param $routes  array
 * @param $options array
 * @return string
 */
function run(array $routes, array $options = [])
{
    $paramSet = isset($options['param_set'])
        ? $options['param_set']
        : [];
    $params = Request\prepareParams($paramSet);
    $request = Request\parse($params);
    $response = Response\create();
    $pipeline = makePipeline($request, $routes, $options);

    return Util\pipe($pipeline, [
        'request'  => $request,
        'response' => $response,
    ]);
}

function makePipeline(array $request, array $routes, array $options)
{
    $route = Route\match($request, $routes);
    $funs = null;
    if ($route === false) {
        $add404 = function ($conn) {
            $conn['response']['status'] = 404;
            return $conn;
        };

        $funs = isset($options['not_found'])
            ? [[$add404], [$options['not_found']]]
            : [[$add404]];
    } else {
        $funs = [[$route['callback']]];
    }

    $pipeline = isset($options['pipeline'])
        ? $options['pipeline']
        : [];

    return array_merge($pipeline, $funs);
}
