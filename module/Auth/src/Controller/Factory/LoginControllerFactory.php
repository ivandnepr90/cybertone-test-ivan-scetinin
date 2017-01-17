<?php
/**
 * Created by PhpStorm.
 * User: Ivan
 * Date: 10.01.2017
 * Time: 22:20
 */

namespace Auth\Controller\Factory;


use Auth\Controller\LoginController;
use Interop\Container\ContainerInterface;

class LoginControllerFactory
{
    public function __invoke(ContainerInterface $containerInterface) {
        return new LoginController($containerInterface);
    }
}