<?php
/**
 * Created by PhpStorm.
 * User: Ivan
 * Date: 09.01.2017
 * Time: 23:07
 */

namespace Auth;

use Auth\Controller\Factory\AuthControllerFactory;
use Auth\Controller\Factory\LoginControllerFactory;
use Auth\Controller\LoginController;
use Consumer\Controller\ConsumerController;
use Zend\Authentication\AuthenticationService;
use Zend\Router\Http\Literal;
use Zend\Router\Http\Segment;
use Zend\ServiceManager\Factory\InvokableFactory;
use Group\Controller\GroupController;

return [
    'router' => [
        'routes' => [
            'auth' => [
                'type'    => Segment::class,
                'options' => [
                    'route'    => '/auth[/:action][/:id]',
                    'defaults' => [
                        'controller' => Controller\AuthController::class,
                        'action'     => 'index',
                    ],
                ],
            ],
            'login' => [
                'type'    => Segment::class,
                'options' => [
                    'route'    => '/login[/:action][/:id]',
                    'defaults' => [
                        'controller' => Controller\LoginController::class,
                        'action'     => 'login',
                    ],
                ],
            ],
        ],
    ],
    'controllers' => [
        'factories' => [
            Controller\AuthController::class => AuthControllerFactory::class,
            Controller\LoginController::class => LoginControllerFactory::class
        ],
    ],
    'service_manager' => [
        /*'aliases' => [
            AuthenticationService::class => 'my_auth_service'
        ],*/
        'invokables' => [
            'my_auth_service' => AuthenticationService::class
        ]
    ],
    'view_manager' => [
        'template_path_stack' => [
            __DIR__ . '/../view',
        ],
    ],
];