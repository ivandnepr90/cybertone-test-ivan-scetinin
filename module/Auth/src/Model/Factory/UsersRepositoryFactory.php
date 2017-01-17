<?php
/**
 * Created by PhpStorm.
 * User: Ivan
 * Date: 10.01.2017
 * Time: 20:06
 */

namespace Auth\Model\Factory;


use Auth\Model\Users;
use Auth\Model\UsersRepository;
use Interop\Container\ContainerInterface;
use Zend\Db\Adapter\AdapterInterface;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;

class UsersRepositoryFactory
{
    function __invoke(ContainerInterface $containerInterface) {
        $resultPrototype = new ResultSet();
        $resultPrototype->setArrayObjectPrototype($containerInterface->get(Users::class));
        return new UsersRepository(new TableGateway('users', $containerInterface->get(AdapterInterface::class),null, $resultPrototype));
    }
}