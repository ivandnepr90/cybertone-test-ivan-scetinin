<?php
/**
 * Created by PhpStorm.
 * User: Ivan
 * Date: 10.01.2017
 * Time: 20:05
 */

namespace Auth\Model\Factory;


use Auth\Model\Users;
use Interop\Container\ContainerInterface;

class UsersFactory
{
    public function __invoke(ContainerInterface $containerInterface) {
        return new Users();
    }
}