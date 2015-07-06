<?php

namespace FPWeb\Request;

/**
 * Organizes the basic information for a request into a standard format. These
 * array elements will be necessary elsewhere, so if creating a request
 * variable manually without `parse`, be sure to include them.
 *
 * @param $params array
 * @return array
 */
function parse(array $params = array())
{
    return [
        'uri'    => trim($_SERVER['REQUEST_URI'], '/'),
        'server' => $_SERVER,
        'params' => $params,
    ];
}

/**
 * Merges a set of arrays from accepted parameter avenues. This is similar to
 * `$_REQUEST` but can be modified without changes to a `php.ini` and may
 * include a normalization in the future.
 *
 * @param $paramSet array
 * @return array
 */
function prepareParams(array $paramSet)
{
    $params = [];
    foreach ($paramSet as $paramArray) {
        $params = array_merge($params, $paramArray);
    }
    unset($paramArray);
    return $params;
}
