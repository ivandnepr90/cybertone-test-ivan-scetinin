<?php
/**
 * Created by PhpStorm.
 * User: Ivan
 * Date: 10.01.2017
 * Time: 23:59
 */

namespace Auth\Form\Factory;


use Auth\Form\LoginFilter;
use Interop\Container\ContainerInterface;

class LoginFilterFactory
{
    public function __invoke(ContainerInterface $containerInterface)
    {
        return new LoginFilter($containerInterface);
    }
}