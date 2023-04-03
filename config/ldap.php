<?php

$ldap = json_decode(file_get_contents(__DIR__ . '../../public/ldap.json'), true);

return [

    /*
    |--------------------------------------------------------------------------
    | Default LDAP Connection Name
    |--------------------------------------------------------------------------
    |
    | Here you may specify which of the LDAP connections below you wish
    | to use as your default connection for all LDAP operations. Of
    | course you may add as many connections you'd like below.
    |
    */

    'default' => env('LDAP_CONNECTION', 'default'),

    /*
    |--------------------------------------------------------------------------
    | LDAP Connections
    |--------------------------------------------------------------------------
    |
    | Below you may configure each LDAP connection your application requires
    | access to. Be sure to include a valid base DN - otherwise you may
    | not receive any results when performing LDAP search operations.
    |
    */

    'connections' => [
        'default' => [
            'hosts' => [env('LDAP_HOST', $ldap['default']['hosts'])],
            'username' => env('LDAP_USERNAME', $ldap['default']['username']),
            'password' => env('LDAP_PASSWORD', $ldap['default']['password']),
            'port' => env('LDAP_PORT', $ldap['default']['port']),
            'base_dn' => env('LDAP_BASE_DN', $ldap['default']['base_dn']),
            'timeout' => env('LDAP_TIMEOUT', $ldap['default']['timeout']),
            'use_ssl' => env('LDAP_SSL', $ldap['default']['use_ssl']),
            'use_tls' => env('LDAP_TLS', $ldap['default']['use_tls']),
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | LDAP Logging
    |--------------------------------------------------------------------------
    |
    | When LDAP logging is enabled, all LDAP search and authentication
    | operations are logged using the default application logging
    | driver. This can assist in debugging issues and more.
    |
    */

    'logging' => env('LDAP_LOGGING', true),

    /*
    |--------------------------------------------------------------------------
    | LDAP Cache
    |--------------------------------------------------------------------------
    |
    | LDAP caching enables the ability of caching search results using the
    | query builder. This is great for running expensive operations that
    | may take many seconds to complete, such as a pagination request.
    |
    */

    'cache' => [
        'enabled' => env('LDAP_CACHE', false),
        'driver' => env('CACHE_DRIVER', 'file'),
    ],

];
