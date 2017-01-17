<?php
/**
 * Created by PhpStorm.
 * User: Ivan
 * Date: 11.01.2017
 * Time: 1:34
 */

namespace Auth\Storage\Factory;


use Auth\Storage\Authenticate;
use Auth\Storage\AuthStorage;
use Interop\Container\ContainerInterface;
use Zend\Authentication\AuthenticationService;
use Zend\Authentication\Adapter\DbTable\CredentialTreatmentAdapter as AuthAdapter;
use Zend\Db\Adapter\AdapterInterface;

class AuthenticateFactory
{
    public function __invoke(ContainerInterface $container)
    {
        //$Myconfig=$container->get("EP_CONFIG");
        $dbAdapter = $container -> get(AdapterInterface::class);
        $dbTableAuthAdapter = new AuthAdapter(
            $dbAdapter,
            'users',
            'email',
            'password',
            "MD5('123456') AND level = 1"
            );
        $authService = new AuthenticationService();
        $authService->setAdapter($dbTableAuthAdapter);
        $authService->setStorage(new AuthStorage());
        return new Authenticate($authService);
        // TODO: Implement __invoke() method.
    }
}