<?php
/**
 * Created by PhpStorm.
 * User: Ivan
 * Date: 25.12.2016
 * Time: 13:44
 */

namespace Subscriber;

use Consumer\Controller\ConsumerController;
use Zend\Router\Http\Segment;


return [


    // The following section is new and should be added to your file:
    'router' => [
        'routes' => [
            'consumer' => [
                'type'    => Segment::class,
                'options' => [
                    'route' => '/consumer[/:action[/:consumerId]]',
                    'constraints' => [
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'consumerId'     => '[0-9]+',
                    ],
                    'defaults' => [
                        'controller' => ConsumerController::class,
                        'action'     => 'index',
                    ],
                ],
            ],
        ],
    ],


    'view_manager' => [
        'template_path_stack' => [
            'album' => __DIR__ . '/../view',
        ],
    ],
];