<?php

namespace User;

use User\Model\UserTable;
use Zend\Router\Http\Segment;
use Zend\Router\Http\Literal;
use User\Model\Factory\UserTableFactory;
use User\Controller\Factory\IndexControllerFactory;

return [
    'router' => [
        'routes' => [
            'user' => [
                'type' => Literal::class,
                'options' => [
                    'route' => '/user',
                    'defaults' => [
                        'controller' => Controller\IndexController::class,
                        'action' => 'register',
                    ],
                ],
                'my_terminate' => true,
                'child_routes' => [
                    'default' => [
                        'type' => Segment::class,
                        'options' => [
                            'route' => '[/:action][/token/:token]',
                            'contraints' => [
                                'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'token' => '[[a-f0-9]{32}]$',
                            ],
                        ],
                    ],
                ],
            ],
        ],
    ],
    'controllers' => [
        'factories' => [
            Controller\IndexController::class => IndexControllerFactory::class,
        ],
    ],
    'view_manager' => [
        'template_map' => [
            'user/layout/layout' => __DIR__ . '/../view/layout/layout.phtml',
            'user/index/confirm-email' => __DIR__ . '/../view/user/index/confirm-email.phtml',
            'user/index/register' => __DIR__ . '/../view/user/index/register.phtml',
            'user/index/recover-password' => __DIR__ . '/../view/user/index/recover-password.phtml',
            'user/index/new-password' => __DIR__ . '/../view/user/index/new-password.phtml',
        ],
        'template_path_stack' => [
            __DIR__ . '/../view',
        ],
    ],
    'service_manager' => [
        'factories' => [
            UserTable::class => UserTableFactory::class,
        ]
    ],
];
