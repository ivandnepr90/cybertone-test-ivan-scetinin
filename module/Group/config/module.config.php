<?php
/**
 * Created by PhpStorm.
 * User: Ivan
 * Date: 26.11.2016
 * Time: 17:44
 */

namespace Group;

use Group\Controller\GroupController;
use Zend\Router\Http\Segment;


return [


    // The following section is new and should be added to your file:
    'router' => [
        'routes' => [
            'group' => [
                'type'    => Segment::class,
                'options' => [
                    'route' => '/group[/:action[/:id]]',
                    'constraints' => [
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'groupId'     => '[0-9]+',
                    ],
                    'defaults' => [
                        'controller' => Controller\GroupController::class,
                        'action'     => 'index',
                    ],
                ],
            ],
        ],
    ],


    'view_manager' => [
        'template_path_stack' => [
            'group' => __DIR__ . '/../view',
        ],
    ],
];