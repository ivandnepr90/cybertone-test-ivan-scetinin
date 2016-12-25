<?php
/**
 * Created by PhpStorm.
 * User: Ivan
 * Date: 26.11.2016
 * Time: 17:40
 */

namespace Consumer;

use Zend\Db\Adapter\AdapterInterface;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;
use Zend\ModuleManager\Feature\ConfigProviderInterface;


class Module implements ConfigProviderInterface
{
    public function getConfig() {
        return include __DIR__ . '/../config/module.config.php';
    }

    public function getServiceConfig()
    {
        return [
            'factories' => [
                Model\ConsumerTable::class => function($container) {
                    $tableGateway = $container->get(Model\ConsumerTableGateway::class);
                    return new Model\ConsumerTable($tableGateway);
                },
                Model\ConsumerTableGateway::class => function ($container) {
                    $dbAdapter = $container->get(AdapterInterface::class);
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new Model\Consumer());
                    return new TableGateway('consumer', $dbAdapter, null, $resultSetPrototype);
                },
            ],
        ];
    }

    public function getControllerConfig()
    {
        return [
            'factories' => [
                Controller\ConsumerController::class => function($container) {
                    return new Controller\ConsumerController(
                        $container->get(Model\ConsumerTable::class)
                    );
                },
            ],
        ];
    }
}