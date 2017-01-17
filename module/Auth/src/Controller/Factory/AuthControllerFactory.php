<?php
/**
 * Created by PhpStorm.
 * User: Ivan
 * Date: 09.01.2017
 * Time: 23:18
 */

namespace Auth\Controller\Factory;


use Auth\Controller\AuthController;
use Interop\Container\ContainerInterface;

class AuthControllerFactory
{
    public function __invoke(ContainerInterface $containerInterface)
    {
        // TODO: Implement __invoke() method.
        return new AuthController($containerInterface);
    }
}