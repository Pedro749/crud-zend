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

return [
    'db' => [
        'driver' => 'Pdo_Mysql',
        'host' => 'desenvolvimento.cntsistemas.com.br',
        'username' => 'cntsistemas',
        'password' => 'cnt2022Maria',
        'database' => 'zf3_helpdesk',
    ],
    'mail' => [
        'name' => 'sandbox.smtp.mailtrap.io',
        'host' => 'sandbox.smtp.mailtrap.io',
        'port' => 2525,
        'connection_class' => 'login',
        'connection_config' => [
            'from' => 'pedro@pedro.com',
            'username' => '629c56f16a2f59',
            'password' => '7c3b02060ce77a',
            'auth' => 'CRAM-MD5'
        ],
    ],
];
