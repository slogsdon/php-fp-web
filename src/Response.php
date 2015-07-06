<?php

namespace FPWeb\Response;

/**
 * Organizes the basic information for a response into a standard format. These
 * array elements will be necessary elsewhere, so if creating a response
 * variable manually without `parse`, be sure to include them.
 *
 * @return array
 */
function create()
{
    return [
        'body'    => '',
        'headers' => [],
        'status'  => 200,
        'assigns' => [],
    ];
}
