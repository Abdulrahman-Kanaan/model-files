<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Default Values For Fileable Sub Arrays
    |--------------------------------------------------------------------------
    |
    | If keys in fileable subarray does not have values, these default values
    | will be filled instead.
    |
    */

    'defaults' => [
        'type' => 'single', // array | single
        'disk' => 'public', // any disk from filesystem
        'path' => '/'
    ]

];
