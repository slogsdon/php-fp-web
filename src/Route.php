<?php

namespace FPWeb\Route;

use FPWeb\Util;

const FOUND              = 0;
const NOT_FOUND          = 1;
const METHOD_NOT_ALLOWED = 2;

/**
 * Attempts to find a match for the current request, returning the route on
 * match or false on a no match.
 *
 * @param $request array
 * @param $routes  array
 * @return string
 */
function match(array $request, array $routes)
{
    $match = [NOT_FOUND];
    $method = $request['server']['REQUEST_METHOD'];
    foreach ($routes as $route) {
        $patternMatched = $request['uri'] === $route['pattern'];
        $methodAllowed = !isset($route['options']['method']) ||
            $method === $route['options']['method'];

        if ($patternMatched && $methodAllowed) {
            $match = [FOUND, $route];
            break;
        }

        if ($patternMatched && !$methodAllowed) {
            $match = [METHOD_NOT_ALLOWED];
        }
    }
    return $match;
}

/**
 * Puts infomation for a route into the expected format.
 *
 * @param $pattern  string
 * @param $callback callable
 * @param $options  array
 * @return array
 */
function create($pattern, callable $callback, array $options = [])
{
    return [
        'pattern'  => trim($pattern, '/'),
        'callback' => $callback,
        'options'  => $options,
    ];
}

/**
 * Puts infomation for a `GET` route into the expected format.
 *
 * @param $pattern  string
 * @param $callback callable
 * @param $options  array
 * @return array
 */
function get($pattern, callable $callback, array $options = [])
{
    $options = array_merge($options, ['method' => 'GET']);
    return create($pattern, $callback, $options);
}

/**
 * Puts infomation for a `POST` route into the expected format.
 *
 * @param $pattern  string
 * @param $callback callable
 * @param $options  array
 * @return array
 */
function post($pattern, callable $callback, array $options = [])
{
    $options = array_merge($options, ['method' => 'POST']);
    return create($pattern, $callback, $options);
}

/**
 * Puts infomation for a `PUT` route into the expected format.
 *
 * @param $pattern  string
 * @param $callback callable
 * @param $options  array
 * @return array
 */
function put($pattern, callable $callback, array $options = [])
{
    $options = array_merge($options, ['method' => 'PUT']);
    return create($pattern, $callback, $options);
}

/**
 * Puts infomation for a `PATCH` route into the expected format.
 *
 * @param $pattern  string
 * @param $callback callable
 * @param $options  array
 * @return array
 */
function patch($pattern, callable $callback, array $options = [])
{
    $options = array_merge($options, ['method' => 'PATCH']);
    return create($pattern, $callback, $options);
}

/**
 * Puts infomation for a `DELETE` route into the expected format.
 *
 * @param $pattern  string
 * @param $callback callable
 * @param $options  array
 * @return array
 */
function delete($pattern, callable $callback, array $options = [])
{
    $options = array_merge($options, ['method' => 'DELETE']);
    return create($pattern, $callback, $options);
}

/**
 * Puts infomation for an `OPTIONS` route into the expected format.
 *
 * @param $pattern  string
 * @param $callback callable
 * @param $options  array
 * @return array
 */
function options($pattern, callable $callback, array $options = [])
{
    $options = array_merge($options, ['method' => 'OPTIONS']);
    return create($pattern, $callback, $options);
}

/**
 * Puts infomation for a `TRACE` route into the expected format.
 *
 * @param $pattern  string
 * @param $callback callable
 * @param $options  array
 * @return array
 */
function trace($pattern, callable $callback, array $options = [])
{
    $options = array_merge($options, ['method' => 'TRACE']);
    return create($pattern, $callback, $options);
}
