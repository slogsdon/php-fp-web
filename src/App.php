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
    $pipeline = wrapPipeline($request, $routes, $options);

    return Util\pipe($pipeline, [
        'request'  => $request,
        'response' => $response,
    ]);
}

function wrapPipeline(array $request, array $routes, array $options)
{
    $match = Route\match($request, $routes);
    $routedHandler = null;
    $successful = false;

    switch ($match[0]) {
        case Route\NOT_FOUND:
            $routedHandler = [createStatusHandler(404)];
            break;
        case Route\METHOD_NOT_ALLOWED:
            $routedHandler = [createStatusHandler(405)];
            break;
        case Route\FOUND:
            $successful = true;
            $routedHandler = [$match[1]['callback']];
            break;
    }

    $pipeline = isset($options['pipeline'])
        ? $options['pipeline']
        : [];

    $handlers = [$routedHandler];
    if (!$successful && isset($options['on_error'])) {
        $optional = [$options['on_error']];
        $handlers = array_merge($handlers, [$optional]);
    }

    return array_merge($pipeline, $handlers);
}

function createStatusHandler($status)
{
    return function ($conn) use ($status) {
        $conn['response']['status'] = $status;
        return $conn;
    };
}
