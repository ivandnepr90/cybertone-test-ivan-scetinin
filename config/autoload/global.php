<?php
/**
 * Global Configuration Override
 *
 * You can use this file for overriding configuration values from modules, etc.
 * You would place values in here that are agnostic to the environment and not
 * sensitive to security.
 *
 * @NOTE: In practice, this file will typically be INCLUDED in your source
 * control, so do not include passwords or other sensitive information in this
 * file.
 */

require_once __DIR__ . '/../application.run.config.php';

return [
    // ...
    'db' => [
        'driver' => 'Pdo',
        'dsn'    => sprintf('mysql:dbname=%s;host=%s;charset=utf8;', DB_NAME, DB_HOST),
        'username' => DB_USER,
        'password' => DB_USER_PASS
    ],

    'modules_layouts' => [
        'Auth' => 'layout/login'
    ],
    'Zend\DB\Adapter\Adapter' => 'Zend\DB\Adapter\AdapterServiceFactory'
];
