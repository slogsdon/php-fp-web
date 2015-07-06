<?php

namespace FPWeb\Util;

/**
 * Introduces idea of a function pipeline similar to the pipe operator found in
 * Unix based systems and some function programming languages. The return value
 * of one function in `$functions` is passed as the first argument of the
 * proceeding function in `$functions`.
 *
 * @param $functions array
 * @param $initial   mixed
 * @return mixed
 */
function pipe(array $functions, $initial = null)
{
    $value = $initial;
    while ($function = array_shift($functions)) {
        $fun = $function[0];
        $arguments = isset($function[1])
            ? $function[1]
            : [];
        $args = array_merge([$value], $arguments);
        $value = call_user_func_array($fun, $args);
    }
    return $value;
}

/**
 * Removes extraneous default headers, e.g. X-Powered-By.
 *
 * TODO: Mkae this nicer/more testable. $force is a shim.
 *
 * @param $force boolean
 * @return boolean
 */
function resetHeaders($force = false)
{
    if (!headers_sent() || $force) {
        foreach (headers_list() as $header) {
            $name = explode(':', $header)[0];
            header_remove($name);
        }
        return true;
    }
    return false;
}
