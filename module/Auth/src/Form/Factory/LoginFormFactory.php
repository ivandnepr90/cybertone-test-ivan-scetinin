<?php
/**
 * Created by PhpStorm.
 * User: Ivan
 * Date: 10.01.2017
 * Time: 23:59
 */

namespace Auth\Form\Factory;


use Auth\Form\LoginForm;
use Interop\Container\ContainerInterface;

class LoginFormFactory
{
    public function __invoke(ContainerInterface $containerInterface) {
        return new LoginForm($containerInterface);
    }
}