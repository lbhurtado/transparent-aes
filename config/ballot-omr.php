<?php

return [
    /*
    |--------------------------------------------------------------------------
    | The default OMR Driver
    |--------------------------------------------------------------------------
    |
    | The default omr driver to use as a fallback when no driver is specified
    | while using the OMR component.
    |
    */
    'default' => env('OMR_DRIVER', 'simple-omr'),

    'simple-omr' => config('simple-omr')
];