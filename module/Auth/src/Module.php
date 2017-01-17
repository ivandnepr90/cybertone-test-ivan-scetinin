<?php
/**
 * Created by PhpStorm.
 * User: Ivan
 * Date: 09.01.2017
 * Time: 23:04
 */

namespace Auth;


use Auth\Form\Factory\LoginFilterFactory;
use Auth\Form\Factory\LoginFormFactory;
use Auth\Form\LoginFilter;
use Auth\Form\LoginForm;
use Auth\Model\Factory\UsersFactory;
use Auth\Model\Factory\UsersRepositoryFactory;
use Auth\Model\Users;
use Auth\Model\UsersRepository;
use Auth\Storage\Authenticate;
use Auth\Storage\Factory\AuthenticateFactory;
use Zend\ModuleManager\Feature\ConfigProviderInterface;
use Zend\ModuleManager\Feature\ControllerProviderInterface;
use Zend\ModuleManager\Feature\ServiceProviderInterface;
use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;

class Module implements ConfigProviderInterface, ServiceProviderInterface, ControllerProviderInterface
{

    /**
     * Returns configuration to merge with application configuration
     *
     * @return array|\Traversable
     */
    public function getConfig()
    {
        // TODO: Implement getConfig() method.
        return include __DIR__ . '/../config/module.config.php';
    }

    /**
     * Expected to return \Zend\ServiceManager\Config object or array to seed
     * such an object.
     *
     * @return array|\Zend\ServiceManager\Config
     */
    public function getControllerConfig()
    {
        // TODO: Implement getControllerConfig() method.
    }

    /**
     * Expected to return \Zend\ServiceManager\Config object or array to
     * seed such an object.
     *
     * @return array|\Zend\ServiceManager\Config
     */
    public function getServiceConfig()
    {
        // TODO: Implement getServiceConfig() method.
        return [
            'factories' => [
                Users::class => UsersFactory::class,
                UsersRepository::class => UsersRepositoryFactory::class,
                LoginForm::class => LoginFormFactory::class,
                LoginFilter::class => LoginFilterFactory::class,
                Authenticate::class => AuthenticateFactory::class
            ]
        ];
    }

    public function onBootstrap(MvcEvent $e)
    {
        $eventManager = $e->getApplication()->getEventManager();
        $eventManager->getSharedManager()->attach('Zend\Mvc\Controller\AbstractActionController', 'dispatch', function ($e) {
            $controller = $e->getTarget();
            $controllerClass = get_class($controller);
            $moduleNamespace = substr($controllerClass, 0, strpos($controllerClass, '\\'));
            $config = $e->getApplication()->getServiceManager()->get('config');
            if (isset($config['module_layouts'][$moduleNamespace])) {
                $controller->layout($config['module_layouts'][$moduleNamespace]);
            }
        }, 100);
        $moduleRouteListener = new ModuleRouteListener();
        $moduleRouteListener->attach($eventManager);

    }
}