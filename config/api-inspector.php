<?php

// config for Irabbi360/LaravelApiInspector
return [
    // changes doc title
    'title' => 'Laravel API Inspector',
    'enabled' => true,

    /*
    * Route where request docs will be served from laravel app.
    * localhost:8080/api-docs
    */
    'route_path' => 'api-docs',

    /*
    |--------------------------------------------------------------------------
    | API Inspector Assets Path
    |--------------------------------------------------------------------------
    | The path to the API Inspector assets.
    |
    */

    'assets_path' => 'vendor/api-inspector',

    'output' => [
        'openapi' => true,
        'postman' => true,
        'html' => true,
    ],

    /*
    |--------------------------------------------------------------------------
    | Response Capture Configuration
    |--------------------------------------------------------------------------
    | Phase 2: Runtime response capture and caching
    |
    */

    'save_responses' => true,

    'save_responses_driver' => 'json', // 'cache' or 'json'

    'middleware_capture' => true,

    'response_ttl' => 3600, // TTL for cached responses in seconds (1 hour)

    'auth' => [
        'type' => 'bearer',
        'header' => 'Authorization',
    ],

    'response_path' => 'api-docs', // Subfolder name

    'storage_path' => 'storage', // 'storage' or 'local'

    // Use only routes where ->uri start with next string Using Str::startWith( . e.g. - /api/mobile
    'only_route_uri_start_with' => 'api/',

    'hide_matching' => [
        'api-inspector-docs',
        'api-inspector',
        'sanctum',
        'telescope',
        'docs',
        '_ignition',
    ],

    // By default, LAPI groups your routes by the first /path.
    // This is a set of regex to group your routes by prefix.
    'group_by' => [
        'uri_patterns' => [
            '^api/v[\d]+/', // `/api/v1/users/store` group as `/api/v1/users`.
            '^api/',        // `/api/users/store` group as `/api/users`.
        ],
    ],

    /*
    * Can be used to define default response status codes to be shown in the docs
    */
    'default_responses' => ['200', '400', '401', '403', '404', '405', '422', '429', '500', '503'],

    /*
    |--------------------------------------------------------------------------
    | Pagination Schema
    |--------------------------------------------------------------------------
    | Define the structure of pagination metadata when @LAPIpagination is used.
    | Matches Laravel's default pagination response structure.
    |
    */
    'pagination_schema' => [
        'data' => 'array',
        'links' => [
            'first' => 'string',
            'last' => 'string',
            'prev' => 'string | null',
            'next' => 'string | null',
        ],
        'meta' => [
            'current_page' => 'integer',
            'from' => 'integer | null',
            'last_page' => 'integer',
            'path' => 'string',
            'per_page' => 'integer',
            'to' => 'integer | null',
            'total' => 'integer',
            'links' => 'array',
        ],
        'show_pagination' => ['links', 'meta'],
    ],

    /*
    |--------------------------------------------------------------------------
    | Analytics, Dashboard, and Advanced Features
    |--------------------------------------------------------------------------
    */

    'analytics' => [
        'enabled' => true,
        'track_response_time' => true,
        'track_memory_usage' => true,
        'track_errors' => true,
        'retention_days' => 30, // Keep analytics for 30 days
        'track_only_uri_start_with' => 'api/',
        'exclude_routes' => [
            'api-inspector-docs',
            'api-inspector',
            'sanctum',
            'telescope',
            'docs',
            '_ignition',
        ],
    ],

    'dashboard' => [
        'enabled' => true,
        'auth_middleware' => ['web'], // Middleware for dashboard protection
    ],

    'webhooks' => [
        // 'user.created' => [
        //     'event' => 'user.created',
        //     'description' => 'Fired when a new user is created',
        //     'url' => 'https://example.com/webhooks/user/created',
        //     'method' => 'POST',
        //     'payload' => [
        //         'id' => 'integer',
        //         'email' => 'string',
        //         'name' => 'string',
        //     ],
        //     'examples' => [],
        //     'active' => true,
        // ],
    ],

    'auth_testing' => [
        'enabled' => true,
        'schemes' => ['bearer', 'api-key', 'basic', 'oauth2'],
        'test_endpoint_prefix' => '/api/',
    ],
];
