<?php

return [
    'frontend_url' => env('app_url'),
    // Status codes for responses in the application
    'status_codes' => [
        'success' => 200,
        'created' => 201,
        'server_error' => 500,
        'validation_failed' => 422,
        'bad_request' => 400,
        'forbidden' => 403,
        'not_found' => 404,
    ],
    // Status codes for responses in the application
    'status_texts' => [
        'success' => 'success',
        'created' => 'created',
        'server_error' => 'server_error',
        'validation_failed' => 'validation_failed',
        'bad_request' => 'bad_request',
        'forbidden' => 'forbidden',
        'not_found' => 'not_found',
    ],
];
